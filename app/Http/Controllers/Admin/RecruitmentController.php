<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Recruitment, Stage, Department, Branch, User, Designation};
use Carbon\Carbon;
use DB;

class RecruitmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:recuritment-list|recuritment-create|recuritment-update|recuritment-delete|recuritment-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:recuritment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:recuritment-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:recuritment-delete', ['only' => ['destroy']]);
        $this->middleware('permission:recuritment-show', ['only' => ['show']]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $recruitment = Recruitment::orderBy('created_at', 'asc')->get();

        } elseif ($user->is_manager == 1) {
            $recruitment = Recruitment::where('manager_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        } else {
            $recruitment = Recruitment::where('branch_id', $user->branch_id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.recruitment.index', compact('recruitment'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'manager_id' => 'nullable',
            'department_id' => 'nullable',
            'branch_id' => 'nullable',
            'position' => 'nullable',
        ]);

        $data['slug'] = str()->slug($data['title']);

        $response = Recruitment::create($data);

        Stage::create([
            'title' => 'Initial',
            'slug' => 'initial-' . $response->id,
            'recruitment_id' => $response->id
        ]);

        if ($response) {
            return redirect()->back()->with('success_message', __('New Recruitment added successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    public function update(Request $request, $id)
    {
        $recruitment = Recruitment::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'title' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'manager_id' => 'nullable',
            'department_id' => 'nullable',
            'branch_id' => 'nullable',
            'position' => 'nullable',
        ]);

        $data['slug'] = str()->slug($data['title']);

        $response = $recruitment->update($data);

        if ($response) {
            return redirect()->back()->with('success_message', __('Recruitment updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong'));
        }
    }

    public function destroy(Request $request, $id)
    {
        $rec = Recruitment::where('id', $id)->firstOrFail();
        $response = $rec->delete();

        if ($rec) {
            return redirect()->back()->with('success_manager', __('Recruitment deleted successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong'));
        }
    }


    public function getStages($id)
    {
        $recruitment = Recruitment::with('stages')->find($id);

        if (!$recruitment) {
            return response()->json(['stages' => []]);
        }

        return response()->json([
            'stages' => $recruitment->stages
        ]);
    }

    public function show($id)
    {
        $rec = Recruitment::with('stages', 'department', 'designation', 'branch', 'manager')->findOrFail($id);
        return view('admin.recruitment.show', compact('rec'));
    }




    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        if (($handle = fopen($file->getRealPath(), 'r')) === false) {
            return redirect()->back()->with('error_message', 'Unable to open file.');
        }

        $header = fgetcsv($handle);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle, 10000, ',')) !== false) {
            if (count($row) < 8) {
                $skipped++;
                continue;
            }

            $title         = trim($row[0] ?? '');
            $description   = trim($row[1] ?? '');
            $department    = trim($row[2] ?? '');
            $branch        = trim($row[3] ?? '');
            $position      = trim($row[4] ?? '');
            $start_date    = trim($row[5] ?? '');
            $end_date      = trim($row[6] ?? '');
            $manager_email = trim($row[7] ?? '');

            if (empty($title)) {
                $skipped++;
                continue;
            }

            $departmentModel  = \App\Models\Department::where('title', $department)->first();
            $branchModel      = \App\Models\Branch::where('title', $branch)->first();
            $designationModel = \App\Models\Designation::where('title', $position)->first();
            $managerModel     = \App\Models\User::where('email', $manager_email)->first();

            try {
                $start_date = !empty($start_date)
                    ? Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d')
                    : null;

                $end_date = !empty($end_date)
                    ? Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d')
                    : null;
            } catch (\Exception $e) {
                $skipped++;
                continue;
            }

            \App\Models\Recruitment::create([
                'title'          => $title,
                'description'    => $description,
                'department_id'  => $departmentModel->id ?? null,
                'branch_id'      => $branchModel->id ?? null,
                'designation_id' => $designationModel->id ?? null,
                'start_date'     => $start_date,
                'end_date'       => $end_date,
                'manager_id'     => $managerModel->id ?? null,
            ]);

            $imported++;
        }

        fclose($handle);

        return redirect()->back()->with(
            'success_message',
            "Recruitment imported successfully. Imported: {$imported}, Skipped: {$skipped}"
        );
    }

    public function export()
    {
        $recruitment = \App\Models\Recruitment::with(['department', 'branch', 'designation', 'manager'])->get();

        $filename = 'recruitment_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($recruitment) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Title',
                'Description',
                'Department',
                'Branch',
                'Position',
                'Start Date',
                'End Date',
                'Manager',
            ]);

            foreach ($recruitment as $key => $rec) {
                fputcsv($file, [
                    $key + 1,
                    $rec->title ?? '',
                    $rec->description ?? '',
                    $rec->department->title ?? '',
                    $rec->branch->title ?? '',
                    $rec->designation->title ?? '',
                    $rec->start_date ?? '',
                    $rec->end_date ?? '',
                    $rec->manager->name ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadSampleCsv()
    {
        $filename = 'recruitment_sample.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            // Header row (VERY IMPORTANT)
            fputcsv($file, [
                'title',
                'description',
                'department',
                'branch',
                'position',
                'start_date',
                'end_date',
                'manager_email',
            ]);

            // Sample row 1
            fputcsv($file, [
                'PHP Developer',
                'Backend hiring for ERP system',
                'IT',
                'Head Office',
                'Developer',
                '2026-03-01',
                '2026-03-31',
                'manager@example.com',
            ]);

            // Sample row 2
            fputcsv($file, [
                'HR Executive',
                'Interview coordination',
                'HR',
                'Delhi Branch',
                'Executive',
                '2026-03-10',
                '2026-04-10',
                'hr@example.com',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function getManagers($branch_id)
    {
        $managers = DB::table('users')
            ->where('branch_id', $branch_id)
            ->where('is_manager', 1)
            ->get();

        return response()->json($managers);
    }
}
