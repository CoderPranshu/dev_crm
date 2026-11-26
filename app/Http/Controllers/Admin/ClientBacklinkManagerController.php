<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Backlink;

use App\Models\BacklinkAssignment;

use App\Models\ClientBacklinkImport;

use App\Models\SeoPlanClient;

use App\Services\BacklinkFileReader;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\ValidationException;

class ClientBacklinkManagerController extends Controller

{

    public function index(Request $request, SeoPlanClient $seoPlanClient)

    {

        $seoPlanClient->load(['company', 'seoPlan', 'assignedUser']);

        $assignmentsQuery = $seoPlanClient

            ->backlinkAssignments()

            ->with(['backlink.category', 'assignedUser', 'assignedBy', 'backlinkImport']);

        if ($request->filled('search')) {

            $search = trim((string) $request->input('search'));

            $assignmentsQuery->where(function ($query) use ($search) {

                $query->where('username', 'like', '%' . $search . '%')

                    ->orWhereHas('backlink', function ($backlinkQuery) use ($search) {

                        $backlinkQuery->where('website_url', 'like', '%' . $search . '%')

                            ->orWhere('domain_authority', 'like', '%' . $search . '%')

                            ->orWhere('page_authority', 'like', '%' . $search . '%');

                    });

            });

        }

        if (in_array($request->input('status'), ['assigned', 'completed'], true)) {

            $assignmentsQuery->where('status', $request->input('status'));

        }

        $assignments = $assignmentsQuery

            ->latest('id')

            ->paginate(20, ['*'], 'backlinks_page')

            ->withQueryString();

        $totalBacklinks = $seoPlanClient->backlinkAssignments()->count();

        $assignedBacklinks = $seoPlanClient

            ->backlinkAssignments()

            ->where('status', 'assigned')

            ->count();

        $completedBacklinks = $seoPlanClient

            ->backlinkAssignments()

            ->where('status', 'completed')

            ->count();

        $totalImports = $seoPlanClient->backlinkImports()->count();

        $recentImports = $seoPlanClient

            ->backlinkImports()

            ->with(['category', 'uploadedBy'])

            ->latest('id')

            ->limit(5)

            ->get();

        return view('admin.seo-client-backlinks.index', compact('seoPlanClient', 'assignments', 'totalBacklinks', 'assignedBacklinks', 'completedBacklinks', 'totalImports', 'recentImports'));

    }

    public function upload(SeoPlanClient $seoPlanClient)

    {

        $seoPlanClient->load(['company', 'assignedUser']);

        return view(

            'admin.seo-client-backlinks.upload',

compact('seoPlanClient')

        );

    }

    public function prepare(

Request $request,

SeoPlanClient $seoPlanClient,

BacklinkFileReader $reader

) {

        $request->validate([

            'file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:51200'],

        ]);

        $file = $request->file('file');

        $extension = strtolower((string) $file->getClientOriginalExtension());

        if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {

            throw ValidationException::withMessages([

                'file' => 'Only CSV, XLSX and XLS files are allowed.',

            ]);

        }

        $path = $file->store(

            'seo-clients/' . $seoPlanClient->getKey() . '/backlinks',

            'backlink_files'

        );

        if (!$path) {

            return back()->withInput()->with('error', 'The uploaded file could not be saved.');

        }

        try {

            $inspection = $reader->inspect(

Storage::disk('backlink_files')->path($path),

                $extension

            );

            $clientBacklinkImport = $seoPlanClient->backlinkImports()->create([

                'uploaded_by' => auth()->id(),

                'original_name' => mb_substr(

basename(str_replace('\\', '/', $file->getClientOriginalName())),

                    0,

                    240

                ),

                'path' => $path,

                'extension' => $extension,

                'size' => (int) $file->getSize(),

                'headers' => $inspection['headers'],

                'status' => ClientBacklinkImport::STATUS_PENDING,

            ]);

        } catch (\Throwable $exception) {

Storage::disk('backlink_files')->delete($path);

report($exception);

            if ($exception instanceof ValidationException) {

                throw $exception;

            }

            return back()

                ->withInput()

                ->with('error', 'File could not be read. Check its format and try again.');

        }

