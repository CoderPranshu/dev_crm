<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BacklinkCategory;
use App\Models\BacklinkUpload;
use App\Services\BacklinkFileReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BacklinkUploadController extends Controller
{
    /**
     * Show the CSV / Excel upload form.
     */
    public function create(Request $request)
    {
        $categories = BacklinkCategory::where('status', 1)
            ->orderBy('name')
            ->get();

        $selectedCategoryId = old(
            'backlink_category_id',
            $request->query('backlink_category_id', $request->query('category_id'))
        );

        return view(
            'admin.backlinks.upload',
            compact('categories', 'selectedCategoryId')
        );
    }

    /**
     * Store the original file and its metadata directly.
     *
     * No column mapping is performed and no rows are inserted into
     * the backlinks table. Only backlink_uploads receives a record.
     */
    public function prepare(Request $request, BacklinkFileReader $reader)
    {
        $validated = $request->validate([
            'backlink_category_id' => [
                'required',
                'integer',
                Rule::exists((new BacklinkCategory())->getTable(), 'id')
                    ->where(fn ($query) => $query->where('status', 1)),
            ],
            'csv' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:51200'],
        ]);

        $file = $request->file('csv');
        $extension = strtolower($file->getClientOriginalExtension());

        if (! in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
            throw ValidationException::withMessages([
                'csv' => 'Only CSV, XLSX and XLS files are allowed.',
            ]);
        }

        $path = $file->store('files', 'backlink_files');

        if (! $path) {
            return back()
                ->withInput()
                ->with('error', 'The uploaded file could not be saved. Please try again.');
        }

        try {
            // Validate that the stored file is readable and collect its headers
            // for the Open/Preview screen.
            $data = $reader->inspect(
                Storage::disk('backlink_files')->path($path),
                $extension
            );

            BacklinkUpload::create([
                'backlink_category_id' => (int) $validated['backlink_category_id'],
                'created_by' => auth()->id(),
                'original_name' => mb_substr(
                    basename(str_replace('\\', '/', $file->getClientOriginalName())),
                    0,
                    240
                ),
                'path' => $path,
                'extension' => $extension,
                'size' => $file->getSize(),
                'headers' => $data['headers'],
                'status' => 'completed',
            ]);
        } catch (\Throwable $e) {
            Storage::disk('backlink_files')->delete($path);
            report($e);

            if ($e instanceof ValidationException) {
                throw $e;
            }

            return back()
                ->withInput()
                ->with('error', 'File could not be read. Check the file format and try again.');
        }

        return redirect()
            ->route('admin.backlinks.index')
            ->with('success', 'CSV / Excel file uploaded successfully.');
    }

    /**
     * Preview the first 100 data rows of the uploaded file.
     */
    public function open(BacklinkUpload $upload, BacklinkFileReader $reader)
    {
        $this->authorizeUpload($upload);

        $rows = [];

        foreach ($reader->rows(
            $this->filePath($upload),
            $upload->extension
        ) as $number => $row) {
            if ($number === 1) {
                continue;
            }

            $rows[] = $row;

            if (count($rows) >= 100) {
                break;
            }
        }

        return view('admin.backlinks.file-preview', compact('upload', 'rows'));
    }

    /**
     * Download the original privately stored file.
     */
    public function download(BacklinkUpload $upload)
    {
        $this->authorizeUpload($upload);
        $this->filePath($upload);

        return Storage::disk('backlink_files')->download(
            $upload->path,
            $upload->original_name,
            ['X-Content-Type-Options' => 'nosniff']
        );
    }

    /**
     * Delete the upload record and its original private file.
     */
    public function destroy(BacklinkUpload $upload)
    {
        $this->authorizeUpload($upload);

        $path = $upload->path;

        try {
            DB::transaction(function () use ($upload) {
                $upload->delete();
            });

            if ($path && Storage::disk('backlink_files')->exists($path)) {
                Storage::disk('backlink_files')->delete($path);
            }

            return redirect()
                ->route('admin.backlinks.index')
                ->with('success', 'Uploaded file deleted successfully.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Uploaded file could not be deleted.');
        }
    }

    /**
     * Only the user who uploaded the file can open or download it.
     */
    private function authorizeUpload(BacklinkUpload $upload): void
    {
        abort_unless(
            (int) $upload->created_by === (int) auth()->id(),
            403
        );
    }

    /**
     * Return the absolute path of an existing private upload.
     */
    private function filePath(BacklinkUpload $upload): string
    {
        abort_unless(
            Storage::disk('backlink_files')->exists($upload->path),
            404,
            'Uploaded file is missing.'
        );

        return Storage::disk('backlink_files')->path($upload->path);
    }
}

