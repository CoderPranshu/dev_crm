<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Lead, LeadCategory, Deal};
use Carbon\Carbon;

use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Support\Facades\DB;

use App\Models\User;

use App\Models\LeadAction;

use App\Models\DetailedQuotation;
use Illuminate\Support\Facades\URL;

use App\Models\Proforma;
use App\Models\ProformaItem;
use App\Models\Product;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

use App\Models\LeadImportBatch;
use Illuminate\Support\Str;









class LeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:lead-list|lead-create|lead-edit|lead-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:lead-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:lead-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lead-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request, $id = null)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        |
        | Admin:
        |   - All Pending + Contacted leads
        |   - Assigned + Unassigned
        |
        | Sales:
        |   - Only Pending + Contacted leads assigned to logged-in Sales user
        |
        | Other:
        |   - Only Pending + Contacted leads assigned to logged-in user
        |
        */

        $baseQuery = Lead::query()
            ->whereIn('status', [
                'pending',
                'contacted',
            ]);


        /*
        |--------------------------------------------------------------------------
        | USER ACCESS
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            /*
            * Admin sees all pending/contacted leads.
            */

        } else {

            /*
            * Sales + other users see only their assigned leads.
            */

            $baseQuery->where(
                'user_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        if ($id) {

            $baseQuery->where(
                'categories_id',
                $id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD COUNTS
        |--------------------------------------------------------------------------
        */

        $totalLeads = (clone $baseQuery)
            ->count();


        $csvLeads = (clone $baseQuery)
            ->where(
                'source',
                'csv'
            )
            ->count();


        $manualLeads = (clone $baseQuery)
            ->where(function ($q) {

                $q->where(
                    'source',
                    'manual'
                )
                ->orWhereNull(
                    'source'
                );
            })
            ->count();


        $pendingLeads = (clone $baseQuery)
            ->where(
                'status',
                'pending'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CONTACTED COUNT
        |--------------------------------------------------------------------------
        */

        $contactedLeads = (clone $baseQuery)
            ->where(
                'status',
                'contacted'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | MAIN QUERY
        |--------------------------------------------------------------------------
        */

        $query = clone $baseQuery;


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'phone',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'remarks',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'requirement',
                        'like',
                        "%{$search}%"
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SOURCE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('source')) {

            if (
                $request->source === 'csv'
            ) {

                $query->where(
                    'source',
                    'csv'
                );

            } elseif (
                $request->source === 'manual'
            ) {

                $query->where(
                    function ($q) {

                        $q->where(
                            'source',
                            'manual'
                        )
                        ->orWhereNull(
                            'source'
                        );
                    }
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Only pending/contacted are allowed.
        |
        | Even if someone manually changes URL:
        |
        | ?status=reject
        |
        | reject will NOT be returned.
        |
        */

        if ($request->filled('status')) {

            $allowedStatuses = [
                'pending',
                'contacted',
            ];


            if (
                in_array(
                    $request->status,
                    $allowedStatuses,
                    true
                )
            ) {

                $query->where(
                    'status',
                    $request->status
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ASSIGNED USER FILTER
        |--------------------------------------------------------------------------
        |
        | Only Admin can:
        |
        | - Filter by Sales user
        | - Filter unassigned leads
        |
        */

        if (
            $user->hasRole('Admin') &&
            $request->filled('assigned_user')
        ) {

            if (
                $request->assigned_user ===
                'unassigned'
            ) {

                $query->whereNull(
                    'user_id'
                );

            } else {

                $query->where(
                    'user_id',
                    $request->assigned_user
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GET LEADS
        |--------------------------------------------------------------------------
        */

        // $leads = $query
        //     ->with([
        //         'leadcat',
        //         'assignedUser',
        //     ])
        //     ->latest()
        //     ->paginate(25)
        //     ->withQueryString();

        $allowedPerPage = [25, 100, 200, 500];

        $perPage = (int) $request->get('per_page', 25);

        if ($request->get('per_page') === 'custom') {
            $perPage = (int) $request->get('custom_per_page', 25);
        }

        $perPage = max(1, min($perPage, 1000));

        $leads = $query
            ->with([
                'leadcat',
                'assignedUser',
            ])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();



        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories =
            LeadCategory::orderBy(
                'title'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CATEGORY COUNTS
        |--------------------------------------------------------------------------
        |
        | Only Pending + Contacted should be counted.
        |
        */

        $categoryCountQuery =
            Lead::query()
                ->whereIn(
                    'status',
                    [
                        'pending',
                        'contacted',
                    ]
                );


        /*
        |--------------------------------------------------------------------------
        | SALES ACCESS FOR CATEGORY COUNTS
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin')
        ) {

            $categoryCountQuery->where(
                'user_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY COUNTS RESULT
        |--------------------------------------------------------------------------
        */

        $categoryCounts =
            $categoryCountQuery
                ->selectRaw(
                    'categories_id, COUNT(*) as total'
                )
                ->groupBy(
                    'categories_id'
                )
                ->pluck(
                    'total',
                    'categories_id'
                );


        /*
        |--------------------------------------------------------------------------
        | SALES USERS
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            $salesUsers =
                User::role('Sales')
                    ->orderBy(
                        'name'
                    )
                    ->get();

        } else {

            $salesUsers =
                collect();
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.leads.index',
            compact(
                'leads',
                'categories',
                'categoryCounts',
                'salesUsers',
                'totalLeads',
                'csvLeads',
                'manualLeads',
                'pendingLeads',
                'contactedLeads'
            )
        );
    }


    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'digits:10',
            ],

            'email' => [
                'required',
                'email',
            ],

            'requirement' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'categories_id' => [
                'required',
                'exists:lead_categories,id',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'sales_user_id' => [
                'required',
                'exists:users,id',
            ],

        ], [

            'name.required' =>
                'Lead name is required.',

            'phone.required' =>
                'Phone number is required.',

            'phone.digits' =>
                'Phone number must be exactly 10 digits.',

            'email.required' =>
                'Email address is required.',

            'email.email' =>
                'Please enter a valid email address.',

            'requirement.required' =>
                'Requirement is required.',

            'categories_id.required' =>
                'Please select a category.',

            'branch_id.required' =>
                'Please select a branch.',

            'sales_user_id.required' =>
                'Please select a Sales Person.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $currentUser = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDATE SALES PERSON
        |--------------------------------------------------------------------------
        |
        | exists:users,id alone enough nahi hai.
        | Selected user ka Sales role bhi hona chahiye.
        |
        */

        $salesUser = \App\Models\User::role('Sales')
            ->where(
                'id',
                $request->sales_user_id
            )
            ->first();


        if (!$salesUser) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error_message',
                    'Selected user is not a valid Sales user.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NON ADMIN BRANCH SECURITY
        |--------------------------------------------------------------------------
        |
        | Non-admin apni branch ke bahar ke Sales Person
        | ko lead assign nahi kar sakta.
        |
        */

        if (
            !$currentUser->hasRole('Admin')
            &&
            (int) $salesUser->branch_id
            !==
            (int) $currentUser->branch_id
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error_message',
                    'You cannot assign leads to a Sales Person from another branch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN BRANCH / SALES PERSON CHECK
        |--------------------------------------------------------------------------
        |
        | Admin ne jo branch select ki hai,
        | Sales Person bhi same branch ka hona chahiye.
        |
        */

        if (
            (int) $salesUser->branch_id
            !==
            (int) $request->branch_id
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error_message',
                    'Selected Sales Person does not belong to the selected branch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE LEAD
        |--------------------------------------------------------------------------
        */

        $response = Lead::create([

            'name' =>
                $data['name'],

            'phone' =>
                $data['phone'],

            'email' =>
                $data['email'],

            'requirement' =>
                $data['requirement'],

            'address' =>
                $data['address'] ?? null,

            /*
            * Selected Category
            */
            'categories_id' =>
                $data['categories_id'],

            /*
            * Selected Sales Person
            *
            * Form field = sales_user_id
            * Lead DB field = user_id
            */
            'user_id' =>
                $salesUser->id,

            /*
            * Sales Person ki branch
            */
            'branch_id' =>
                $salesUser->branch_id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        if ($response) {

            return redirect()
                ->back()
                ->with(
                    'success_message',
                    'Lead Created Successfully'
                );
        }


        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error_message',
                'Something went wrong'
            );
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'requirement' => 'required|string',
            'address' => 'nullable',
            'categories_id' => 'nullable'
        ]);

        $response = $lead->update($data);

        if ($response) {
            return redirect()->back()->with('success_message', 'Lead updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function destroy(Request $request, $id)
    {
        $lead = Lead::where('id', $id)->firstOrFail();

        $res = $lead->delete();

        if ($res) {
            return redirect()->back()->with('success_message', 'Lead deleted successfully');
        }
    }

    public function statuschange(Request $request, $id)
    {
        $lead = Lead::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'status' => 'required|string',
            'user_id' => 'nullable|string',
            'remarks' => 'nullable',
            'call_schedule' => 'nullable'
        ]);

        $res = $lead->update([
            'status' => $data['status'],
            'user_id' => $data['user_id'],
            'remarks' => $data['remarks'],
            'call_schedule' => $data['call_schedule']
        ]);

        if ($data['status'] == 'accept') {
            $res = Deal::create([
                'leads_id' => $lead->id,
                'title' => $lead->name,
                'requirement' => $lead->requirement,
                'assign_to' => $lead->user_id,
                'company_id' => $lead->company_id,
            ]);
        }

        if ($res) {
            return redirect()->back()->with('success_message', 'Details updated successsfully');
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    // public function callAgain($id = null)
    // {
    //     $user = auth()->user();

    //     // Base query (status = call)
    //     $query = Lead::where('status', 'call');

    //     if ($user->hasRole('Admin')) {
    //         // Admin → no extra filter
    //     }
    //     elseif ($user->hasRole('Sales')) {
    //         // Sales → branch-wise
    //         $query->where('branch_id', $user->branch_id);
    //     }
    //     else {
    //         // Others → only assigned leads
    //         $query->where('user_id', $user->id);
    //     }

    //     // Category filter
    //     if ($id) {
    //         $query->where('categories_id', $id);
    //     }

    //     $leads = $query->get();
    //     $categories = LeadCategory::all();

    //     // Category counts (same role logic)
    //     $countQuery = Lead::where('status', 'call');

    //     if ($user->hasRole('Admin')) {
    //         // no filter
    //     }
    //     elseif ($user->hasRole('Sales')) {
    //         $countQuery->where('branch_id', $user->branch_id);
    //     }
    //     else {
    //         $countQuery->where('user_id', $user->id);
    //     }

    //     $categoryCounts = $countQuery
    //         ->selectRaw('categories_id, COUNT(*) as total')
    //         ->groupBy('categories_id')
    //         ->pluck('total', 'categories_id');

    //     return view('admin.leads.callagain', compact('leads', 'categories', 'categoryCounts'));
    // }

    public function callAgain($id = null)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        | Sirf status = call
        */
        $query = Lead::query()
            ->where('status', 'call');


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        |
        | Admin:
        |   → All Call Again leads
        |
        | Sales / Other users:
        |   → Only leads assigned to logged-in user
        |
        */
        if (!$user->hasRole('Admin')) {

            $query->where(
                'user_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */
        if ($id) {

            $query->where(
                'categories_id',
                $id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LEADS
        |--------------------------------------------------------------------------
        */
        $leads = $query
            ->with([
                'leadcat',
                'assignedUser',
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */
        $categories = LeadCategory::all();


        /*
        |--------------------------------------------------------------------------
        | CATEGORY COUNT BASE QUERY
        |--------------------------------------------------------------------------
        */
        $countQuery = Lead::query()
            ->where('status', 'call');


        if (!$user->hasRole('Admin')) {

            $countQuery->where(
                'user_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL CALL AGAIN
        |--------------------------------------------------------------------------
        */
        $totalCallAgain = (clone $countQuery)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CATEGORY COUNTS
        |--------------------------------------------------------------------------
        */
        $categoryCounts = $countQuery
            ->selectRaw(
                'categories_id, COUNT(*) as total'
            )
            ->groupBy(
                'categories_id'
            )
            ->pluck(
                'total',
                'categories_id'
            );


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.leads.callagain',
            compact(
                'leads',
                'categories',
                'categoryCounts',
                'totalCallAgain'
            )
        );
    }

    public function export($id = null)
    {
        $query = \App\Models\Lead::with('leadcat');

        if (!empty($id)) {
            $query->where('categories_id', $id);
        }

        $leads = $query->get();

        $categoryName = 'all';

        if (!empty($id)) {
            $category = \App\Models\LeadCategory::find($id);
            $categoryName = $category ? $category->title : 'category';
        }

        $categoryName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $categoryName);
        $filename = 'leads_' . $categoryName . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Title',
                'Phone',
                'Remarks',
                'Requirement',
                'Category',
                'Status',
            ]);

            foreach ($leads as $key => $lead) {
                fputcsv($file, [
                    $key + 1,
                    $lead->name ?? '',
                    $lead->phone ?? '',
                    $lead->remarks ?? '',
                    $lead->requirement ?? '',
                    $lead->leadcat->title ?? '',
                    $lead->status ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadSampleCsv()
    {
        $filename = 'leads_sample.csv';
        $path = storage_path('app/' . $filename);

        $file = fopen($path, 'w');

        fputcsv($file, [
            'name',
            'phone',
            'remarks',
            'requirement',
            'category',
            'status',
            'lead_date',
        ]);

        fputcsv($file, [
            'Rohan Sharma',
            '9876543210',
            'Interested customer',
            'ERP software demo',
            'Software',
            'Call again',
            '2026-03-19',
        ]);

        fputcsv($file, [
            'Priya Verma',
            '9123456780',
            'Asked for quotation',
            'HRM module',
            'HR',
            'New',
            '19/03/2026',
        ]);

        fclose($file);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    // 

    // public function importPreview()
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | GET IMPORT SESSION
    //     |--------------------------------------------------------------------------
    //     */

    //     $importData = session('lead_import');

    //     if (
    //         !$importData ||
    //         empty($importData['file'])
    //     ) {
    //         return response(
    //             '<div style="
    //                 font-family: Arial, sans-serif;
    //                 padding: 20px;
    //                 color: #b91c1c;
    //                 background: #fef2f2;
    //                 border: 1px solid #fecaca;
    //             ">
    //                 Import session expired. Please upload the file again.
    //             </div>',
    //             419
    //         );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | TEMP FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     $fileName = basename(
    //         $importData['file']
    //     );

    //     $filePath = storage_path(
    //         'app/temp/lead-imports/' . $fileName
    //     );

    //     if (!file_exists($filePath)) {
    //         return response(
    //             '<div style="
    //                 font-family: Arial, sans-serif;
    //                 padding: 20px;
    //                 color: #b91c1c;
    //                 background: #fef2f2;
    //                 border: 1px solid #fecaca;
    //             ">
    //                 Uploaded file is no longer available.
    //             </div>',
    //             404
    //         );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | FILE EXTENSION
    //     |--------------------------------------------------------------------------
    //     */

    //     $extension = strtolower(
    //         pathinfo(
    //             $filePath,
    //             PATHINFO_EXTENSION
    //         )
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | READ CSV / EXCEL
    //     |--------------------------------------------------------------------------
    //     */

    //     try {

    //         if (
    //             $extension === 'csv' ||
    //             $extension === 'txt'
    //         ) {

    //             $reader = new Csv();

    //             $reader->setDelimiter(',');
    //             $reader->setEnclosure('"');

    //             $spreadsheet = $reader->load(
    //                 $filePath
    //             );

    //         } elseif (
    //             $extension === 'xlsx' ||
    //             $extension === 'xls'
    //         ) {

    //             $spreadsheet = IOFactory::load(
    //                 $filePath
    //             );

    //         } else {

    //             return response(
    //                 'Unsupported file format.',
    //                 422
    //             );
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | ACTIVE SHEET
    //         |--------------------------------------------------------------------------
    //         */

    //         $worksheet =
    //             $spreadsheet->getActiveSheet();


    //         /*
    //         |--------------------------------------------------------------------------
    //         | CONVERT TO ARRAY
    //         |--------------------------------------------------------------------------
    //         */

    //         $rows = $worksheet->toArray(
    //             null,
    //             true,
    //             true,
    //             false
    //         );

    //     } catch (\Throwable $e) {

    //         return response(
    //             '<div style="
    //                 font-family: Arial, sans-serif;
    //                 padding: 20px;
    //                 color: #b91c1c;
    //             ">
    //                 Unable to preview this CSV/Excel file.
    //             </div>',
    //             422
    //         );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | EMPTY FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     if (empty($rows)) {

    //         if (isset($spreadsheet)) {
    //             $spreadsheet->disconnectWorksheets();
    //             unset($spreadsheet);
    //         }

    //         return response(
    //             'The uploaded file is empty.',
    //             422
    //         );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | FIRST ROW = HEADERS
    //     |--------------------------------------------------------------------------
    //     */

    //     $headers = array_shift(
    //         $rows
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAN HEADERS
    //     |--------------------------------------------------------------------------
    //     */

    //     $headers = array_map(
    //         function ($header) {

    //             $header =
    //                 (string) ($header ?? '');

    //             $header = preg_replace(
    //                 '/^\xEF\xBB\xBF/',
    //                 '',
    //                 $header
    //             );

    //             return trim($header);

    //         },
    //         $headers
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | LIMIT PREVIEW TO FIRST 30 DATA ROWS
    //     |--------------------------------------------------------------------------
    //     */

    //     $previewRows = array_slice(
    //         $rows,
    //         0,
    //         30
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | TOTAL DATA ROW COUNT
    //     |--------------------------------------------------------------------------
    //     */

    //     $totalRows = count(
    //         $rows
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAN MEMORY
    //     |--------------------------------------------------------------------------
    //     */

    //     if (isset($spreadsheet)) {
    //         $spreadsheet->disconnectWorksheets();
    //         unset($spreadsheet);
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | PREVIEW VIEW
    //     |--------------------------------------------------------------------------
    //     */

    //     return view(
    //         'admin.leads.import_preview',
    //         compact(
    //             'headers',
    //             'previewRows',
    //             'totalRows',
    //             'fileName'
    //         )
    //     );
    // }

    public function importPreview()
{
    /*
    |--------------------------------------------------------------------------
    | GET IMPORT SESSION
    |--------------------------------------------------------------------------
    */

    $importData = session('lead_import');


    if (
        !$importData ||
        empty($importData['batch_id']) ||
        empty($importData['file_path'])
    ) {

        return response(
            '<div style="
                font-family: Arial, sans-serif;
                padding: 20px;
                color: #b91c1c;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 8px;
            ">
                Import session expired. Please upload the file again.
            </div>',
            419
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT BATCH
    |--------------------------------------------------------------------------
    */

    $importBatch =
        \App\Models\LeadImportBatch::find(
            $importData['batch_id']
        );


    if (!$importBatch) {

        return response(
            '<div style="
                font-family: Arial, sans-serif;
                padding: 20px;
                color: #b91c1c;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 8px;
            ">
                Import batch was not found.
            </div>',
            404
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CURRENT USER / SECURITY
    |--------------------------------------------------------------------------
    */

    $currentUser = auth()->user();


    if (
        !$currentUser->hasRole('Admin') &&
        (int) $importBatch->branch_id !==
        (int) $currentUser->branch_id
    ) {

        abort(
            403,
            'You are not allowed to preview this import.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PERMANENT FILE PATH
    |--------------------------------------------------------------------------
    */

    $fileRelativePath =
        $importData['file_path']
        ?? $importBatch->file_path;


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE PATH
    |--------------------------------------------------------------------------
    */

    $fileRelativePath = ltrim(
        str_replace(
            '\\',
            '/',
            $fileRelativePath
        ),
        '/'
    );


    /*
    |--------------------------------------------------------------------------
    | SECURITY CHECK
    |--------------------------------------------------------------------------
    */

    if (
        str_contains(
            $fileRelativePath,
            '../'
        ) ||
        !str_starts_with(
            $fileRelativePath,
            'lead-imports/'
        )
    ) {

        return response(
            '<div style="
                font-family: Arial, sans-serif;
                padding: 20px;
                color: #b91c1c;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 8px;
            ">
                Invalid import file path.
            </div>',
            422
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ABSOLUTE FILE PATH
    |--------------------------------------------------------------------------
    */

    $filePath =
        storage_path(
            'app/' .
            $fileRelativePath
        );


    /*
    |--------------------------------------------------------------------------
    | FILE MUST EXIST
    |--------------------------------------------------------------------------
    */

    if (!file_exists($filePath)) {

        return response(
            '<div style="
                font-family: Arial, sans-serif;
                padding: 20px;
                color: #b91c1c;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 8px;
            ">
                Uploaded file is no longer available.
            </div>',
            404
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORIGINAL FILE NAME
    |--------------------------------------------------------------------------
    */

    $fileName =
        $importBatch->original_file_name
        ?: basename($filePath);


    /*
    |--------------------------------------------------------------------------
    | FILE EXTENSION
    |--------------------------------------------------------------------------
    */

    $extension = strtolower(
        pathinfo(
            $filePath,
            PATHINFO_EXTENSION
        )
    );


    /*
    |--------------------------------------------------------------------------
    | READ CSV / EXCEL
    |--------------------------------------------------------------------------
    */

    try {

        if (
            $extension === 'csv' ||
            $extension === 'txt'
        ) {

            $reader = new Csv();

            $reader->setDelimiter(',');
            $reader->setEnclosure('"');

            $spreadsheet =
                $reader->load(
                    $filePath
                );

        } elseif (
            $extension === 'xlsx' ||
            $extension === 'xls'
        ) {

            $spreadsheet =
                IOFactory::load(
                    $filePath
                );

        } else {

            return response(
                '<div style="
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    color: #b91c1c;
                ">
                    Unsupported file format.
                </div>',
                422
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ACTIVE SHEET
        |--------------------------------------------------------------------------
        */

        $worksheet =
            $spreadsheet->getActiveSheet();


        /*
        |--------------------------------------------------------------------------
        | CONVERT SHEET TO ARRAY
        |--------------------------------------------------------------------------
        */

        $rows =
            $worksheet->toArray(
                null,
                true,
                true,
                false
            );

    } catch (\Throwable $e) {

        return response(
            '<div style="
                font-family: Arial, sans-serif;
                padding: 20px;
                color: #b91c1c;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 8px;
            ">
                Unable to preview this CSV/Excel file.
            </div>',
            422
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY FILE CHECK
    |--------------------------------------------------------------------------
    */

    if (empty($rows)) {

        if (isset($spreadsheet)) {

            $spreadsheet
                ->disconnectWorksheets();

            unset($spreadsheet);
        }

        return response(
            'The uploaded file is empty.',
            422
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FIRST ROW = HEADERS
    |--------------------------------------------------------------------------
    */

    $headers =
        array_shift(
            $rows
        );


    /*
    |--------------------------------------------------------------------------
    | CLEAN HEADERS
    |--------------------------------------------------------------------------
    */

    $headers =
        array_map(
            function ($header) {

                $header =
                    (string) (
                        $header ?? ''
                    );

                $header =
                    preg_replace(
                        '/^\xEF\xBB\xBF/',
                        '',
                        $header
                    );

                return trim(
                    $header
                );
            },
            $headers
        );


    /*
    |--------------------------------------------------------------------------
    | REMOVE EMPTY TRAILING COLUMNS
    |--------------------------------------------------------------------------
    */

    while (
        count($headers) > 0 &&
        trim(
            (string) end($headers)
        ) === ''
    ) {

        array_pop(
            $headers
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE COMPLETELY EMPTY DATA ROWS
    |--------------------------------------------------------------------------
    */

    $rows =
        array_values(
            array_filter(
                $rows,
                function ($row) {

                    foreach ($row as $value) {

                        if (
                            trim(
                                (string) (
                                    $value ?? ''
                                )
                            ) !== ''
                        ) {

                            return true;
                        }
                    }

                    return false;
                }
            )
        );


    /*
    |--------------------------------------------------------------------------
    | TOTAL DATA ROWS
    |--------------------------------------------------------------------------
    */

    $totalRows =
        count(
            $rows
        );


    /*
    |--------------------------------------------------------------------------
    | PREVIEW FIRST 30 DATA ROWS
    |--------------------------------------------------------------------------
    */

    $previewRows =
        array_slice(
            $rows,
            0,
            30
        );


    /*
    |--------------------------------------------------------------------------
    | CLEAN SPREADSHEET MEMORY
    |--------------------------------------------------------------------------
    */

    if (isset($spreadsheet)) {

        $spreadsheet
            ->disconnectWorksheets();

        unset($spreadsheet);
    }


    /*
    |--------------------------------------------------------------------------
    | RETURN PREVIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.leads.import_preview',
        compact(
            'headers',
            'previewRows',
            'totalRows',
            'fileName',
            'importBatch'
        )
    );
}



    // public function importMapping()
    // {
    //     $importData = session('lead_import');

    //     if (
    //         !$importData ||
    //         empty($importData['file']) ||
    //         empty($importData['sales_user_id']) ||
    //         empty($importData['category_id']) ||
    //         !isset($importData['headers']) ||
    //         !isset($importData['fields']) ||
    //         !isset($importData['auto_mapping'])
    //     ) {
    //         return redirect()
    //             ->route('admin.leads.index')
    //             ->with(
    //                 'error_message',
    //                 'Import session expired. Please upload the file again.'
    //             );
    //     }

    //     $currentUser = auth()->user();

    //     $salesUser = \App\Models\User::role('Sales')
    //         ->where(
    //             'id',
    //             $importData['sales_user_id']
    //         )
    //         ->first();

    //     if (!$salesUser) {
    //         return redirect()
    //             ->route('admin.leads.index')
    //             ->with(
    //                 'error_message',
    //                 'Selected Sales user is no longer available.'
    //             );
    //     }

    //     if (
    //         !$currentUser->hasRole('Admin') &&
    //         (int) $salesUser->branch_id !==
    //         (int) $currentUser->branch_id
    //     ) {
    //         abort(
    //             403,
    //             'You cannot assign leads to Sales users from another branch.'
    //         );
    //     }

    //     $leadCategory = \App\Models\LeadCategory::find(
    //         $importData['category_id']
    //     );

    //     if (!$leadCategory) {
    //         return redirect()
    //             ->route('admin.leads.index')
    //             ->with(
    //                 'error_message',
    //                 'Selected Lead Category is no longer available.'
    //             );
    //     }

    //     $headers = $importData['headers'];
    //     $fields = $importData['fields'];
    //     $autoMapping = $importData['auto_mapping'];

    //     $fileName = basename(
    //         $importData['file']
    //     );

    //     $filePath = storage_path(
    //         'app/temp/lead-imports/' . $fileName
    //     );

    //     if (!file_exists($filePath)) {
    //         session()->forget('lead_import');

    //         return redirect()
    //             ->route('admin.leads.index')
    //             ->with(
    //                 'error_message',
    //                 'Uploaded import file expired. Please upload it again.'
    //             );
    //     }

    //     return view(
    //         'admin.leads.import_mapping',
    //         compact(
    //             'headers',
    //             'fields',
    //             'autoMapping',
    //             'salesUser',
    //             'leadCategory'
    //         )
    //     );
    // }

    public function importMapping()
    {
        /*
        |--------------------------------------------------------------------------
        | GET IMPORT SESSION
        |--------------------------------------------------------------------------
        */

        $importData = session('lead_import');

        if (
            !$importData ||
            empty($importData['batch_id']) ||
            empty($importData['file']) ||
            empty($importData['file_path']) ||
            empty($importData['sales_user_id']) ||
            empty($importData['category_id']) ||
            !isset($importData['headers']) ||
            !isset($importData['fields']) ||
            !isset($importData['auto_mapping'])
        ) {

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import session expired. Please upload the file again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $currentUser = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | IMPORT BATCH
        |--------------------------------------------------------------------------
        */

        $importBatch =
            \App\Models\LeadImportBatch::find(
                $importData['batch_id']
            );

        if (!$importBatch) {

            session()->forget('lead_import');

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import batch was not found. Please upload the file again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BATCH ACCESS SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            !$currentUser->hasRole('Admin') &&
            (int) $importBatch->branch_id !==
            (int) $currentUser->branch_id
        ) {

            abort(
                403,
                'You are not allowed to access this import batch.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SALES USER
        |--------------------------------------------------------------------------
        */

        $salesUser =
            \App\Models\User::role('Sales')
                ->where(
                    'id',
                    $importData['sales_user_id']
                )
                ->first();

        if (!$salesUser) {

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Selected Sales user is no longer available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NON ADMIN BRANCH SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            !$currentUser->hasRole('Admin') &&
            (int) $salesUser->branch_id !==
            (int) $currentUser->branch_id
        ) {

            abort(
                403,
                'You cannot assign leads to Sales users from another branch.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MAKE SURE BATCH SALES MATCHES SESSION
        |--------------------------------------------------------------------------
        */

        if (
            (int) $importBatch->sales_user_id !==
            (int) $salesUser->id
        ) {

            session()->forget('lead_import');

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import Sales assignment does not match the import batch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LEAD CATEGORY
        |--------------------------------------------------------------------------
        */

        $leadCategory =
            \App\Models\LeadCategory::find(
                $importData['category_id']
            );

        if (!$leadCategory) {

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Selected Lead Category is no longer available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MAKE SURE BATCH CATEGORY MATCHES SESSION
        |--------------------------------------------------------------------------
        */

        if (
            (int) $importBatch->category_id !==
            (int) $leadCategory->id
        ) {

            session()->forget('lead_import');

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import Category does not match the import batch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MAPPING DATA
        |--------------------------------------------------------------------------
        */

        $headers =
            $importData['headers'];

        $fields =
            $importData['fields'];

        $autoMapping =
            $importData['auto_mapping'];


        /*
        |--------------------------------------------------------------------------
        | PERMANENT FILE PATH
        |--------------------------------------------------------------------------
        |
        | OLD:
        |
        | storage/app/temp/lead-imports/file.xlsx
        |
        | NEW:
        |
        | storage/app/lead-imports/2026/09/file.xlsx
        |
        */

        $fileRelativePath =
            $importData['file_path']
            ?? $importBatch->file_path;


        /*
        |--------------------------------------------------------------------------
        | NORMALIZE FILE PATH
        |--------------------------------------------------------------------------
        */

        $fileRelativePath = ltrim(
            str_replace(
                '\\',
                '/',
                $fileRelativePath
            ),
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                $fileRelativePath,
                '../'
            ) ||
            !str_starts_with(
                $fileRelativePath,
                'lead-imports/'
            )
        ) {

            session()->forget('lead_import');

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Invalid import file path.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ABSOLUTE FILE PATH
        |--------------------------------------------------------------------------
        */

        $filePath =
            storage_path(
                'app/' .
                $fileRelativePath
            );


        /*
        |--------------------------------------------------------------------------
        | FILE MUST EXIST
        |--------------------------------------------------------------------------
        */

        if (!file_exists($filePath)) {

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Uploaded import file was not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ORIGINAL FILE NAME FOR VIEW
        |--------------------------------------------------------------------------
        */

        $fileName =
            $importBatch->original_file_name
            ?: basename($filePath);


        /*
        |--------------------------------------------------------------------------
        | RETURN MAPPING PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.leads.import_mapping',
            compact(
                'headers',
                'fields',
                'autoMapping',
                'salesUser',
                'leadCategory',
                'importBatch',
                'fileName'
            )
        );
    }

    // public function prepareImport(Request $request)
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | VALIDATION
    //     |--------------------------------------------------------------------------
    //     */

    //     $request->validate([
    //         'file' => [
    //             'required',
    //             'file',
    //             'mimes:csv,txt,xlsx,xls',
    //             'max:10240',
    //         ],

    //         'sales_user_id' => [
    //             'required',
    //             'exists:users,id',
    //         ],

    //         'category_id' => [
    //             'required',
    //             'exists:lead_categories,id',
    //         ],
    //     ]);

    //     $currentUser = auth()->user();


    //     /*
    //     |--------------------------------------------------------------------------
    //     | VALIDATE SALES USER
    //     |--------------------------------------------------------------------------
    //     */

    //     $salesUser = \App\Models\User::role('Sales')
    //         ->where('id', $request->sales_user_id)
    //         ->first();

    //     if (!$salesUser) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Selected user is not a valid Sales user.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | NON ADMIN BRANCH CHECK
    //     |--------------------------------------------------------------------------
    //     */

    //     if (
    //         !$currentUser->hasRole('Admin') &&
    //         (int) $salesUser->branch_id !== (int) $currentUser->branch_id
    //     ) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'You cannot assign leads to Sales users from another branch.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | LEAD CATEGORY
    //     |--------------------------------------------------------------------------
    //     */

    //     $leadCategory = \App\Models\LeadCategory::findOrFail(
    //         $request->category_id
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | ORIGINAL FILE + EXTENSION
    //     |--------------------------------------------------------------------------
    //     */

    //     $file = $request->file('file');

    //     $extension = strtolower(
    //         $file->getClientOriginalExtension()
    //     );

    //     if (
    //         !in_array(
    //             $extension,
    //             ['csv', 'txt', 'xlsx', 'xls'],
    //             true
    //         )
    //     ) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Only CSV, XLS and XLSX files are allowed.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | TEMPORARY FILE NAME
    //     |--------------------------------------------------------------------------
    //     */

    //     $fileName =
    //         'lead_import_' .
    //         auth()->id() .
    //         '_' .
    //         time() .
    //         '.' .
    //         $extension;


    //     /*
    //     |--------------------------------------------------------------------------
    //     | STORE TEMPORARY FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     $file->storeAs(
    //         'temp/lead-imports',
    //         $fileName
    //     );

    //     $filePath = storage_path(
    //         'app/temp/lead-imports/' . $fileName
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | MAKE SURE FILE WAS STORED
    //     |--------------------------------------------------------------------------
    //     */

    //     if (!file_exists($filePath)) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Unable to store the uploaded file temporarily.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | READ CSV / EXCEL FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     try {

    //         if (
    //             $extension === 'csv' ||
    //             $extension === 'txt'
    //         ) {

    //             $reader = new Csv();

    //             $reader->setDelimiter(',');
    //             $reader->setEnclosure('"');

    //             $spreadsheet = $reader->load(
    //                 $filePath
    //             );

    //         } else {

    //             $spreadsheet = IOFactory::load(
    //                 $filePath
    //             );
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | ACTIVE SHEET
    //         |--------------------------------------------------------------------------
    //         */

    //         $worksheet =
    //             $spreadsheet->getActiveSheet();


    //         /*
    //         |--------------------------------------------------------------------------
    //         | CONVERT SHEET TO ARRAY
    //         |--------------------------------------------------------------------------
    //         */

    //         $rows = $worksheet->toArray(
    //             null,
    //             true,
    //             true,
    //             false
    //         );

    //     } catch (\Throwable $e) {

    //         if (file_exists($filePath)) {
    //             @unlink($filePath);
    //         }

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Unable to read the uploaded CSV/Excel file.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CHECK FILE CONTENT
    //     |--------------------------------------------------------------------------
    //     */

    //     if (empty($rows)) {

    //         if (isset($spreadsheet)) {
    //             $spreadsheet->disconnectWorksheets();
    //             unset($spreadsheet);
    //         }

    //         if (file_exists($filePath)) {
    //             @unlink($filePath);
    //         }

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'The uploaded file is empty.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | FIRST ROW = HEADERS
    //     |--------------------------------------------------------------------------
    //     */

    //     $headers = array_shift($rows);


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAN HEADERS
    //     |--------------------------------------------------------------------------
    //     */

    //     $headers = array_map(
    //         function ($header) {

    //             $header = (string) ($header ?? '');

    //             /*
    //             * Remove UTF-8 BOM
    //             */
    //             $header = preg_replace(
    //                 '/^\xEF\xBB\xBF/',
    //                 '',
    //                 $header
    //             );

    //             return trim($header);
    //         },
    //         $headers
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | REMOVE EMPTY COLUMNS FROM END
    //     |--------------------------------------------------------------------------
    //     */

    //     while (
    //         count($headers) > 0 &&
    //         trim((string) end($headers)) === ''
    //     ) {
    //         array_pop($headers);
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | VALID HEADER CHECK
    //     |--------------------------------------------------------------------------
    //     */

    //     $validHeaders = array_filter(
    //         $headers,
    //         function ($header) {
    //             return trim(
    //                 (string) $header
    //             ) !== '';
    //         }
    //     );

    //     if (empty($validHeaders)) {

    //         if (isset($spreadsheet)) {
    //             $spreadsheet->disconnectWorksheets();
    //             unset($spreadsheet);
    //         }

    //         if (file_exists($filePath)) {
    //             @unlink($filePath);
    //         }

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'The uploaded file does not contain valid column headings.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CRM LEAD FIELDS
    //     |--------------------------------------------------------------------------
    //     */

    //     $fields = [

    //         'name' => [
    //             'label' => 'Name',
    //             'required' => true,
    //         ],

    //         'phone' => [
    //             'label' => 'Phone',
    //             'required' => true,
    //         ],

    //         'email' => [
    //             'label' => 'Email',
    //             'required' => false,
    //         ],

    //         'remarks' => [
    //             'label' => 'Remarks',
    //             'required' => false,
    //         ],

    //         'requirement' => [
    //             'label' => 'Requirement',
    //             'required' => false,
    //         ],

    //         'status' => [
    //             'label' => 'Status',
    //             'required' => false,
    //         ],

    //         'date' => [
    //             'label' => 'Date',
    //             'required' => false,
    //         ],

    //     ];


    //     /*
    //     |--------------------------------------------------------------------------
    //     | EXACT COLUMN MATCH ONLY
    //     |--------------------------------------------------------------------------
    //     |
    //     | Name / NAME / name       => auto match
    //     | Phone / PHONE / phone    => auto match
    //     |
    //     | Customer Name            => manual mapping
    //     | Mobile Number            => manual mapping
    //     | Contact No               => manual mapping
    //     |
    //     */

    //     $autoMapping = [];

    //     foreach ($fields as $field => $config) {

    //         $autoMapping[$field] = '';

    //         foreach ($headers as $index => $header) {

    //             if (
    //                 strtolower(
    //                     trim((string) $header)
    //                 )
    //                 ===
    //                 strtolower(
    //                     trim($config['label'])
    //                 )
    //             ) {
    //                 $autoMapping[$field] =
    //                     (string) $index;

    //                 break;
    //             }
    //         }
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAN SPREADSHEET MEMORY
    //     |--------------------------------------------------------------------------
    //     |
    //     | We only need headers now.
    //     | Actual file remains in temp storage for final import.
    //     |
    //     */

    //     if (isset($spreadsheet)) {
    //         $spreadsheet->disconnectWorksheets();
    //         unset($spreadsheet);
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | SAVE MAIN IMPORT DATA IN SESSION
    //     |--------------------------------------------------------------------------
    //     */

    //     session([
    //         'lead_import' => [

    //             'file' =>
    //                 $fileName,

    //             'sales_user_id' =>
    //                 $salesUser->id,

    //             'category_id' =>
    //                 $leadCategory->id,

    //             'headers' =>
    //                 $headers,

    //             'fields' =>
    //                 $fields,

    //             'auto_mapping' =>
    //                 $autoMapping,
    //         ],
    //     ]);


    //     /*
    //     |--------------------------------------------------------------------------
    //     | REDIRECT TO GET MAPPING PAGE
    //     |--------------------------------------------------------------------------
    //     */

    //     return redirect()->route(
    //         'admin.leads.import.mapping'
    //     );
    // }

    public function prepareImport(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt,xlsx,xls',
                'max:10240',
            ],

            'sales_user_id' => [
                'required',
                'exists:users,id',
            ],

            'category_id' => [
                'required',
                'exists:lead_categories,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $currentUser = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDATE SALES USER
        |--------------------------------------------------------------------------
        */

        $salesUser = \App\Models\User::role('Sales')
            ->where('id', $request->sales_user_id)
            ->first();

        if (!$salesUser) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Selected user is not a valid Sales user.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NON ADMIN BRANCH CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$currentUser->hasRole('Admin') &&
            (int) $salesUser->branch_id !== (int) $currentUser->branch_id
        ) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'You cannot assign leads to Sales users from another branch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LEAD CATEGORY
        |--------------------------------------------------------------------------
        */

        $leadCategory = \App\Models\LeadCategory::findOrFail(
            $request->category_id
        );


        /*
        |--------------------------------------------------------------------------
        | ORIGINAL FILE + EXTENSION
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $originalFileName = $file->getClientOriginalName();

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        if (
            !in_array(
                $extension,
                ['csv', 'txt', 'xlsx', 'xls'],
                true
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Only CSV, XLS and XLSX files are allowed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PERMANENT STORED FILE NAME
        |--------------------------------------------------------------------------
        */

        $storedFileName =
            'lead_import_' .
            auth()->id() .
            '_' .
            now()->format('Ymd_His') .
            '_' .
            Str::random(8) .
            '.' .
            $extension;


        /*
        |--------------------------------------------------------------------------
        | PERMANENT STORAGE DIRECTORY
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | storage/app/lead-imports/2026/09/
        |
        */

        $storageDirectory =
            'lead-imports/' .
            now()->format('Y/m');


        /*
        |--------------------------------------------------------------------------
        | STORE ORIGINAL FILE
        |--------------------------------------------------------------------------
        */

        $storedPath = $file->storeAs(
            $storageDirectory,
            $storedFileName
        );

        if (!$storedPath) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Unable to store the uploaded file.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | RELATIVE + ABSOLUTE FILE PATH
        |--------------------------------------------------------------------------
        */

        $fileRelativePath =
            $storageDirectory .
            '/' .
            $storedFileName;

        $filePath = storage_path(
            'app/' . $fileRelativePath
        );


        /*
        |--------------------------------------------------------------------------
        | MAKE SURE FILE WAS STORED
        |--------------------------------------------------------------------------
        */

        if (!file_exists($filePath)) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Unable to store the uploaded file.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | READ CSV / EXCEL FILE
        |--------------------------------------------------------------------------
        */

        try {

            if (
                $extension === 'csv' ||
                $extension === 'txt'
            ) {

                $reader = new Csv();

                $reader->setDelimiter(',');
                $reader->setEnclosure('"');

                $spreadsheet = $reader->load(
                    $filePath
                );

            } else {

                $spreadsheet = IOFactory::load(
                    $filePath
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ACTIVE SHEET
            |--------------------------------------------------------------------------
            */

            $worksheet =
                $spreadsheet->getActiveSheet();


            /*
            |--------------------------------------------------------------------------
            | CONVERT SHEET TO ARRAY
            |--------------------------------------------------------------------------
            */

            $rows = $worksheet->toArray(
                null,
                true,
                true,
                false
            );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | INVALID FILE = REMOVE STORED FILE
            |--------------------------------------------------------------------------
            */

            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Unable to read the uploaded CSV/Excel file.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK FILE CONTENT
        |--------------------------------------------------------------------------
        */

        if (empty($rows)) {

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }

            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'The uploaded file is empty.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FIRST ROW = HEADERS
        |--------------------------------------------------------------------------
        */

        $headers = array_shift($rows);


        /*
        |--------------------------------------------------------------------------
        | CLEAN HEADERS
        |--------------------------------------------------------------------------
        */

        $headers = array_map(
            function ($header) {

                $header = (string) ($header ?? '');

                /*
                |--------------------------------------------------------------------------
                | REMOVE UTF-8 BOM
                |--------------------------------------------------------------------------
                */

                $header = preg_replace(
                    '/^\xEF\xBB\xBF/',
                    '',
                    $header
                );

                return trim($header);
            },
            $headers
        );


        /*
        |--------------------------------------------------------------------------
        | REMOVE EMPTY COLUMNS FROM END
        |--------------------------------------------------------------------------
        */

        while (
            count($headers) > 0 &&
            trim((string) end($headers)) === ''
        ) {
            array_pop($headers);
        }


        /*
        |--------------------------------------------------------------------------
        | VALID HEADER CHECK
        |--------------------------------------------------------------------------
        */

        $validHeaders = array_filter(
            $headers,
            function ($header) {
                return trim(
                    (string) $header
                ) !== '';
            }
        );

        if (empty($validHeaders)) {

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }

            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'The uploaded file does not contain valid column headings.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | COUNT ACTUAL DATA ROWS
        |--------------------------------------------------------------------------
        |
        | Header has already been removed.
        | Completely blank rows will not be counted.
        |
        */

        $totalRows = collect($rows)
            ->filter(function ($row) {

                foreach ($row as $value) {

                    if (
                        trim(
                            (string) ($value ?? '')
                        ) !== ''
                    ) {
                        return true;
                    }
                }

                return false;
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CHECK THAT FILE HAS DATA ROWS
        |--------------------------------------------------------------------------
        */

        if ($totalRows <= 0) {

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }

            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'The uploaded file contains headings but no lead data.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE IMPORT BATCH HISTORY
        |--------------------------------------------------------------------------
        */

        try {

            $importBatch = LeadImportBatch::create([

                /*
                |--------------------------------------------------------------------------
                | FILE INFORMATION
                |--------------------------------------------------------------------------
                */

                'original_file_name' =>
                    $originalFileName,

                'stored_file_name' =>
                    $storedFileName,

                'file_path' =>
                    $fileRelativePath,

                'file_type' =>
                    $extension,

                'file_size' =>
                    $file->getSize(),


                /*
                |--------------------------------------------------------------------------
                | IMPORT COUNTS
                |--------------------------------------------------------------------------
                */

                'total_rows' =>
                    $totalRows,

                'imported_rows' =>
                    0,

                'skipped_rows' =>
                    0,


                /*
                |--------------------------------------------------------------------------
                | ASSIGNMENT INFORMATION
                |--------------------------------------------------------------------------
                */

                'sales_user_id' =>
                    $salesUser->id,

                'category_id' =>
                    $leadCategory->id,

                'uploaded_by' =>
                    auth()->id(),

                'branch_id' =>
                    $salesUser->branch_id,


                /*
                |--------------------------------------------------------------------------
                | CURRENT IMPORT STATUS
                |--------------------------------------------------------------------------
                */

                'status' =>
                    'pending',
            ]);

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | BATCH FAILED = REMOVE STORED FILE
            |--------------------------------------------------------------------------
            */

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }

            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Unable to create lead import history.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CRM LEAD FIELDS
        |--------------------------------------------------------------------------
        */

        $fields = [

            'name' => [
                'label' => 'Name',
                'required' => true,
            ],

            'phone' => [
                'label' => 'Phone',
                'required' => true,
            ],

            'email' => [
                'label' => 'Email',
                'required' => false,
            ],

            'remarks' => [
                'label' => 'Remarks',
                'required' => false,
            ],

            'requirement' => [
                'label' => 'Requirement',
                'required' => false,
            ],

            'status' => [
                'label' => 'Status',
                'required' => false,
            ],

            'date' => [
                'label' => 'Date',
                'required' => false,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | EXACT COLUMN MATCH ONLY
        |--------------------------------------------------------------------------
        |
        | Name / NAME / name
        |      => automatically matched
        |
        | Phone / PHONE / phone
        |      => automatically matched
        |
        | Email / EMAIL / email
        |      => automatically matched
        |
        | Customer Name
        | Mobile Number
        | Contact No
        |      => manual mapping
        |
        */

        $autoMapping = [];

        foreach ($fields as $field => $config) {

            $autoMapping[$field] = '';

            foreach ($headers as $index => $header) {

                if (
                    strtolower(
                        trim((string) $header)
                    )
                    ===
                    strtolower(
                        trim($config['label'])
                    )
                ) {

                    $autoMapping[$field] =
                        (string) $index;

                    break;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CLEAN SPREADSHEET MEMORY
        |--------------------------------------------------------------------------
        |
        | File is NOT deleted.
        |
        | We need the permanently stored original file later for:
        |
        | - Final import
        | - Preview
        | - Download
        | - Import History
        |
        */

        if (isset($spreadsheet)) {
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE IMPORT DATA IN SESSION
        |--------------------------------------------------------------------------
        */

        session([

            'lead_import' => [

                /*
                |--------------------------------------------------------------------------
                | IMPORT BATCH
                |--------------------------------------------------------------------------
                */

                'batch_id' =>
                    $importBatch->id,


                /*
                |--------------------------------------------------------------------------
                | FILE INFORMATION
                |--------------------------------------------------------------------------
                */

                'file' =>
                    $storedFileName,

                'file_path' =>
                    $fileRelativePath,

                'original_file_name' =>
                    $originalFileName,


                /*
                |--------------------------------------------------------------------------
                | SALES + CATEGORY
                |--------------------------------------------------------------------------
                */

                'sales_user_id' =>
                    $salesUser->id,

                'category_id' =>
                    $leadCategory->id,


                /*
                |--------------------------------------------------------------------------
                | COLUMN MAPPING
                |--------------------------------------------------------------------------
                */

                'headers' =>
                    $headers,

                'fields' =>
                    $fields,

                'auto_mapping' =>
                    $autoMapping,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO GET MAPPING PAGE
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'admin.leads.import.mapping'
        );
    }


    

    // public function import(Request $request)
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | VALIDATE COLUMN MAPPING
    //     |--------------------------------------------------------------------------
    //     */

    //     $request->validate([
    //         'mapping' => [
    //             'required',
    //             'array',
    //         ],
    //         'mapping.name' => [
    //             'required',
    //         ],
    //         'mapping.phone' => [
    //             'required',
    //         ],
    //     ]);


    //     /*
    //     |--------------------------------------------------------------------------
    //     | GET IMPORT SESSION
    //     |--------------------------------------------------------------------------
    //     */

    //     $importData = session('lead_import');

    //     if (!$importData) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Import session expired. Please upload the file again.'
    //             );
    //     }

    //     $currentUser = auth()->user();


    //     /*
    //     |--------------------------------------------------------------------------
    //     | SALES USER
    //     |--------------------------------------------------------------------------
    //     */

    //     $salesUser = \App\Models\User::role('Sales')
    //         ->where('id', $importData['sales_user_id'])
    //         ->first();

    //     if (!$salesUser) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Selected Sales user is no longer valid.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | BRANCH SECURITY CHECK AGAIN
    //     |--------------------------------------------------------------------------
    //     */

    //     if (
    //         !$currentUser->hasRole('Admin') &&
    //         (int) $salesUser->branch_id !== (int) $currentUser->branch_id
    //     ) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'You cannot assign leads to Sales users from another branch.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | LEAD CATEGORY
    //     |--------------------------------------------------------------------------
    //     */

    //     $leadCategory = \App\Models\LeadCategory::find(
    //         $importData['category_id']
    //     );

    //     if (!$leadCategory) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Selected Lead Category is no longer available.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | TEMP FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     $fileName = basename($importData['file']);

    //     $filePath = storage_path(
    //         'app/temp/lead-imports/' . $fileName
    //     );

    //     if (!file_exists($filePath)) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Uploaded file was not found. Please upload it again.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | READ CSV / XLS / XLSX
    //     |--------------------------------------------------------------------------
    //     */

    //     try {

    //         $extension = strtolower(
    //             pathinfo($filePath, PATHINFO_EXTENSION)
    //         );

    //         if (
    //             $extension === 'csv' ||
    //             $extension === 'txt'
    //         ) {
    //             $reader = new Csv();

    //             $reader->setDelimiter(',');
    //             $reader->setEnclosure('"');

    //             $spreadsheet = $reader->load($filePath);

    //         } elseif (
    //             $extension === 'xlsx' ||
    //             $extension === 'xls'
    //         ) {
    //             $spreadsheet = IOFactory::load($filePath);

    //         } else {
    //             throw new \Exception(
    //                 'Unsupported import file type.'
    //             );
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | FIRST / ACTIVE SHEET
    //         |--------------------------------------------------------------------------
    //         */

    //         $worksheet = $spreadsheet->getActiveSheet();

    //         $rows = $worksheet->toArray(
    //             null,
    //             true,
    //             true,
    //             false
    //         );

    //     } catch (\Throwable $e) {

    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Unable to read the uploaded CSV/Excel file.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | FILE MUST HAVE HEADER
    //     |--------------------------------------------------------------------------
    //     */

    //     if (empty($rows)) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Uploaded file is empty.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | FIRST ROW = HEADER
    //     |--------------------------------------------------------------------------
    //     */

    //     $headers = array_shift($rows);

    //     $headers = array_map(function ($header) {

    //         $header = (string) ($header ?? '');

    //         $header = preg_replace(
    //             '/^\xEF\xBB\xBF/',
    //             '',
    //             $header
    //         );

    //         return trim($header);

    //     }, $headers);


    //     /*
    //     |--------------------------------------------------------------------------
    //     | MAPPING
    //     |--------------------------------------------------------------------------
    //     */

    //     $mapping = $request->input(
    //         'mapping',
    //         []
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | ONLY THESE CRM FIELDS ARE ALLOWED
    //     |--------------------------------------------------------------------------
    //     */

    //     $allowedMappingFields = [
    //         'name',
    //         'phone',
    //         'email',
    //         'remarks',
    //         'requirement',
    //         'status',
    //         'date',
    //     ];

    //     foreach ($mapping as $field => $index) {

    //         if (!in_array($field, $allowedMappingFields, true)) {
    //             return redirect()
    //                 ->back()
    //                 ->with(
    //                     'error_message',
    //                     'Invalid Lead field mapping detected.'
    //                 );
    //         }

    //         if ($index === '' || $index === null) {
    //             continue;
    //         }

    //         if (
    //             !is_numeric($index) ||
    //             !array_key_exists((int) $index, $headers)
    //         ) {
    //             return redirect()
    //                 ->back()
    //                 ->with(
    //                     'error_message',
    //                     'Invalid CSV/Excel column mapping detected.'
    //                 );
    //         }
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | NAME + PHONE MUST EXIST
    //     |--------------------------------------------------------------------------
    //     */

    //     if (
    //         !isset($mapping['name']) ||
    //         $mapping['name'] === '' ||
    //         !isset($mapping['phone']) ||
    //         $mapping['phone'] === ''
    //     ) {
    //         return redirect()
    //             ->back()
    //             ->with(
    //                 'error_message',
    //                 'Name and Phone columns must be mapped.'
    //             );
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | SAME COLUMN CANNOT BE USED TWICE
    //     |--------------------------------------------------------------------------
    //     */

    //     $selectedColumns = [];

    //     foreach ($mapping as $index) {

    //         if ($index === '' || $index === null) {
    //             continue;
    //         }

    //         $index = (string) $index;

    //         if (in_array($index, $selectedColumns, true)) {
    //             return redirect()
    //                 ->back()
    //                 ->with(
    //                     'error_message',
    //                     'The same file column cannot be mapped to multiple Lead fields.'
    //                 );
    //         }

    //         $selectedColumns[] = $index;
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | GET VALUE USING USER MAPPING
    //     |--------------------------------------------------------------------------
    //     */

    //     $getMappedValue = function ($row, $field) use ($mapping) {

    //         if (
    //             !array_key_exists($field, $mapping) ||
    //             $mapping[$field] === '' ||
    //             $mapping[$field] === null
    //         ) {
    //             return '';
    //         }

    //         $index = (int) $mapping[$field];

    //         $value = $row[$index] ?? '';

    //         /*
    //         | PhpSpreadsheet can return numbers,
    //         | strings, dates etc.
    //         */

    //         if ($value === null) {
    //             return '';
    //         }

    //         return trim((string) $value);
    //     };


    //     /*
    //     |--------------------------------------------------------------------------
    //     | IMPORT SETTINGS
    //     |--------------------------------------------------------------------------
    //     */

    //     $imported = 0;
    //     $skipped = 0;

    //     $allowedStatuses = [
    //         'pending',
    //         'accept',
    //         'reject',
    //         'call',
    //     ];


    //     /*
    //     |--------------------------------------------------------------------------
    //     | IMPORT ROWS
    //     |--------------------------------------------------------------------------
    //     */

    //     foreach ($rows as $row) {

    //         /*
    //         |--------------------------------------------------------------------------
    //         | IGNORE COMPLETELY EMPTY ROW
    //         |--------------------------------------------------------------------------
    //         */

    //         $hasData = false;

    //         foreach ($row as $cell) {
    //             if (
    //                 $cell !== null &&
    //                 trim((string) $cell) !== ''
    //             ) {
    //                 $hasData = true;
    //                 break;
    //             }
    //         }

    //         if (!$hasData) {
    //             continue;
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | VALUES ACCORDING TO MAPPING
    //         |--------------------------------------------------------------------------
    //         */

    //         $name = $getMappedValue(
    //             $row,
    //             'name'
    //         );

    //         $phone = $getMappedValue(
    //             $row,
    //             'phone'
    //         );

    //         $email = $getMappedValue(
    //             $row,
    //             'email'
    //         );

    //         $remarks = $getMappedValue(
    //             $row,
    //             'remarks'
    //         );

    //         $requirement = $getMappedValue(
    //             $row,
    //             'requirement'
    //         );

    //         $status = strtolower(
    //             $getMappedValue(
    //                 $row,
    //                 'status'
    //             )
    //         );

    //         $dateRaw = $getMappedValue(
    //             $row,
    //             'date'
    //         );


    //         /*
    //         |--------------------------------------------------------------------------
    //         | REQUIRED VALUES
    //         |--------------------------------------------------------------------------
    //         */

    //         if (
    //             empty($name) ||
    //             empty($phone)
    //         ) {
    //             $skipped++;
    //             continue;
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | STATUS
    //         |--------------------------------------------------------------------------
    //         */

    //         if (
    //             empty($status) ||
    //             !in_array(
    //                 $status,
    //                 $allowedStatuses,
    //                 true
    //             )
    //         ) {
    //             $status = 'pending';
    //         }


    //         /*
    //         |--------------------------------------------------------------------------
    //         | DATE
    //         |--------------------------------------------------------------------------
    //         */

    //         $leadDate = $this->formatImportDate(
    //             $dateRaw
    //         );


    //         /*
    //         |--------------------------------------------------------------------------
    //         | CREATE LEAD
    //         |--------------------------------------------------------------------------
    //         */

    //         \App\Models\Lead::create([

    //             'name' => $name,

    //             'phone' => $phone,

    //             'email' => $email ?: null,

    //             'remarks' => $remarks ?: null,

    //             'requirement' => $requirement ?: null,

    //             /*
    //             * Selected Lead Category
    //             */
    //             'categories_id' => $leadCategory->id,

    //             /*
    //             * CSV / Excel Bulk Upload
    //             */
    //             'source' => 'csv',

    //             /*
    //             * Selected Sales Person
    //             */
    //             'user_id' => $salesUser->id,

    //             /*
    //             * Sales Person Branch
    //             */
    //             'branch_id' => $salesUser->branch_id,

    //             'status' => $status,

    //             'lead_date' => $leadDate,
    //         ]);

    //         $imported++;
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAN UP SPREADSHEET
    //     |--------------------------------------------------------------------------
    //     */

    //     if (isset($spreadsheet)) {
    //         $spreadsheet->disconnectWorksheets();
    //         unset($spreadsheet);
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | DELETE TEMP FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     if (file_exists($filePath)) {
    //         @unlink($filePath);
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | CLEAR IMPORT SESSION
    //     |--------------------------------------------------------------------------
    //     */

    //     session()->forget('lead_import');

    //     return redirect()
    //         ->route('admin.leads.index')
    //         ->with(
    //             'success_message',
    //             "Leads imported successfully. "
    //             . "Category: {$leadCategory->title}, "
    //             . "Assigned To: {$salesUser->name}, "
    //             . "Imported: {$imported}, "
    //             . "Skipped: {$skipped}"
    //     );
    // }

    public function import(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE COLUMN MAPPING
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'mapping' => [
                'required',
                'array',
            ],

            'mapping.name' => [
                'required',
            ],

            'mapping.phone' => [
                'required',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | GET IMPORT SESSION
        |--------------------------------------------------------------------------
        */

        $importData = session('lead_import');

        if (!$importData) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import session expired. Please upload the file again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | IMPORT BATCH
        |--------------------------------------------------------------------------
        */

        $batchId = $importData['batch_id'] ?? null;

        if (!$batchId) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import batch information is missing. Please upload the file again.'
                );
        }

        $importBatch = \App\Models\LeadImportBatch::find($batchId);

        if (!$importBatch) {
            session()->forget('lead_import');

            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import batch was not found. Please upload the file again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY - BATCH OWNER / BRANCH
        |--------------------------------------------------------------------------
        */

        $currentUser = auth()->user();

        if (
            !$currentUser->hasRole('Admin') &&
            (int) $importBatch->branch_id !== (int) $currentUser->branch_id
        ) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'You are not allowed to process this import batch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SALES USER
        |--------------------------------------------------------------------------
        */

        $salesUser = \App\Models\User::role('Sales')
            ->where('id', $importData['sales_user_id'])
            ->first();

        if (!$salesUser) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Selected Sales user is no longer valid.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BRANCH SECURITY CHECK AGAIN
        |--------------------------------------------------------------------------
        */

        if (
            !$currentUser->hasRole('Admin') &&
            (int) $salesUser->branch_id !== (int) $currentUser->branch_id
        ) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'You cannot assign leads to Sales users from another branch.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | LEAD CATEGORY
        |--------------------------------------------------------------------------
        */

        $leadCategory = \App\Models\LeadCategory::find(
            $importData['category_id']
        );

        if (!$leadCategory) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Selected Lead Category is no longer available.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFY SESSION AGAINST BATCH
        |--------------------------------------------------------------------------
        */

        if (
            (int) $importBatch->sales_user_id !== (int) $salesUser->id ||
            (int) $importBatch->category_id !== (int) $leadCategory->id
        ) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Import batch information does not match the current import session.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PERMANENT IMPORT FILE
        |--------------------------------------------------------------------------
        */

        $fileRelativePath =
            $importData['file_path']
            ?? $importBatch->file_path;

        if (!$fileRelativePath) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Uploaded file path is missing.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SECURITY - NORMALIZE RELATIVE PATH
        |--------------------------------------------------------------------------
        */

        $fileRelativePath = ltrim(
            str_replace('\\', '/', $fileRelativePath),
            '/'
        );

        if (
            str_contains($fileRelativePath, '../') ||
            !str_starts_with($fileRelativePath, 'lead-imports/')
        ) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Invalid import file path.'
                );
        }

        $filePath = storage_path(
            'app/' . $fileRelativePath
        );

        if (!file_exists($filePath)) {
            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Uploaded file was not found. Please upload it again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | READ CSV / XLS / XLSX
        |--------------------------------------------------------------------------
        */

        try {

            $extension = strtolower(
                pathinfo(
                    $filePath,
                    PATHINFO_EXTENSION
                )
            );

            if (
                $extension === 'csv' ||
                $extension === 'txt'
            ) {

                $reader = new Csv();

                $reader->setDelimiter(',');
                $reader->setEnclosure('"');

                $spreadsheet = $reader->load(
                    $filePath
                );

            } elseif (
                $extension === 'xlsx' ||
                $extension === 'xls'
            ) {

                $spreadsheet = IOFactory::load(
                    $filePath
                );

            } else {

                throw new \Exception(
                    'Unsupported import file type.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ACTIVE SHEET
            |--------------------------------------------------------------------------
            */

            $worksheet =
                $spreadsheet->getActiveSheet();


            /*
            |--------------------------------------------------------------------------
            | CONVERT TO ARRAY
            |--------------------------------------------------------------------------
            */

            $rows = $worksheet->toArray(
                null,
                true,
                true,
                false
            );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Unable to read the uploaded CSV/Excel file.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FILE MUST HAVE HEADER
        |--------------------------------------------------------------------------
        */

        if (empty($rows)) {

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }

            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Uploaded file is empty.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FIRST ROW = HEADER
        |--------------------------------------------------------------------------
        */

        $headers = array_shift($rows);

        $headers = array_map(
            function ($header) {

                $header =
                    (string) ($header ?? '');

                $header = preg_replace(
                    '/^\xEF\xBB\xBF/',
                    '',
                    $header
                );

                return trim($header);
            },
            $headers
        );


        /*
        |--------------------------------------------------------------------------
        | MAPPING
        |--------------------------------------------------------------------------
        */

        $mapping = $request->input(
            'mapping',
            []
        );


        /*
        |--------------------------------------------------------------------------
        | ONLY THESE CRM FIELDS ARE ALLOWED
        |--------------------------------------------------------------------------
        */

        $allowedMappingFields = [
            'name',
            'phone',
            'email',
            'remarks',
            'requirement',
            'status',
            'date',
        ];

        foreach ($mapping as $field => $index) {

            if (
                !in_array(
                    $field,
                    $allowedMappingFields,
                    true
                )
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error_message',
                        'Invalid Lead field mapping detected.'
                    );
            }

            if (
                $index === '' ||
                $index === null
            ) {
                continue;
            }

            if (
                !is_numeric($index) ||
                !array_key_exists(
                    (int) $index,
                    $headers
                )
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error_message',
                        'Invalid CSV/Excel column mapping detected.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NAME + PHONE MUST EXIST
        |--------------------------------------------------------------------------
        */

        if (
            !isset($mapping['name']) ||
            $mapping['name'] === '' ||
            !isset($mapping['phone']) ||
            $mapping['phone'] === ''
        ) {
            return redirect()
                ->back()
                ->with(
                    'error_message',
                    'Name and Phone columns must be mapped.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SAME COLUMN CANNOT BE USED TWICE
        |--------------------------------------------------------------------------
        */

        $selectedColumns = [];

        foreach ($mapping as $index) {

            if (
                $index === '' ||
                $index === null
            ) {
                continue;
            }

            $index = (string) $index;

            if (
                in_array(
                    $index,
                    $selectedColumns,
                    true
                )
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error_message',
                        'The same file column cannot be mapped to multiple Lead fields.'
                    );
            }

            $selectedColumns[] = $index;
        }


        /*
        |--------------------------------------------------------------------------
        | GET VALUE USING USER MAPPING
        |--------------------------------------------------------------------------
        */

        $getMappedValue =
            function ($row, $field) use ($mapping) {

                if (
                    !array_key_exists(
                        $field,
                        $mapping
                    ) ||
                    $mapping[$field] === '' ||
                    $mapping[$field] === null
                ) {
                    return '';
                }

                $index =
                    (int) $mapping[$field];

                $value =
                    $row[$index] ?? '';

                if ($value === null) {
                    return '';
                }

                return trim(
                    (string) $value
                );
            };


        /*
        |--------------------------------------------------------------------------
        | IMPORT SETTINGS
        |--------------------------------------------------------------------------
        */

        $imported = 0;
        $skipped = 0;

        $allowedStatuses = [
            'pending',
            'accept',
            'reject',
            'call',
        ];


        /*
        |--------------------------------------------------------------------------
        | START DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        |
        | Either all valid leads are imported and batch is completed,
        | or database changes are rolled back if an unexpected DB error occurs.
        |
        */

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | IMPORT ROWS
            |--------------------------------------------------------------------------
            */

            foreach ($rows as $row) {

                /*
                |--------------------------------------------------------------------------
                | IGNORE COMPLETELY EMPTY ROW
                |--------------------------------------------------------------------------
                */

                $hasData = false;

                foreach ($row as $cell) {

                    if (
                        $cell !== null &&
                        trim((string) $cell) !== ''
                    ) {
                        $hasData = true;
                        break;
                    }
                }

                if (!$hasData) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | VALUES ACCORDING TO MAPPING
                |--------------------------------------------------------------------------
                */

                $name =
                    $getMappedValue(
                        $row,
                        'name'
                    );

                $phone =
                    $getMappedValue(
                        $row,
                        'phone'
                    );

                $email =
                    $getMappedValue(
                        $row,
                        'email'
                    );

                $remarks =
                    $getMappedValue(
                        $row,
                        'remarks'
                    );

                $requirement =
                    $getMappedValue(
                        $row,
                        'requirement'
                    );

                $status = strtolower(
                    $getMappedValue(
                        $row,
                        'status'
                    )
                );

                $dateRaw =
                    $getMappedValue(
                        $row,
                        'date'
                    );


                /*
                |--------------------------------------------------------------------------
                | REQUIRED VALUES
                |--------------------------------------------------------------------------
                */

                if (
                    empty($name) ||
                    empty($phone)
                ) {
                    $skipped++;
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                if (
                    empty($status) ||
                    !in_array(
                        $status,
                        $allowedStatuses,
                        true
                    )
                ) {
                    $status = 'pending';
                }


                /*
                |--------------------------------------------------------------------------
                | DATE
                |--------------------------------------------------------------------------
                */

                $leadDate =
                    $this->formatImportDate(
                        $dateRaw
                    );


                /*
                |--------------------------------------------------------------------------
                | CREATE LEAD
                |--------------------------------------------------------------------------
                */

                \App\Models\Lead::create([

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORT BATCH LINK
                    |--------------------------------------------------------------------------
                    */

                    'import_batch_id' =>
                        $importBatch->id,


                    /*
                    |--------------------------------------------------------------------------
                    | LEAD INFORMATION
                    |--------------------------------------------------------------------------
                    */

                    'name' =>
                        $name,

                    'phone' =>
                        $phone,

                    'email' =>
                        $email ?: null,

                    'remarks' =>
                        $remarks ?: null,

                    'requirement' =>
                        $requirement ?: null,


                    /*
                    |--------------------------------------------------------------------------
                    | SELECTED LEAD CATEGORY
                    |--------------------------------------------------------------------------
                    */

                    'categories_id' =>
                        $leadCategory->id,


                    /*
                    |--------------------------------------------------------------------------
                    | CSV / EXCEL BULK UPLOAD
                    |--------------------------------------------------------------------------
                    */

                    'source' =>
                        'csv',


                    /*
                    |--------------------------------------------------------------------------
                    | SELECTED SALES PERSON
                    |--------------------------------------------------------------------------
                    */

                    'user_id' =>
                        $salesUser->id,


                    /*
                    |--------------------------------------------------------------------------
                    | SALES PERSON BRANCH
                    |--------------------------------------------------------------------------
                    */

                    'branch_id' =>
                        $salesUser->branch_id,


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS + DATE
                    |--------------------------------------------------------------------------
                    */

                    'status' =>
                        $status,

                    'lead_date' =>
                        $leadDate,
                ]);

                $imported++;
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE IMPORT BATCH
            |--------------------------------------------------------------------------
            */

            $importBatch->update([
                'imported_rows' =>
                    $imported,

                'skipped_rows' =>
                    $skipped,

                'status' =>
                    'completed',
            ]);


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            \Illuminate\Support\Facades\DB::commit();

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK IMPORT
            |--------------------------------------------------------------------------
            */

            \Illuminate\Support\Facades\DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | KEEP BATCH + ORIGINAL FILE
            |--------------------------------------------------------------------------
            |
            | Do not delete the original uploaded file.
            | Mark batch as failed so history remains traceable.
            |
            */

            $importBatch->update([
                'imported_rows' => 0,
                'skipped_rows' => 0,
                'status' => 'failed',
            ]);


            /*
            |--------------------------------------------------------------------------
            | CLEAN SPREADSHEET MEMORY
            |--------------------------------------------------------------------------
            */

            if (isset($spreadsheet)) {
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }


            /*
            |--------------------------------------------------------------------------
            | CLEAR SESSION
            |--------------------------------------------------------------------------
            */

            session()->forget(
                'lead_import'
            );


            return redirect()
                ->route('admin.leads.index')
                ->with(
                    'error_message',
                    'Lead import failed. No leads were imported.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CLEAN UP SPREADSHEET MEMORY
        |--------------------------------------------------------------------------
        */

        if (isset($spreadsheet)) {
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT: DO NOT DELETE ORIGINAL FILE
        |--------------------------------------------------------------------------
        |
        | Old code deleted $filePath here.
        |
        | We intentionally keep the file because it is required for:
        |
        | - Open File
        | - Download File
        | - Import History
        |
        */


        /*
        |--------------------------------------------------------------------------
        | CLEAR IMPORT SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget(
            'lead_import'
        );


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.leads.index')
            ->with(
                'success_message',

                "Leads imported successfully. "
                . "File: {$importBatch->original_file_name}, "
                . "Category: {$leadCategory->title}, "
                . "Assigned To: {$salesUser->name}, "
                . "Imported: {$imported}, "
                . "Skipped: {$skipped}"
            );
    }


    private function formatImportDate($date)
    {
        if (empty($date)) {
            return null;
        }

        $date = trim($date);

        try {
            // Format: YYYY-MM-DD
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
            }

            // Format: DD/MM/YYYY
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            }

            // Fallback
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    // public function rejectedLead($id = null)
    // {
    //     if (auth()->user()->hasRole('Admin')) {
    //         $query = Lead::where('status', 'reject');

    //         if ($id) {
    //             $query->where('categories_id', $id);
    //         }

    //         $leads = $query->get();
    //         $categories = LeadCategory::all();

    //         // Category counts based on status != call
    //         $categoryCounts = Lead::where('status', 'reject')
    //             ->selectRaw('categories_id, COUNT(*) as total')
    //             ->groupBy('categories_id')
    //             ->pluck('total', 'categories_id');
    //     } else {
    //         $query = Lead::where('branch_id', auth()->user()->branch_id)->where('status', 'reject');

    //         if ($id) {
    //             $query->where('categories_id', $id);
    //         }

    //         $leads = $query->get();
    //         $categories = LeadCategory::all();

    //         // Category counts based on status != call
    //         $categoryCounts = Lead::where('branch_id', auth()->user()->branch_id)->where('status', 'reject')
    //             ->selectRaw('categories_id, COUNT(*) as total')
    //             ->groupBy('categories_id')
    //             ->pluck('total', 'categories_id');
    //     }

    //     return view('admin.leads.rejectedleads', compact('leads', 'categories', 'categoryCounts'));
    // }

    public function rejectedLead(Request $request, $id = null) 
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | PER PAGE
        |--------------------------------------------------------------------------
        */
        $perPageValue = $request->get(
            'per_page',
            '50'
        );

        if (
            in_array(
                (string) $perPageValue,
                ['50', '100', '200'],
                true
            )
        ) {

            $perPage = (int) $perPageValue;

        } elseif ($perPageValue === 'custom') {

            $perPage = (int) $request->get(
                'custom_per_page',
                50
            );

            $perPage = max(
                1,
                min(
                    500,
                    $perPage
                )
            );

        } else {

            $perPage = 50;
        }


        /*
        |--------------------------------------------------------------------------
        | ACCESS QUERY
        |--------------------------------------------------------------------------
        |
        | Admin:
        |   All rejected leads
        |
        | Everyone else:
        |   Only rejected leads assigned to logged-in user
        |
        */
        $baseQuery = Lead::query()
            ->where(
                'status',
                'reject'
            );


        if (!$user->hasRole('Admin')) {

            $baseQuery->where(
                'user_id',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL REJECTED
        |--------------------------------------------------------------------------
        */
        $totalRejected = (
            clone $baseQuery
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CATEGORY COUNTS
        |--------------------------------------------------------------------------
        */
        $categoryCounts = (
            clone $baseQuery
        )
            ->selectRaw(
                'categories_id, COUNT(*) as total'
            )
            ->groupBy(
                'categories_id'
            )
            ->pluck(
                'total',
                'categories_id'
            );


        /*
        |--------------------------------------------------------------------------
        | MAIN QUERY
        |--------------------------------------------------------------------------
        */
        $query = clone $baseQuery;


        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */
        if ($id) {

            $query->where(
                'categories_id',
                $id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'remarks',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'requirement',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'leadcat',
                        function ($categoryQuery) use ($search) {

                            $categoryQuery->where(
                                'title',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LEADS
        |--------------------------------------------------------------------------
        */
        $leads = $query
            ->with([
                'leadcat',
                'assignedUser',
            ])
            ->latest()
            ->paginate(
                $perPage
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */
        $categories = LeadCategory::query()
            ->orderBy('title')
            ->get();


        return view(
            'admin.leads.rejectedleads',
            compact(
                'leads',
                'categories',
                'categoryCounts',
                'totalRejected'
            )
        );
    }

    public function bulkDeleteRejected(
    Request $request
    ) {
        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | SPATIE PERMISSION
        |--------------------------------------------------------------------------
        */
        abort_unless(
            $user->can('lead-delete'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'lead_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'lead_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:leads,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ONLY REJECTED LEADS
        |--------------------------------------------------------------------------
        */
        $query = Lead::query()
            ->where(
                'status',
                'reject'
            )
            ->whereIn(
                'id',
                $request->lead_ids
            );


        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        |
        | Admin:
        |   Can delete selected rejected leads
        |
        | Other users:
        |   Can delete ONLY their own assigned rejected leads
        |
        */
        if (!$user->hasRole('Admin')) {

            $query->where(
                'user_id',
                $user->id
            );
        }


        $leads = $query->get();


        if ($leads->isEmpty()) {

            return back()->with(
                'error_message',
                'No valid rejected leads were selected.'
            );
        }


        $deletedCount = 0;


        try {

            \Illuminate\Support\Facades\DB::beginTransaction();


            foreach ($leads as $lead) {

                $lead->delete();

                $deletedCount++;
            }


            \Illuminate\Support\Facades\DB::commit();

        } catch (\Throwable $e) {

            \Illuminate\Support\Facades\DB::rollBack();

            report($e);


            return back()->with(
                'error_message',
                'Unable to delete selected rejected leads.'
            );
        }


        return back()->with(
            'success_message',
            $deletedCount .
            ' rejected lead(s) deleted successfully.'
        );
    }


    // 

    public function storeQuickQuotation(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',

            'items' => 'required|array|min:1',

            'items.*.product_id' =>
                'required|exists:products,id',

            'items.*.quantity' =>
                'required|numeric|min:1',

            'items.*.unit_price' =>
                'required|numeric|min:0',

            'discount' =>
                'nullable|numeric|min:0|max:100',

            'vat' =>
                'nullable|numeric|min:0|max:100',

            'note' =>
                'nullable|string|max:2000',
        ]);


        $user = auth()->user();

        $lead = Lead::findOrFail(
            $request->lead_id
        );


        /*
        |--------------------------------------------------------------------------
        | ACCESS CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' =>
                    'You are not allowed to create proforma for this lead.',
            ], 403);
        }


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER
            |--------------------------------------------------------------------------
            |
            | Lead ka company/client customer ke roop me use hoga.
            |
            */

            $customerId =
                $lead->client_id
                ?? $lead->customer_id
                ?? $lead->company_id
                ?? null;


            if (!$customerId) {

                throw new \Exception(
                    'Customer/Company is not linked with this lead.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | BRANCH
            |--------------------------------------------------------------------------
            */

            $branchId =
                $lead->branch_id
                ?? $user->branch_id
                ?? null;


            if (!$branchId) {

                throw new \Exception(
                    'Branch is not available for this lead.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CALCULATE ITEMS + TOTAL
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;

            $totalTax = 0;

            $preparedItems = [];


            foreach ($request->items as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );


                $quantity =
                    (float) $item['quantity'];


                $price =
                    (float) $item['unit_price'];


                /*
                * Quick quotation ka VAT/GST currently
                * overall request me aa raha hai.
                */

                $gstRate =
                    (float) ($request->vat ?? 0);


                /*
                * Product se HSN lo.
                *
                * Agar Product model me hsn_code direct field hai
                * to ye use hoga.
                */

                $hsnCode =
                    $product->hsn_code ?? 'N/A';


                $lineAmount =
                    $price * $quantity;


                $taxAmount =
                    ($lineAmount * $gstRate) / 100;


                $subtotal +=
                    $lineAmount;


                $totalTax +=
                    $taxAmount;


                $preparedItems[] = [

                    'product_id' =>
                        $product->id,

                    'quantity' =>
                        $quantity,

                    'price' =>
                        $price,

                    'hsn_code' =>
                        $hsnCode,

                    'gst' =>
                        $gstRate,

                    'tax_amount' =>
                        $taxAmount,

                    'line_total' =>
                        $lineAmount + $taxAmount,

                ];
            }


            /*
            |--------------------------------------------------------------------------
            | DISCOUNT
            |--------------------------------------------------------------------------
            */

            $discountPercent =
                (float) ($request->discount ?? 0);


            $discountAmount =
                ($subtotal * $discountPercent) / 100;


            $afterDiscount =
                $subtotal - $discountAmount;


            /*
            * Quick form me VAT discount ke baad calculate
            * ho raha tha, isliye final response calculation
            * same rakhenge.
            */

            $vatPercent =
                (float) ($request->vat ?? 0);


            $vatAmount =
                ($afterDiscount * $vatPercent) / 100;


            $grandTotal =
                $afterDiscount + $vatAmount;


            /*
            |--------------------------------------------------------------------------
            | GENERATE PROFORMA NUMBER
            |--------------------------------------------------------------------------
            */

            $lastProforma =
                Proforma::latest('id')->first();


            $nextId =
                $lastProforma
                    ? $lastProforma->id + 1
                    : 1;


            $proformaNumber =
                'PF-' .
                str_pad(
                    $nextId,
                    5,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |--------------------------------------------------------------------------
            | CREATE PROFORMA
            |--------------------------------------------------------------------------
            */

            $proforma = Proforma::create([

                'proforma_no' =>
                    $proformaNumber,

                'customer_id' =>
                    $customerId,

                'proforma_date' =>
                    now()->toDateString(),

                'subtotal' =>
                    round($subtotal, 2),

                'tax' =>
                    round($vatAmount, 2),

                'total' =>
                    round($grandTotal, 2),

                'status' =>
                    'proforma',

                /*
                * SALES PIPELINE STAGE
                */
                'stage' =>
                    'Send Proforma',

                'notes' =>
                    $request->note,

                'branch_id' =>
                    $branchId,

                'lead_id' =>
                    $lead->id,

            ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE PROFORMA ITEMS
            |--------------------------------------------------------------------------
            */

            foreach ($preparedItems as $item) {

                ProformaItem::create([

                    'proforma_id' =>
                        $proforma->id,

                    'product_id' =>
                        $item['product_id'],

                    'price' =>
                        $item['price'],

                    'quantity' =>
                        $item['quantity'],

                    'line_total' =>
                        $item['line_total'],

                    'hsn_code' =>
                        $item['hsn_code'],

                    'gst' =>
                        $item['gst'],

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | LEAD ACTION
            |--------------------------------------------------------------------------
            |
            | Quick Quotation ab actually Proforma create kar rahi hai.
            |
            */

            LeadAction::create([

                'lead_id' =>
                    $lead->id,

                'user_id' =>
                    $user->id,

                'action_type' =>
                    'proforma_shared',

                'action_label' =>
                    'Proforma Created',

                /*
                * quotation_id intentionally set nahi kar rahe.
                * Ye record quotation nahi hai.
                */
                'quotation_id' =>
                    null,

                'note' =>
                    'Proforma ' .
                    $proformaNumber .
                    ' created for this lead.',

                'meta' => [

                    'proforma_id' =>
                        $proforma->id,

                    'proforma_number' =>
                        $proformaNumber,

                    'discount' =>
                        $discountPercent,

                    'gst' =>
                        $vatPercent,

                    'stage' =>
                        'Send Proforma',

                ],

                'action_at' =>
                    now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | LEAD STATUS
            |--------------------------------------------------------------------------
            |
            | Lead ko identify karne ke liye status preserve kar rahe hain.
            | Pipeline transaction stage ab proformas.stage se aayega.
            |
            */

            $lead->status =
                'quick-quotation';

            $lead->save();


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Proforma created successfully.',

                'proforma_id' =>
                    $proforma->id,

                'proforma_no' =>
                    $proformaNumber,

                'stage' =>
                    'Send Proforma',

                'subtotal' =>
                    round(
                        $subtotal,
                        2
                    ),

                'discount_amount' =>
                    round(
                        $discountAmount,
                        2
                    ),

                'vat_amount' =>
                    round(
                        $vatAmount,
                        2
                    ),

                'total_amount' =>
                    round(
                        $grandTotal,
                        2
                    ),

            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);


            return response()->json([

                'status' =>
                    false,

                'message' =>
                    $e->getMessage(),

            ], 500);
        }
    }


    public function markContacted(Request $request, $id)
    {
        $user = auth()->user();

        $lead = Lead::findOrFail($id);

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Update Current Status
        |--------------------------------------------------------------------------
        */

        $lead->status = 'contacted';

        $lead->save();


        /*
        |--------------------------------------------------------------------------
        | Save Activity
        |--------------------------------------------------------------------------
        */

        LeadAction::create([

            'lead_id' => $lead->id,

            'user_id' => $user->id,

            'action_type' => 'contacted',

            'action_label' => 'Contacted',

            'note' => 'Call initiated from lead panel.',

            'action_at' => now(),

        ]);


        return response()->json([

            'status' => true,

            'lead_status' => 'contacted',

        ]);
    }


    public function storeLeadAction(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE REQUEST
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'action_type' => 'required|string|max:50',
            'note' => 'nullable|string|max:2000',
            'quotation_id' => 'nullable|integer',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER + LEAD
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $lead = Lead::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to update this lead.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | ALLOWED ACTIONS
        |--------------------------------------------------------------------------
        */

        $allowedActions = [
            'call' => 'Call',
            'whatsapp' => 'WhatsApp',
            'contacted' => 'Contacted',
            'follow_up' => 'Follow Up',
            'deal_close' => 'Deal Close',
            'not_interested' => 'Not Interested',
            'not_contactable' => 'Not Contactable',
            'wrong_category' => 'Wrong Category',
            'out_of_area' => 'Out of Area',
            'marketing_job' => 'Marketing / Job',
            'quotation_shared' => 'Quotation Shared',
        ];


        /*
        |--------------------------------------------------------------------------
        | INVALID ACTION
        |--------------------------------------------------------------------------
        */

        if (!array_key_exists(
            $request->action_type,
            $allowedActions
        )) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid lead action.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | NOT INTERESTED
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Not Interested should NOT create a LeadAction row.
        | It only updates the lead status to reject.
        |
        */

        if ($request->action_type === 'not_interested') {

            $lead->status = 'reject';
            $lead->save();

            return response()->json([
                'status' => true,

                'message' =>
                    'Lead marked as Not Interested.',

                'lead_status' =>
                    'reject',

                'call_count' =>
                    (int) LeadAction::where(
                        'lead_id',
                        $lead->id
                    )->sum(
                        'call_count'
                    ),

                /*
                 * This response is only for the frontend.
                 * No LeadAction record has been created.
                 */
                'action' => [
                    'id' =>
                        null,

                    'type' =>
                        'not_interested',

                    'label' =>
                        'Not Interested',

                    'user' =>
                        $user->name,

                    'time' =>
                        now()->format(
                            'd M Y, h:i A'
                        ),
                ],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CALL ACTION
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Call count is independent from action_type.
        |
        | Example:
        |
        | action_type = not_contactable
        | call_count  = 2
        |
        | Call again:
        |
        | action_type = not_contactable
        | call_count  = 3
        |
        | action_type WILL NOT become "call".
        |
        */

        if ($request->action_type === 'call') {

            /*
            |--------------------------------------------------------------------------
            | FIND LATEST ACTION ROW FOR THIS LEAD
            |--------------------------------------------------------------------------
            */

            $action = LeadAction::where(
                'lead_id',
                $lead->id
            )
            ->orderByDesc('action_at')
            ->orderByDesc('id')
            ->first();


            /*
            |--------------------------------------------------------------------------
            | EXISTING ACTION FOUND
            |--------------------------------------------------------------------------
            */

            if ($action) {

                /*
                * Increase call count only.
                */

                $action->call_count =
                    (int) ($action->call_count ?? 0) + 1;


                /*
                * Update who made latest call.
                */

                $action->user_id =
                    $user->id;


                /*
                * Update latest activity time.
                */

                $action->action_at =
                    now();


                /*
                * IMPORTANT:
                *
                * DO NOT CHANGE:
                *
                * $action->action_type
                * $action->action_label
                *
                * Existing action remains exactly same.
                */


                /*
                * Optional:
                * Keep existing note untouched.
                *
                * If you want call note then uncomment:
                *
                * $action->note =
                *     $request->filled('note')
                *         ? $request->note
                *         : $action->note;
                */


                $action->save();

                $action->refresh();

            } else {

                /*
                |--------------------------------------------------------------------------
                | NO ACTION EXISTS FOR LEAD
                |--------------------------------------------------------------------------
                |
                | Only in this special case create an initial action row.
                |
                */

                $action = LeadAction::create([
                    'lead_id' => $lead->id,

                    'user_id' => $user->id,

                    'action_type' => 'contacted',

                    'action_label' => 'Contacted',

                    'call_count' => 1,

                    'note' => $request->filled('note')
                        ? $request->note
                        : 'Call initiated from lead panel.',

                    'quotation_id' => null,

                    'meta' => null,

                    'action_at' => now(),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | RETURN CALL RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'status' => true,

                'message' =>
                    'Call count updated successfully.',

                'lead_status' =>
                    $lead->status,

                'call_count' =>
                    (int) $action->call_count,

                'action' => [
                    'id' =>
                        $action->id,

                    'type' =>
                        $action->action_type,

                    'label' =>
                        $action->action_label,

                    'user' =>
                        $user->name,

                    'time' =>
                        optional(
                            $action->action_at
                        )->format(
                            'd M Y, h:i A'
                        ),
                ],
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | ALL OTHER ACTIONS
        |--------------------------------------------------------------------------
        |
        | Normal lead activity.
        |
        */

        $action = LeadAction::create([
            'lead_id' =>
                $lead->id,

            'user_id' =>
                $user->id,

            'action_type' =>
                $request->action_type,

            'action_label' =>
                $allowedActions[
                    $request->action_type
                ],

            /*
            * New normal action starts at 0 calls.
            */
            'call_count' =>
                0,

            'note' =>
                $request->note,

            'quotation_id' =>
                $request->quotation_id ?: null,

            'meta' =>
                $request->meta ?? null,

            'action_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPDATE LEAD STATUS
        |--------------------------------------------------------------------------
        */

        switch ($request->action_type) {

            case 'contacted':

                $lead->status =
                    'contacted';

                break;


            case 'deal_close':

                $lead->status =
                    'accept';

                break;


        }


        $lead->save();


        /*
        |--------------------------------------------------------------------------
        | TOTAL CALL COUNT FOR THIS LEAD
        |--------------------------------------------------------------------------
        */

        $currentCallCount = LeadAction::where(
            'lead_id',
            $lead->id
        )
        ->sum(
            'call_count'
        );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,

            'message' =>
                'Lead action saved successfully.',

            'lead_status' =>
                $lead->status,

            'call_count' =>
                (int) $currentCallCount,

            'action' => [
                'id' =>
                    $action->id,

                'type' =>
                    $action->action_type,

                'label' =>
                    $action->action_label,

                'user' =>
                    $user->name,

                'time' =>
                    optional(
                        $action->action_at
                    )->format(
                        'd M Y, h:i A'
                    ),
            ],
        ]);
    }


    public function leadActionsIndex(Request $request) 
    {
        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $baseQuery =
            LeadAction::query();


        /*
        |--------------------------------------------------------------------------
        | SALES ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        if (!$user->hasRole('Admin')) {

            $baseQuery->whereHas(
                'lead',
                function ($q) use ($user) {

                    $q->where(
                        'user_id',
                        $user->id
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL ACTIONS
        |--------------------------------------------------------------------------
        */

        $totalActions =
            (clone $baseQuery)
                ->count();


        /*
        |--------------------------------------------------------------------------
        | NORMAL ACTION COUNTS
        |--------------------------------------------------------------------------
        */

        $contactedActions =
            (clone $baseQuery)
                ->where(
                    'action_type',
                    'contacted'
                )
                ->count();


        $followUpActions =
            (clone $baseQuery)
                ->where(
                    'action_type',
                    'follow_up'
                )
                ->count();


        $quotationActions =
            (clone $baseQuery)
                ->where(
                    'action_type',
                    'quotation_shared'
                )
                ->count();


        $dealClosedActions =
            (clone $baseQuery)
                ->where(
                    'action_type',
                    'deal_close'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL CALLS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | Do NOT filter by action_type = call.
        |
        | Call count is independent from action type.
        |
        */

        $callActions =
            (clone $baseQuery)
                ->sum(
                    'call_count'
                );


        /*
        |--------------------------------------------------------------------------
        | WHATSAPP COUNT
        |--------------------------------------------------------------------------
        */

        $whatsappActions =
            (clone $baseQuery)
                ->where(
                    'action_type',
                    'whatsapp'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | CALL COUNTS BY LEAD
        |--------------------------------------------------------------------------
        */

        $callCountsByLead =
            (clone $baseQuery)
                ->selectRaw(
                    'lead_id, SUM(call_count) as total'
                )
                ->groupBy(
                    'lead_id'
                )
                ->pluck(
                    'total',
                    'lead_id'
                );


        /*
        |--------------------------------------------------------------------------
        | ACTION TYPE COUNTS
        |--------------------------------------------------------------------------
        */

        $actionCounts =
            (clone $baseQuery)
                ->selectRaw(
                    'action_type, COUNT(*) as total'
                )
                ->groupBy(
                    'action_type'
                )
                ->pluck(
                    'total',
                    'action_type'
                );


        /*
        |--------------------------------------------------------------------------
        | CALL TAB COUNT
        |--------------------------------------------------------------------------
        */

        $actionCounts->put(
            'call',
            (int) $callActions
        );


        /*
        |--------------------------------------------------------------------------
        | LIST QUERY
        |--------------------------------------------------------------------------
        */

        $query =
            clone $baseQuery;


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                trim(
                    $request->search
                );


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'action_label',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'action_type',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'note',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'lead',
                        function ($leadQuery)
                        use ($search) {

                            $leadQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'phone',
                                    'like',
                                    "%{$search}%"
                                );

                            /*
                            * If your leads table has
                            * a "requirement" column,
                            * uncomment this:
                            *
                            * ->orWhere(
                            *     'requirement',
                            *     'like',
                            *     "%{$search}%"
                            * )
                            */
                        }
                    )

                    ->orWhereHas(
                        'user',
                        function ($userQuery)
                        use ($search) {

                            $userQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ACTION TYPE FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'action_type'
            )
        ) {

            /*
            * CALL is special.
            *
            * A row is considered "called"
            * whenever call_count > 0.
            */

            if (
                $request->action_type ===
                'call'
            ) {

                $query->where(
                    'call_count',
                    '>',
                    0
                );

            } else {

                $query->where(
                    'action_type',
                    $request->action_type
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SALES USER FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('Admin') &&
            $request->filled('user_id')
        ) {

            $query->where(
                'user_id',
                $request->user_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FROM DATE
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'action_at',
                '>=',
                $request->from_date
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TO DATE
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'action_at',
                '<=',
                $request->to_date
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD ACTIONS
        |--------------------------------------------------------------------------
        */

        $actions =
            $query
                ->with([
                    'lead',
                    'user',
                    'quotation',
                ])
                ->orderByDesc(
                    'action_at'
                )
                ->orderByDesc(
                    'id'
                )
                ->paginate(
                    30
                )
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | SALES USERS FOR ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            $salesUsers =
                User::role('Sales')
                    ->orderBy(
                        'name'
                    )
                    ->get();

        } else {

            $salesUsers =
                collect();
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.leads.actions.index',
            compact(
                'actions',
                'salesUsers',
                'totalActions',
                'callActions',
                'whatsappActions',
                'contactedActions',
                'followUpActions',
                'quotationActions',
                'dealClosedActions',
                'actionCounts',
                'callCountsByLead'
            )
        );
    }


    public function updateLeadActionType(Request $request, $id) 
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'action_type' =>
                'required|string|max:50',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $user =
            auth()->user();


        /*
        |--------------------------------------------------------------------------
        | FIND ACTION
        |--------------------------------------------------------------------------
        */

        $action =
            LeadAction::with('lead')
                ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin') &&
            (
                !$action->lead ||
                (int) $action->lead->user_id !==
                    (int) $user->id
            )
        ) {
            return response()->json([
                'status' => false,
                'message' =>
                    'You are not allowed to update this lead action.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | ALLOWED UPDATE ACTIONS
        |--------------------------------------------------------------------------
        */

        $allowedActions = [
            'follow_up' =>
                'Follow Up',

            'deal_close' =>
                'Deal Close',

            'not_interested' =>
                'Not Interested',

            'not_contactable' =>
                'Not Contactable',

            'wrong_category' =>
                'Wrong Category',

            'out_of_area' =>
                'Out of Area',

            'marketing_job' =>
                'Marketing / Job',
        ];


        /*
        |--------------------------------------------------------------------------
        | INVALID ACTION
        |--------------------------------------------------------------------------
        */

        if (!array_key_exists(
            $request->action_type,
            $allowedActions
        )) {
            return response()->json([
                'status' => false,
                'message' =>
                    'Invalid lead action.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE CURRENT CALL COUNT
        |--------------------------------------------------------------------------
        |
        | This must NEVER reset while action_type changes.
        |
        */

        $existingCallCount =
            (int) ($action->call_count ?? 0);


        /*
        |--------------------------------------------------------------------------
        | UPDATE SAME ROW
        |--------------------------------------------------------------------------
        */

        $action->action_type =
            $request->action_type;

        $action->action_label =
            $allowedActions[
                $request->action_type
            ];

        $action->user_id =
            $user->id;

        $action->action_at =
            now();


        /*
        |--------------------------------------------------------------------------
        | PRESERVE CALL COUNT
        |--------------------------------------------------------------------------
        */

        $action->call_count =
            $existingCallCount;


        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        */

        $action->save();

        $action->refresh();


        /*
        |--------------------------------------------------------------------------
        | UPDATE LEAD STATUS
        |--------------------------------------------------------------------------
        */

        $lead =
            $action->lead;


        if ($lead) {

            switch (
                $request->action_type
            ) {

                case 'deal_close':

                    $lead->status =
                        'accept';

                    break;


                case 'not_interested':

                    $lead->status =
                        'reject';

                    break;


                /*
                * For these actions,
                * keep current lead status as it is.
                */

                case 'follow_up':

                case 'not_contactable':

                case 'wrong_category':

                case 'out_of_area':

                case 'marketing_job':

                    break;
            }


            $lead->save();
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL CALL COUNT
        |--------------------------------------------------------------------------
        */

        $totalCallCount =
            LeadAction::where(
                'lead_id',
                $action->lead_id
            )
            ->sum(
                'call_count'
            );


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,

            'message' =>
                'Lead action updated successfully.',

            'call_count' =>
                (int) $totalCallCount,

            'action' => [
                'id' =>
                    $action->id,

                'type' =>
                    $action->action_type,

                'label' =>
                    $action->action_label,

                'user' =>
                    $user->name,

                'time' =>
                    optional(
                        $action->action_at
                    )->format(
                        'd M Y, h:i A'
                    ),
            ],

            'lead_status' =>
                $lead->status ?? null,
        ]);
    }

    public function storeFollowUp(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'call_schedule' => 'required|date',
            'remarks'       => 'nullable|string|max:2000',
            'user_id'       => 'nullable|integer|exists:users,id',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER + LEAD
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $lead = Lead::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to update this lead.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | ASSIGN USER
        |--------------------------------------------------------------------------
        |
        | Admin can reassign.
        | Sales cannot assign lead to someone else.
        |
        */

        if (
            $user->hasRole('Admin') &&
            $request->filled('user_id')
        ) {
            $lead->user_id = $request->user_id;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE LEAD
        |--------------------------------------------------------------------------
        |
        | Follow Up submit hone ke baad lead status = call.
        |
        | Since Lead Index only shows pending/contacted,
        | this lead will automatically leave that list.
        |
        */

        $lead->status = 'call';

        $lead->call_schedule =
            $request->call_schedule;

        if ($request->filled('remarks')) {
            $lead->remarks =
                $request->remarks;
        }

        $lead->save();


        /*
        |--------------------------------------------------------------------------
        | LEAD ACTION HISTORY
        |--------------------------------------------------------------------------
        |
        | Lead Index se Follow Up hua hai,
        | therefore Lead Actions page me Follow Up dikhega.
        |
        */

        $action = LeadAction::create([
            'lead_id' =>
                $lead->id,

            'user_id' =>
                $user->id,

            'action_type' =>
                'follow_up',

            'action_label' =>
                'Follow Up',

            'call_count' =>
                0,

            'note' =>
                $request->filled('remarks')
                    ? $request->remarks
                    : 'Follow up scheduled.',

            'quotation_id' =>
                null,

            'meta' => [
                'call_schedule' =>
                    $request->call_schedule,

                'assigned_user_id' =>
                    $lead->user_id,
            ],

            'action_at' =>
                now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => true,

            'message' =>
                'Follow up scheduled successfully.',

            'lead_status' =>
                $lead->status,

            'call_schedule' =>
                $lead->call_schedule,

            'action' => [
                'id' =>
                    $action->id,

                'type' =>
                    $action->action_type,

                'label' =>
                    $action->action_label,
            ],
        ]);
    }


    public function sendDetailedQuotation(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'detailed_quotation_id' => [
                'required',
                'integer',
                'exists:detailed_quotations,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CURRENT USER + LEAD
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        $lead = Lead::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        |
        | Admin = any lead
        | Sales = only assigned lead
        |
        */

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' =>
                    'You are not allowed to access this lead.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | FIND DETAILED QUOTATION
        |--------------------------------------------------------------------------
        */

        $detailedQuotation =
            DetailedQuotation::findOrFail(
                $request->detailed_quotation_id
            );


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | CREATE NORMAL QUOTATION RECORD
            |--------------------------------------------------------------------------
            |
            | Detailed Quotation master PDF reusable rahegi.
            |
            | Har baar jab kisi lead/customer ko ye PDF send hogi,
            | normal quotations table me ek history record create hoga.
            |
            */

            $quotation = Quotation::create([

                'client_id' => null,

                'lead_id' => $lead->id,

                'user_id' => $user->id,

                'quotation_type' => 'detailed',

                'create_date' =>
                    now()->toDateString(),

                'due_date' => null,

                'note' =>
                    'Detailed Quotation: ' .
                    $detailedQuotation->name,

                'terms_condition' => null,

                'discount' => 0,

                'vat' => 0,

                'payment_type' => null,

                'payment_currency' => 1,

                'sales_credit' =>
                    $lead->user_id,

            ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE QUOTATION ITEM
            |--------------------------------------------------------------------------
            |
            | Detailed PDF ke andar actual quotation content already hai.
            |
            | Isliye normal quotation me ek reference item create kar rahe hain
            | taaki quotation completely empty na ho.
            |
            */

            QuotationItem::create([

                'quotation_id' =>
                    $quotation->id,

                /*
                * 0 = custom item
                */
                'description' => 0,

                'custom_description' =>
                    $detailedQuotation->name,

                'quantity' => 1,

                /*
                * Detailed PDF ka price structured DB me available nahi hai.
                */
                'unit_price' => 0,

            ]);


            /*
            |--------------------------------------------------------------------------
            | QUOTATION NUMBER
            |--------------------------------------------------------------------------
            */

            $quotationNumber =
                'QT-' .
                str_pad(
                    $quotation->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |--------------------------------------------------------------------------
            | CREATE TEMPORARY PUBLIC PDF LINK
            |--------------------------------------------------------------------------
            |
            | No CRM login required.
            | Link automatically expires after 7 days.
            |
            */

            $pdfUrl =
                URL::temporarySignedRoute(

                    'detailed-quotations.public-share',

                    now()->addDays(7),

                    [
                        'quotation' =>
                            $detailedQuotation->id,
                    ]

                );


            /*
            |--------------------------------------------------------------------------
            | SAVE LEAD ACTION
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | quotation_id now points to NORMAL quotations table.
            |
            | detailed_quotation_id remains inside meta.
            |
            */

            $action = LeadAction::create([

                'lead_id' =>
                    $lead->id,

                'user_id' =>
                    $user->id,

                'action_type' =>
                    'quotation_shared',

                'action_label' =>
                    'Detailed Quotation Shared',

                'call_count' => 0,

                /*
                * Normal quotation FK.
                */
                'quotation_id' =>
                    $quotation->id,

                'note' =>
                    'Detailed quotation ' .
                    $quotationNumber .
                    ' shared on WhatsApp: ' .
                    $detailedQuotation->name,

                'meta' => [

                    /*
                    * Normal quotation details
                    */
                    'quotation_number' =>
                        $quotationNumber,

                    'quotation_id' =>
                        $quotation->id,


                    /*
                    * Detailed quotation master reference
                    */
                    'quotation_source' =>
                        'detailed_quotation',

                    'detailed_quotation_id' =>
                        $detailedQuotation->id,

                    'detailed_quotation_name' =>
                        $detailedQuotation->name,


                    /*
                    * Sharing information
                    */
                    'channel' =>
                        'whatsapp',

                    'pdf_url' =>
                        $pdfUrl,

                ],

                'action_at' =>
                    now(),

            ]);


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | DETAILED QUOTATION → UPDATE LEAD STATUS
            |--------------------------------------------------------------------------
            */

            $lead->status = 'detailed-quotation';

            // Move linked lead to Quotation Sent
            $lead->stage = 'Proposal Sent';

            $lead->save();

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | SUCCESS RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' => true,

                'message' =>
                    'Detailed quotation saved and added to Lead Actions.',


                /*
                * Normal quotation
                */
                'quotation_id' =>
                    $quotation->id,

                'quotation_no' =>
                    $quotationNumber,


                /*
                * Detailed quotation
                */
                'detailed_quotation_id' =>
                    $detailedQuotation->id,

                'quotation_name' =>
                    $detailedQuotation->name,


                /*
                * WhatsApp PDF link
                */
                'pdf_url' =>
                    $pdfUrl,


                /*
                * Lead Action
                */
                'action' => [

                    'id' =>
                        $action->id,

                    'type' =>
                        $action->action_type,

                    'label' =>
                        $action->action_label,

                ],

            ]);


        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return response()->json([

                'status' => false,

                'message' =>
                    $e->getMessage(),

            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'lead_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'lead_ids.*' => [
                'required',
                'integer',
                'exists:leads,id',
            ],
        ]);

        $user = auth()->user();

        $query = Lead::whereIn(
            'id',
            $request->lead_ids
        );

        /*
        * Sales user sirf apne assigned leads
        * delete kar sakta hai.
        */
        if (!$user->hasRole('Admin')) {

            $query->where(
                'user_id',
                $user->id
            );
        }

        $leads = $query->get();

        if ($leads->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' =>
                    'No authorized leads found for deletion.',
            ], 403);
        }

        $deletedCount = 0;

        foreach ($leads as $lead) {

            /*
            * Agar Lead model relations / DB cascade
            * configured hain to normal delete use karo.
            */

            $lead->delete();

            $deletedCount++;
        }

        return response()->json([
            'status' => true,
            'message' =>
                $deletedCount .
                ' lead(s) deleted successfully.',

            'deleted_count' =>
                $deletedCount,
        ]);
    }

    // 

    public function storeQuickProforma(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',

            'items' => 'required|array|min:1',

            'items.*.product_id' =>
                'nullable|exists:products,id',

            'items.*.custom_description' =>
                'nullable|string|max:255',

            'items.*.hsn_code' =>
                'required|string|max:50',

            'items.*.quantity' =>
                'required|numeric|min:1',

            'items.*.unit_price' =>
                'required|numeric|min:0',

            'discount' =>
                'nullable|numeric|min:0|max:100',

            'vat' =>
                'nullable|numeric|min:0|max:100',

            'note' =>
                'nullable|string|max:2000',
        ]);


        $user = auth()->user();

        $lead = Lead::findOrFail(
            $request->lead_id
        );


        /*
        |--------------------------------------------------------------------------
        | ACCESS CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' =>
                    'You are not allowed to create proforma for this lead.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK CUSTOMER / COMPANY
        |--------------------------------------------------------------------------
        */



        /*
        |--------------------------------------------------------------------------
        | CHECK BRANCH
        |--------------------------------------------------------------------------
        */

        if (empty($lead->branch_id)) {

            return response()->json([
                'status' => false,
                'message' =>
                    'Branch is not available for this lead.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK PRODUCT OR CUSTOM PRODUCT
        |--------------------------------------------------------------------------
        */

        foreach ($request->items as $item) {

            $productId =
                $item['product_id'] ?? null;

            $customDescription =
                trim(
                    $item['custom_description'] ?? ''
                );


            if (
                empty($productId) &&
                empty($customDescription)
            ) {
                return response()->json([
                    'status' => false,
                    'message' =>
                        'Please select a product or enter a custom product/service.',
                ], 422);
            }
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | CALCULATE SUBTOTAL
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;


            foreach ($request->items as $item) {

                $quantity =
                    (float) $item['quantity'];

                $unitPrice =
                    (float) $item['unit_price'];


                $subtotal +=
                    $quantity * $unitPrice;
            }


            /*
            |--------------------------------------------------------------------------
            | DISCOUNT
            |--------------------------------------------------------------------------
            */

            $discountPercent =
                (float) ($request->discount ?? 0);


            $discountAmount =
                ($subtotal * $discountPercent) / 100;


            $afterDiscount =
                $subtotal - $discountAmount;


            /*
            |--------------------------------------------------------------------------
            | GST
            |--------------------------------------------------------------------------
            */

            $gstPercent =
                (float) ($request->vat ?? 0);


            $gstAmount =
                ($afterDiscount * $gstPercent) / 100;


            /*
            |--------------------------------------------------------------------------
            | GRAND TOTAL
            |--------------------------------------------------------------------------
            */

            $grandTotal =
                $afterDiscount + $gstAmount;


            /*
            |--------------------------------------------------------------------------
            | GENERATE PROFORMA NUMBER
            |--------------------------------------------------------------------------
            */

            $lastProforma =
                Proforma::latest('id')->first();


            $nextId =
                $lastProforma
                    ? $lastProforma->id + 1
                    : 1;


            $proformaNo =
                'PF-' .
                str_pad(
                    $nextId,
                    5,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |--------------------------------------------------------------------------
            | CREATE PROFORMA
            |--------------------------------------------------------------------------
            |
            | Important:
            | subtotal yahan discount ke baad wala amount save kar rahe hain,
            | because current proformas table me separate discount column nahi hai.
            |
            */

            $proforma = Proforma::create([

                'proforma_no' =>
                    $proformaNo,

                 'customer_id' => null,

                'proforma_date' =>
                    now()->toDateString(),

                'subtotal' =>
                    round(
                        $afterDiscount,
                        2
                    ),

                'tax' =>
                    round(
                        $gstAmount,
                        2
                    ),

                'total' =>
                    round(
                        $grandTotal,
                        2
                    ),

                'status' =>
                    'proforma',

                'stage' =>
                    'Send Proforma',

                'notes' =>
                    $request->note,

                'branch_id' =>
                    $lead->branch_id,

                'lead_id' =>
                    $lead->id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE PROFORMA ITEMS
            |--------------------------------------------------------------------------
            */

            foreach ($request->items as $item) {

                $productId =
                    $item['product_id'] ?? null;


                $customDescription =
                    trim(
                        $item['custom_description'] ?? ''
                    );


                $quantity =
                    (float) $item['quantity'];


                $unitPrice =
                    (float) $item['unit_price'];


                $hsnCode =
                    trim(
                        $item['hsn_code']
                    );


                $lineAmount =
                    $quantity * $unitPrice;


                /*
                * Overall GST same rate har item me store kar rahe hain,
                * kyunki Quick Quotation modal me GST overall 18% toggle hai.
                */

                $itemTax =
                    ($lineAmount * $gstPercent) / 100;


                ProformaItem::create([

                    'proforma_id' =>
                        $proforma->id,

                    'product_id' =>
                        $productId,

                    'custom_description' =>
                        $customDescription !== ''
                            ? $customDescription
                            : null,

                    'price' =>
                        $unitPrice,

                    'quantity' =>
                        $quantity,

                    'hsn_code' =>
                        $hsnCode,

                    'gst' =>
                        $gstPercent,

                    'line_total' =>
                        round(
                            $lineAmount + $itemTax,
                            2
                        ),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | LEAD ACTION
            |--------------------------------------------------------------------------
            */

            LeadAction::create([

                'lead_id' =>
                    $lead->id,

                'user_id' =>
                    $user->id,

                'action_type' =>
                    'proforma_shared',

                'action_label' =>
                    'Proforma Created',

                /*
                * Ye quotation nahi hai.
                */
                'quotation_id' =>
                    null,

                'note' =>
                    'Proforma ' .
                    $proformaNo .
                    ' created for this lead.',

                'meta' => [

                    'proforma_id' =>
                        $proforma->id,

                    'proforma_number' =>
                        $proformaNo,

                    'subtotal' =>
                        round($subtotal, 2),

                    'discount' =>
                        $discountPercent,

                    'discount_amount' =>
                        round(
                            $discountAmount,
                            2
                        ),

                    'gst' =>
                        $gstPercent,

                    'gst_amount' =>
                        round(
                            $gstAmount,
                            2
                        ),

                    'total' =>
                        round(
                            $grandTotal,
                            2
                        ),

                    'stage' =>
                        'Send Proforma',
                ],

                'action_at' =>
                    now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | LEAD STATUS
            |--------------------------------------------------------------------------
            |
            | Lead ka transaction ab Proforma ban chuka hai.
            | Pipeline stage Proforma.stage se chalega.
            |
            */

            $lead->status =
                'quick-quotation';

            $lead->save();


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | SUCCESS RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' =>
                    true,

                'message' =>
                    'Proforma created successfully.',

                'proforma_id' =>
                    $proforma->id,

                'proforma_no' =>
                    $proforma->proforma_no,

                'stage' =>
                    $proforma->stage,

                'subtotal' =>
                    round(
                        $subtotal,
                        2
                    ),

                'discount_amount' =>
                    round(
                        $discountAmount,
                        2
                    ),

                'vat_amount' =>
                    round(
                        $gstAmount,
                        2
                    ),

                'total_amount' =>
                    round(
                        $grandTotal,
                        2
                    ),
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);


            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    // ============================================================
    // SALES PIPELINE
    // ============================================================

    // public function salespipeline()
    // {
    //     $stages = [
    //         'New Lead',
    //         'Contacted',
    //         'Quotation Pending',
    //         'Proforma Pending',
    //         'Send Proforma',
    //         'Quotation Sent',
    //         'Negotiation',
    //         'Payment Waiting',
    //         'Won',
    //         'Lost',
    //     ];

    //     // Send Proforma Lead ka stored stage nahi hai.
    //     // Lead par ye special action/modal trigger hai.
    //     $leadDbStages = [
    //         'New Lead',
    //         'Contacted',
    //         'Quotation Pending',
    //         'Proforma Pending',
    //         'Quotation Sent',
    //         'Negotiation',
    //         'Payment Waiting',
    //         'Won',
    //         'Lost',
    //     ];

    //     $user = auth()->user();


    //     // --------------------------------------------------------
    //     // LEADS
    //     // --------------------------------------------------------

    //     $leadQuery = Lead::with('userlead')
    //         ->where('status', 'accept')
    //         ->whereIn('stage', $leadDbStages);

    //     if ($user->hasRole('Admin')) {
    //         // Admin sees all.
    //     } elseif ($user->hasRole('Sales')) {
    //         $leadQuery->where('branch_id', $user->branch_id);
    //     } else {
    //         $leadQuery->where('user_id', $user->id);
    //     }

    //     $leads = $leadQuery
    //         ->latest()
    //         ->get();


    //     // --------------------------------------------------------
    //     // PROFORMAS
    //     // --------------------------------------------------------

    //     $proformaQuery = Proforma::with([
    //         'lead.userlead',
    //         'customer',
    //         'items',
    //     ])
    //         ->whereNotNull('lead_id')
    //         ->whereIn('stage', $stages);

    //     if ($user->hasRole('Admin')) {
    //         // Admin sees all.
    //     } elseif ($user->hasRole('Sales')) {
    //         $proformaQuery->whereHas('lead', function ($query) use ($user) {
    //             $query->where('branch_id', $user->branch_id);
    //         });
    //     } else {
    //         $proformaQuery->whereHas('lead', function ($query) use ($user) {
    //             $query->where('user_id', $user->id);
    //         });
    //     }

    //     $proformas = $proformaQuery
    //         ->latest()
    //         ->get();


    //     // --------------------------------------------------------
    //     // DETAILED QUOTATIONS
    //     // --------------------------------------------------------
    //     //
    //     // quotations table me pipeline_stage use nahi hota.
    //     // Detailed quotation ka stage linked Lead.stage se aata hai.
    //     // --------------------------------------------------------

    //     $quotationQuery = Quotation::with([
    //         'lead.userlead',
    //         'client',
    //         'user',
    //         'items',
    //     ])
    //         ->whereNotNull('lead_id')
    //         ->whereHas('lead', function ($query) use ($leadDbStages) {
    //             $query->whereIn('stage', $leadDbStages);
    //         });

    //     if ($user->hasRole('Admin')) {
    //         // Admin sees all.
    //     } elseif ($user->hasRole('Sales')) {
    //         $quotationQuery->whereHas('lead', function ($query) use ($user) {
    //             $query->where('branch_id', $user->branch_id);
    //         });
    //     } else {
    //         $quotationQuery->where(function ($query) use ($user) {
    //             $query
    //                 ->where('user_id', $user->id)
    //                 ->orWhereHas('lead', function ($leadQuery) use ($user) {
    //                     $leadQuery->where('user_id', $user->id);
    //                 });
    //         });
    //     }

    //     $quotations = $quotationQuery
    //         ->latest()
    //         ->get();


    //     return view(
    //         'admin.leads.salespipeline',
    //         compact(
    //             'stages',
    //             'leads',
    //             'proformas',
    //             'quotations'
    //         )
    //     );
    // }

     public function salespipeline()
    {
       

        $stages = [
            'New Lead',
            'Contacted',
            'Proposal Pending',
            'Proforma Pending',
            'Send Proforma',
            'Proposal Sent',
            'Negotiation',
            'Payment Waiting',
            'Won',
            'Lost',
        ];

        // Send Proforma Lead ka stored stage nahi hai.
        // Lead par ye special action/modal trigger hai.
      

        $leadDbStages = [
            'New Lead',
            'Contacted',
            'Proposal Pending',
            'Proforma Pending',
            'Proposal Sent',
            'Negotiation',
            'Payment Waiting',
            'Won',
            'Lost',
        ];

        $user = auth()->user();


        // --------------------------------------------------------
        // LEADS
        // --------------------------------------------------------

        $leadQuery = Lead::with('userlead')
            ->where('status', 'accept')
            ->whereIn('stage', $leadDbStages);

        if ($user->hasRole('Admin')) {
            // Admin sees all.
        } elseif ($user->hasRole('Sales')) {
            $leadQuery->where('branch_id', $user->branch_id);
        } else {
            $leadQuery->where('user_id', $user->id);
        }

        $leads = $leadQuery
            ->latest()
            ->get();


        // --------------------------------------------------------
        // PROFORMAS
        // --------------------------------------------------------

        $proformaQuery = Proforma::with([
            'lead.userlead',
            'customer',
            'items',
        ])
            ->whereNotNull('lead_id')
            ->whereIn('stage', $stages);

        if ($user->hasRole('Admin')) {
            // Admin sees all.
        } elseif ($user->hasRole('Sales')) {
            $proformaQuery->whereHas('lead', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            });
        } else {
            $proformaQuery->whereHas('lead', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $proformas = $proformaQuery
            ->latest()
            ->get();


        // --------------------------------------------------------
        // DETAILED QUOTATIONS
        // --------------------------------------------------------
        //
        // quotations table me pipeline_stage use nahi hota.
        // Detailed quotation ka stage linked Lead.stage se aata hai.
        // --------------------------------------------------------

        $quotationQuery = Quotation::with([
            'lead.userlead',
            'client',
            'user',
            'items',
        ])
            ->whereNotNull('lead_id')
            ->whereHas('lead', function ($query) use ($leadDbStages) {
                $query->whereIn('stage', $leadDbStages);
            });

        if ($user->hasRole('Admin')) {
            // Admin sees all.
        } elseif ($user->hasRole('Sales')) {
            $quotationQuery->whereHas('lead', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            });
        } else {
            $quotationQuery->where(function ($query) use ($user) {
                $query
                    ->where('user_id', $user->id)
                    ->orWhereHas('lead', function ($leadQuery) use ($user) {
                        $leadQuery->where('user_id', $user->id);
                    });
            });
        }

        $quotations = $quotationQuery
            ->latest()
            ->get();


        return view(
            'admin.leads.salespipeline',
            compact(
                'stages',
                'leads',
                'proformas',
                'quotations'
            )
        );
    }


    // ============================================================
    // UPDATE LEAD STAGE
    // ============================================================

    public function updateStage(Request $request, $id)
    {
        $request->validate([
            'stage' => [
                'required',
                'string',
                'in:New Lead,Contacted,Proposal Pending,Proforma Pending,Proposal Sent,Negotiation,Payment Waiting,Won,Lost',            ],
        ]);

        $user = auth()->user();

        $lead = Lead::findOrFail($id);

        if ($user->hasRole('Admin')) {
            // Allowed.
        } elseif ($user->hasRole('Sales')) {

            if ((int) $lead->branch_id !== (int) $user->branch_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this lead.',
                ], 403);
            }

        } else {

            if ((int) $lead->user_id !== (int) $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this lead.',
                ], 403);
            }
        }

        $lead->stage = $request->stage;
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Lead stage updated successfully.',
            'lead_id' => $lead->id,
            'stage' => $lead->stage,
        ]);
    }


    // ============================================================
    // UPDATE PROFORMA STAGE
    // ============================================================

    public function updateProformaStage(Request $request, $id)
    {
        $request->validate([
            'stage' => [
                'required',
                'string',
                'in:New Lead,Contacted,Proposal Pending,Proforma Pending,Send Proforma,Proposal Sent,Negotiation,Payment Waiting,Won,Lost',            ],
        ]);

        $user = auth()->user();

        $proforma = Proforma::with('lead')
            ->findOrFail($id);

        if ($user->hasRole('Admin')) {
            // Allowed.
        } elseif ($user->hasRole('Sales')) {

            if ($proforma->lead) {

                if (
                    (int) $proforma->lead->branch_id
                    !==
                    (int) $user->branch_id
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not allowed to update this proforma.',
                    ], 403);
                }

            } elseif (
                (int) $proforma->branch_id
                !==
                (int) $user->branch_id
            ) {

                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this proforma.',
                ], 403);
            }

        } else {

            if (
                !$proforma->lead
                ||
                (int) $proforma->lead->user_id
                !==
                (int) $user->id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this proforma.',
                ], 403);
            }
        }

        $proforma->stage = $request->stage;
        $proforma->save();

        return response()->json([
            'success' => true,
            'message' => 'Proforma stage updated successfully.',
            'proforma_id' => $proforma->id,
            'stage' => $proforma->stage,
        ]);
    }


    // ============================================================
    // UPDATE DETAILED QUOTATION STAGE
    // ============================================================
    //
    // quotations table me stage column nahi hai.
    // Isliye linked Lead.stage update hota hai.
    // ============================================================

    public function updateQuotationStage(Request $request, $id)
    {
        $request->validate([
            'stage' => [
                'required',
                'string',
                'in:New Lead,Contacted,Proposal Pending,Proforma Pending,Proposal Sent,Negotiation,Payment Waiting,Won,Lost',            ],
        ]);

        $user = auth()->user();

        $quotation = Quotation::with('lead')
            ->findOrFail($id);

        if (!$quotation->lead_id || !$quotation->lead) {
            return response()->json([
                'success' => false,
                'message' => 'This quotation is not linked with a lead.',
            ], 422);
        }

        $lead = $quotation->lead;

        if ($user->hasRole('Admin')) {
            // Allowed.
        } elseif ($user->hasRole('Sales')) {

            if (
                (int) $lead->branch_id
                !==
                (int) $user->branch_id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this quotation.',
                ], 403);
            }

        } else {

            if (
                (int) $lead->user_id
                !==
                (int) $user->id
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not allowed to update this quotation.',
                ], 403);
            }
        }

        $lead->stage = $request->stage;
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Quotation stage updated successfully.',
            'quotation_id' => $quotation->id,
            'lead_id' => $lead->id,
            'stage' => $lead->stage,
        ]);
    }

    public function importHistory(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | CURRENT USER
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | BASE IMPORT HISTORY QUERY
        |--------------------------------------------------------------------------
        */

        $query = LeadImportBatch::query()
            ->with([
                'salesUser',
                'category',
                'uploadedBy',
            ]);


        /*
        |--------------------------------------------------------------------------
        | ACCESS CONTROL
        |--------------------------------------------------------------------------
        |
        | Admin:
        |   Can see all import batches.
        |
        | Sales:
        |   Can see batches belonging to their branch.
        |
        | Other users:
        |   Can see only batches uploaded by themselves.
        |
        */

        if ($user->hasRole('Admin')) {

            // Admin = all imports

        } elseif ($user->hasRole('Sales')) {

            $query->where(
                'branch_id',
                $user->branch_id
            );

        } else {

            $query->where(
                'uploaded_by',
                $user->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Search original uploaded file name.
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(
                'original_file_name',
                'like',
                '%' . $search . '%'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SALES PERSON FILTER
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('Admin') &&
            $request->filled('sales_user_id')
        ) {

            $query->where(
                'sales_user_id',
                $request->sales_user_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | IMPORT HISTORY
        |--------------------------------------------------------------------------
        */

        $batches = $query
            ->latest('id')
            ->paginate(25)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | FILTER DATA
        |--------------------------------------------------------------------------
        */

        $categories =
            \App\Models\LeadCategory::orderBy('title')
                ->get();

        $salesUsers = collect();

        if ($user->hasRole('Admin')) {

            $salesUsers =
                \App\Models\User::role('Sales')
                    ->orderBy('name')
                    ->get();

        } elseif ($user->hasRole('Sales')) {

            $salesUsers =
                \App\Models\User::role('Sales')
                    ->where(
                        'branch_id',
                        $user->branch_id
                    )
                    ->orderBy('name')
                    ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY COUNTS
        |--------------------------------------------------------------------------
        */

        $summaryQuery =
            LeadImportBatch::query();

        if ($user->hasRole('Admin')) {

            // all

        } elseif ($user->hasRole('Sales')) {

            $summaryQuery->where(
                'branch_id',
                $user->branch_id
            );

        } else {

            $summaryQuery->where(
                'uploaded_by',
                $user->id
            );
        }


        $totalImports =
            (clone $summaryQuery)->count();

        $completedImports =
            (clone $summaryQuery)
                ->where('status', 'completed')
                ->count();

        $pendingImports =
            (clone $summaryQuery)
                ->where('status', 'pending')
                ->count();

        $failedImports =
            (clone $summaryQuery)
                ->where('status', 'failed')
                ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.leads.import_history', compact('batches', 'categories', 'salesUsers', 'totalImports', 'completedImports', 'pendingImports', 'failedImports'));
    }

    protected function authorizeImportBatch(
        \App\Models\LeadImportBatch $batch
    ): void {

        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return;
        }

        if (
            (int) $batch->branch_id !==
            (int) $user->branch_id
        ) {
            abort(
                403,
                'You are not allowed to access this import batch.'
            );
        }
    }

    public function importBatchLeads(
        \App\Models\LeadImportBatch $batch
    ) {
        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        $this->authorizeImportBatch(
            $batch
        );


        /*
        |--------------------------------------------------------------------------
        | LEADS
        |--------------------------------------------------------------------------
        */

        $leads =
            \App\Models\Lead::query()
                ->where(
                    'import_batch_id',
                    $batch->id
                )
                ->with([
                    'leadcat',
                    'assignedUser',
                ])
                ->latest('id')
                ->paginate(100)
                ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.leads.import_batch_leads',
            compact(
                'batch',
                'leads'
            )
        );
    }

    public function openImportBatch(
        \App\Models\LeadImportBatch $batch
    ) {
        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        $this->authorizeImportBatch(
            $batch
        );


        /*
        |--------------------------------------------------------------------------
        | FILE PATH
        |--------------------------------------------------------------------------
        */

        $fileRelativePath = ltrim(
            str_replace(
                '\\',
                '/',
                $batch->file_path
            ),
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            str_contains(
                $fileRelativePath,
                '../'
            ) ||
            !str_starts_with(
                $fileRelativePath,
                'lead-imports/'
            )
        ) {

            abort(
                404,
                'Invalid import file path.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ABSOLUTE PATH
        |--------------------------------------------------------------------------
        */

        $filePath =
            storage_path(
                'app/' .
                $fileRelativePath
            );


        if (!file_exists($filePath)) {

            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'error_message',
                    'Original uploaded file was not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | EXTENSION
        |--------------------------------------------------------------------------
        */

        $extension = strtolower(
            pathinfo(
                $filePath,
                PATHINFO_EXTENSION
            )
        );


        /*
        |--------------------------------------------------------------------------
        | READ FILE
        |--------------------------------------------------------------------------
        */

        try {

            if (
                $extension === 'csv' ||
                $extension === 'txt'
            ) {

                $reader =
                    new \PhpOffice\PhpSpreadsheet\Reader\Csv();

                $reader->setDelimiter(',');
                $reader->setEnclosure('"');

                $spreadsheet =
                    $reader->load(
                        $filePath
                    );

            } elseif (
                $extension === 'xlsx' ||
                $extension === 'xls'
            ) {

                $spreadsheet =
                    \PhpOffice\PhpSpreadsheet\IOFactory::load(
                        $filePath
                    );

            } else {

                return redirect()
                    ->route(
                        'admin.leads.import.history'
                    )
                    ->with(
                        'error_message',
                        'Unsupported import file type.'
                    );
            }


            $worksheet =
                $spreadsheet->getActiveSheet();


            $rows =
                $worksheet->toArray(
                    null,
                    true,
                    true,
                    false
                );


        } catch (\Throwable $e) {

            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'error_message',
                    'Unable to open uploaded file.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY
        |--------------------------------------------------------------------------
        */

        if (empty($rows)) {

            if (isset($spreadsheet)) {

                $spreadsheet
                    ->disconnectWorksheets();

                unset($spreadsheet);
            }

            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'error_message',
                    'Uploaded file is empty.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HEADERS
        |--------------------------------------------------------------------------
        */

        $headers =
            array_shift(
                $rows
            );


        $headers =
            array_map(
                function ($header) {

                    $header =
                        (string) (
                            $header ?? ''
                        );

                    $header =
                        preg_replace(
                            '/^\xEF\xBB\xBF/',
                            '',
                            $header
                        );

                    return trim(
                        $header
                    );
                },
                $headers
            );


        /*
        |--------------------------------------------------------------------------
        | REMOVE EMPTY DATA ROWS
        |--------------------------------------------------------------------------
        */

        $rows =
            array_values(
                array_filter(
                    $rows,
                    function ($row) {

                        foreach ($row as $value) {

                            if (
                                trim(
                                    (string) (
                                        $value ?? ''
                                    )
                                ) !== ''
                            ) {

                                return true;
                            }
                        }

                        return false;
                    }
                )
            );


        /*
        |--------------------------------------------------------------------------
        | LIMIT PREVIEW
        |--------------------------------------------------------------------------
        */

        $totalRows =
            count(
                $rows
            );

        $previewRows =
            array_slice(
                $rows,
                0,
                100
            );


        /*
        |--------------------------------------------------------------------------
        | MEMORY CLEAN
        |--------------------------------------------------------------------------
        */

        if (isset($spreadsheet)) {

            $spreadsheet
                ->disconnectWorksheets();

            unset($spreadsheet);
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.leads.import_batch_open',
            compact(
                'batch',
                'headers',
                'previewRows',
                'totalRows'
            )
        );
    }

    public function downloadImportBatch(
    \App\Models\LeadImportBatch $batch
    ) {
        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        $this->authorizeImportBatch(
            $batch
        );


        /*
        |--------------------------------------------------------------------------
        | FILE PATH
        |--------------------------------------------------------------------------
        */

        $fileRelativePath = ltrim(
            str_replace(
                '\\',
                '/',
                $batch->file_path
            ),
            '/'
        );


        if (
            str_contains(
                $fileRelativePath,
                '../'
            ) ||
            !str_starts_with(
                $fileRelativePath,
                'lead-imports/'
            )
        ) {

            abort(
                404,
                'Invalid import file path.'
            );
        }


        $filePath =
            storage_path(
                'app/' .
                $fileRelativePath
            );


        if (!file_exists($filePath)) {

            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'error_message',
                    'Original uploaded file was not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD ORIGINAL FILE
        |--------------------------------------------------------------------------
        */

        return response()->download(
            $filePath,
            $batch->original_file_name
        );
    }

    public function deleteImportBatch(
        \App\Models\LeadImportBatch $batch
    ) {
        /*
        |--------------------------------------------------------------------------
        | ACCESS
        |--------------------------------------------------------------------------
        */

        $this->authorizeImportBatch(
            $batch
        );


        /*
        |--------------------------------------------------------------------------
        | GET ALL LEAD IDS OF THIS IMPORT
        |--------------------------------------------------------------------------
        */

        $leadIds =
            \App\Models\Lead::query()
                ->where(
                    'import_batch_id',
                    $batch->id
                )
                ->pluck('id');


        /*
        |--------------------------------------------------------------------------
        | SAFETY CHECK
        |--------------------------------------------------------------------------
        |
        | Imported leads par actual CRM activity already ho chuki ho to
        | complete batch delete nahi karenge.
        |
        */

        if ($leadIds->isNotEmpty()) {

            /*
            |--------------------------------------------------------------------------
            | QUOTATIONS
            |--------------------------------------------------------------------------
            */

            $hasQuotations =
                \App\Models\Quotation::query()
                    ->whereIn(
                        'lead_id',
                        $leadIds
                    )
                    ->exists();


            /*
            |--------------------------------------------------------------------------
            | PROFORMAS
            |--------------------------------------------------------------------------
            */

            $hasProformas =
                \App\Models\Proforma::query()
                    ->whereIn(
                        'lead_id',
                        $leadIds
                    )
                    ->exists();


            /*
            |--------------------------------------------------------------------------
            | LEAD ACTION / HISTORY
            |--------------------------------------------------------------------------
            */

            $hasLeadActions =
                \App\Models\LeadAction::query()
                    ->whereIn(
                        'lead_id',
                        $leadIds
                    )
                    ->exists();


            /*
            |--------------------------------------------------------------------------
            | DEALS
            |--------------------------------------------------------------------------
            |
            | Existing project uses deals.leads_id.
            |
            */

            $hasDeals =
                \App\Models\Deal::query()
                    ->whereIn(
                        'leads_id',
                        $leadIds
                    )
                    ->exists();


            /*
            |--------------------------------------------------------------------------
            | STOP DELETE IF CRM ACTIVITY EXISTS
            |--------------------------------------------------------------------------
            */

            if (
                $hasQuotations ||
                $hasProformas ||
                $hasLeadActions ||
                $hasDeals
            ) {

                $linkedItems = [];

                if ($hasQuotations) {
                    $linkedItems[] = 'Quotation';
                }

                if ($hasProformas) {
                    $linkedItems[] = 'Proforma';
                }

                if ($hasLeadActions) {
                    $linkedItems[] = 'Lead History';
                }

                if ($hasDeals) {
                    $linkedItems[] = 'Deal';
                }


                return redirect()
                    ->route(
                        'admin.leads.import.history'
                    )
                    ->with(
                        'error_message',
                        'This import cannot be deleted because some imported leads already have related CRM activity: '
                        . implode(', ', $linkedItems)
                        . '.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILE PATH
        |--------------------------------------------------------------------------
        */

        $filePath = null;

        if (!empty($batch->file_path)) {

            $fileRelativePath = ltrim(
                str_replace(
                    '\\',
                    '/',
                    $batch->file_path
                ),
                '/'
            );


            /*
            |--------------------------------------------------------------------------
            | ONLY ALLOW OUR IMPORT DIRECTORY
            |--------------------------------------------------------------------------
            */

            if (
                !str_contains(
                    $fileRelativePath,
                    '../'
                ) &&
                str_starts_with(
                    $fileRelativePath,
                    'lead-imports/'
                )
            ) {

                $filePath =
                    storage_path(
                        'app/' .
                        $fileRelativePath
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | REMEMBER DETAILS BEFORE DELETE
        |--------------------------------------------------------------------------
        */

        $batchId =
            $batch->id;

        $originalFileName =
            $batch->original_file_name
            ?? 'Import file';

        $leadCount =
            $leadIds->count();


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | DELETE ONLY LEADS BELONGING TO THIS IMPORT
            |--------------------------------------------------------------------------
            */

            \App\Models\Lead::query()
                ->where(
                    'import_batch_id',
                    $batch->id
                )
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | DELETE IMPORT HISTORY ROW
            |--------------------------------------------------------------------------
            */

            $batch->delete();


            /*
            |--------------------------------------------------------------------------
            | COMMIT DATABASE
            |--------------------------------------------------------------------------
            */

            \Illuminate\Support\Facades\DB::commit();

        } catch (\Throwable $e) {

            \Illuminate\Support\Facades\DB::rollBack();

            report($e);


            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'error_message',
                    'Unable to delete this import. No database records were removed.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE ORIGINAL FILE AFTER DB COMMIT
        |--------------------------------------------------------------------------
        |
        | Filesystem DB transaction ka part nahi hota.
        | Isliye database successful hone ke baad file remove kar rahe hain.
        |
        */

        $fileDeleted = true;

        if (
            $filePath &&
            file_exists($filePath)
        ) {

            $fileDeleted =
                @unlink(
                    $filePath
                );
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        if (!$fileDeleted) {

            return redirect()
                ->route(
                    'admin.leads.import.history'
                )
                ->with(
                    'success_message',
                    "Import #{$batchId} deleted successfully. "
                    . "{$leadCount} imported leads were removed. "
                    . "The original file could not be physically removed from storage."
                );
        }


        return redirect()
            ->route(
                'admin.leads.import.history'
            )
            ->with(
                'success_message',
                "Import #{$batchId} ({$originalFileName}) deleted successfully. "
                . "{$leadCount} imported leads and the original uploaded file were removed."
            );
    }



}