        return redirect()->route(

            'admin.seo-client-backlinks.mapping',

            [$seoPlanClient, $clientBacklinkImport]

        );

    }

    public function mapping(

SeoPlanClient $seoPlanClient,

ClientBacklinkImport $clientBacklinkImport,

BacklinkFileReader $reader

) {

        $this->ensureImportBelongsToClient($seoPlanClient, $clientBacklinkImport);

        if ($clientBacklinkImport->status === ClientBacklinkImport::STATUS_COMPLETED) {

            return redirect()->route('admin.seo-client-backlinks.index', $seoPlanClient);

        }

        $inspection = $reader->inspect(

            $this->filePath($clientBacklinkImport),

            $clientBacklinkImport->extension

        );

        $headers = $inspection['headers'];

        $preview = $inspection['preview'];

        $defaultMapping = $this->autoMapping($headers);

        $categories = DB::table('backlink_categories')->orderBy('id')->get();

        $seoPlanClient->load('company');

        return view(

            'admin.seo-client-backlinks.mapping',

compact(

                'seoPlanClient',

                'clientBacklinkImport',

                'headers',

                'preview',

                'defaultMapping',
                'categories'

            )

        );

    }

    public function process(

Request $request,

SeoPlanClient $seoPlanClient,

ClientBacklinkImport $clientBacklinkImport,

BacklinkFileReader $reader

) {

        $this->ensureImportBelongsToClient($seoPlanClient, $clientBacklinkImport);

        if ($clientBacklinkImport->status === ClientBacklinkImport::STATUS_COMPLETED) {

            return redirect()

                ->route('admin.seo-client-backlinks.index', $seoPlanClient)

                ->with('success', 'This file has already been imported.');

        }

        $lastColumn = count((array) $clientBacklinkImport->headers) - 1;

        if ($lastColumn < 0) {

            throw ValidationException::withMessages([

                'mapping' => 'The uploaded file does not contain a header row.',

            ]);

        }

        $request->validate([

            'mapping' => ['required', 'array'],

            'mapping.website_url' => ['required', 'integer', 'min:0', 'max:' . $lastColumn],

            'mapping.domain_authority' => ['nullable', 'integer', 'min:0', 'max:' . $lastColumn],

            'mapping.page_authority' => ['nullable', 'integer', 'min:0', 'max:' . $lastColumn],

            'mapping.username' => ['required', 'integer', 'min:0', 'max:' . $lastColumn],

            'mapping.password' => ['required', 'integer', 'min:0', 'max:' . $lastColumn],
            'backlink_category_id' => ['required', 'integer', 'exists:backlink_categories,id'],

        ]);

        $mapping = $request->input('mapping');
        $categoryId = (int) $request->input('backlink_category_id');

        $selectedColumns = array_filter(

            $mapping,

            fn ($value) => $value !== null && $value !== ''

        );

        if (count(array_unique(array_map('intval', $selectedColumns))) !== count($selectedColumns)) {

            throw ValidationException::withMessages([

                'mapping' => 'Choose a different source column for every destination field.',

            ]);

        }

        $path = $this->filePath($clientBacklinkImport);

        try {

            $result = DB::transaction(function () use (

                $seoPlanClient,

                $clientBacklinkImport,

                $reader,

                $path,

                $mapping,
                $categoryId

            ) {

                $lockedImport = ClientBacklinkImport::query()

                    ->whereKey($clientBacklinkImport->getKey())

                    ->lockForUpdate()

                    ->firstOrFail();

                $this->ensureImportBelongsToClient($seoPlanClient, $lockedImport);

                if ($lockedImport->status === ClientBacklinkImport::STATUS_COMPLETED) {

                    return $lockedImport;

                }

                $lockedImport->update([

                    'status' => ClientBacklinkImport::STATUS_PROCESSING,

                    'error_message' => null,

                ]);

                $totalRows = 0;

                $imported = 0;

                $skipped = 0;

                $invalid = 0;

                foreach ($reader->rows($path, $lockedImport->extension) as $rowNumber => $row) {

                    if ($rowNumber === 1) {

                        continue;

                    }

                    $hasValue = count(array_filter(

                        $row,

                        fn ($value) => $value !== null && trim((string) $value) !== ''

                    )) > 0;

                    if (!$hasValue) {

                        continue;

                    }

                    $totalRows++;

                    $website = trim((string) ($row[(int) $mapping['website_url']] ?? ''));

                    $username = trim((string) ($row[(int) $mapping['username']] ?? ''));

                    $password = trim((string) ($row[(int) $mapping['password']] ?? ''));

                    if (

                        !$this->isValidWebsite($website)

                        || $username === ''

                        || $password === ''

                        || mb_strlen($username) > 255

                        || mb_strlen($password) > 255

                    ) {

                        $invalid++;

                        continue;

                    }

                    $validAuthorities = true;

                    $domainAuthority = $this->authority(

                        $row,

                        $mapping['domain_authority'] ?? null,

                        $validAuthorities

                    );

                    $pageAuthority = $this->authority(

                        $row,

                        $mapping['page_authority'] ?? null,

                        $validAuthorities

                    );

                    if (!$validAuthorities) {

                        $invalid++;

                        continue;

                    }

// Match an existing global URL or create it in the selected category.
                    // Credentials remain on the client assignment below.
                    $backlink = Backlink::firstOrCreate(
                        ['website_url' => $website],
                        [
                            'backlink_category_id' => $categoryId,
                            'domain_authority' => $domainAuthority,
                            'page_authority' => $pageAuthority,
                            'created_by' => auth()->id(),
                        ]
                    );

                    $alreadyAssigned = BacklinkAssignment::query()

                        ->where('seo_plan_client_id', $seoPlanClient->getKey())

                        ->where('backlink_id', $backlink->getKey())

                        ->exists();

                    if ($alreadyAssigned) {

                        $skipped++;

                        continue;

                    }

BacklinkAssignment::create([

                        'seo_plan_client_id' => $seoPlanClient->getKey(),

                        'client_backlink_import_id' => $lockedImport->getKey(),

                        'backlink_id' => $backlink->getKey(),

                        'assigned_to' => $seoPlanClient->team_id,

                        'assigned_by' => auth()->id(),

                        'username' => $username,

                        'password' => $password,

                        'status' => 'completed',

                        'assigned_at' => now(),

                    ]);

                    $imported++;

                }

                $lockedImport->update([

                    'mapping' => $mapping,

                    'total_rows' => $totalRows,

                    'imported' => $imported,

                    'skipped' => $skipped,

                    'invalid' => $invalid,

                    'status' => ClientBacklinkImport::STATUS_COMPLETED,

                    'processed_at' => now(),

                    'error_message' => null,

                ]);

                return $lockedImport->fresh();

            });

        } catch (\Throwable $exception) {

report($exception);

ClientBacklinkImport::query()

                ->whereKey($clientBacklinkImport->getKey())

                ->where('status', '!=', ClientBacklinkImport::STATUS_COMPLETED)

                ->update([

                    'status' => ClientBacklinkImport::STATUS_FAILED,

                    'error_message' => mb_substr($exception->getMessage(), 0, 1000),

                ]);

            if ($exception instanceof ValidationException) {

                throw $exception;

            }

            return back()

                ->withInput()

                ->with('error', 'Import failed. No partial client assignments were saved.');

        }

        return redirect()

            ->route('admin.seo-client-backlinks.index', $seoPlanClient)

            ->with(

                'success',

                "Imported: {$result->imported} | Duplicates: {$result->skipped} | Invalid: {$result->invalid}"

            );

    }

    private function ensureImportBelongsToClient(

SeoPlanClient $seoPlanClient,

ClientBacklinkImport $clientBacklinkImport

): void {

abort_unless(

            (int) $clientBacklinkImport->seo_plan_client_id === (int) $seoPlanClient->getKey(),

            404

        );

    }

    private function filePath(ClientBacklinkImport $clientBacklinkImport): string

    {

abort_unless(

Storage::disk('backlink_files')->exists($clientBacklinkImport->path),

            404,

            'The uploaded source file is missing.'

        );

        return Storage::disk('backlink_files')->path($clientBacklinkImport->path);

    }

    private function isValidWebsite(string $website): bool

    {

        if ($website === '' || mb_strlen($website) > 255) {

            return false;

        }

        if (!filter_var($website, FILTER_VALIDATE_URL)) {

            return false;

        }

        return in_array(

strtolower((string) parse_url($website, PHP_URL_SCHEME)),

            ['http', 'https'],

            true

        );

    }

    private function authority(array $row, $columnIndex, bool &$valid): ?int

    {

        if ($columnIndex === null || $columnIndex === '') {

            return null;

        }

        $value = trim((string) ($row[(int) $columnIndex] ?? ''));

        if ($value === '') {

            return null;

        }

        if (

            !is_numeric($value)

            || (float) $value < 0

            || (float) $value > 100

            || floor((float) $value) !== (float) $value

        ) {

            $valid = false;

            return null;

        }

        return (int) $value;

    }

    private function autoMapping(array $headers): array

    {

        $aliases = [

            'website_url' => ['websiteurl', 'website', 'url', 'siteurl', 'backlinkurl', 'domain'],

            'domain_authority' => ['domainauthority', 'da', 'domainrating', 'dr'],

            'page_authority' => ['pageauthority', 'pa', 'pagerating', 'pr'],

            'username' => ['username', 'user', 'login', 'loginid', 'email'],

            'password' => ['password', 'pass', 'passwd', 'loginpassword'],

        ];

        $mapping = [

            'website_url' => null,

            'domain_authority' => null,

            'page_authority' => null,

            'username' => null,

            'password' => null,

        ];

        foreach ($headers as $index => $header) {

            $normalised = strtolower((string) preg_replace('/[^a-z0-9]+/i', '', (string) $header));

            foreach ($aliases as $field => $fieldAliases) {

                if ($mapping[$field] === null && in_array($normalised, $fieldAliases, true)) {

                    $mapping[$field] = (int) $index;

                    break;

                }

            }

        }

        return $mapping;

    }

}