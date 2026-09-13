<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Candidate, Stage, User, Recruitment};
use App\Mail\CustomCandidateMail;
use Mail;
use Hash;
use Carbon\Carbon;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:candidate-list|candidate-create|candidate-update|candidate-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:candidate-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:candidate-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:candidate-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $candidates = Candidate::latest()->get();

        } elseif ($user->is_manager == 1) {
            $candidates = Candidate::whereHas('recruitment', function ($query) use ($user) {
                $query->where('manager_id', $user->id);
            })->latest()->get();

        } else {
            $candidates = Candidate::whereHas('recruitment', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })->latest()->get();
        }
        return view('admin.candidate.index', compact('candidates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'source' => 'required',
            'country' => 'required',
            'state' => 'required',
            'resume' => 'required|mimes:pdf',
            'dob' => 'required',
            'recruitment_id' => 'required',
            'stage_id' => 'required',
            'document' => 'nullable',
            'branch_id' => 'required'
        ]);

        // Get recruitment name
        $recruitment = Recruitment::find($data['recruitment_id']);
        $recruitmentName = $recruitment ? $recruitment->title : 'Unknown Recruitment';

        $data['job_name'] = $recruitmentName;

        // Upload resume
        if ($request->hasFile('resume')) {
            $filename = uniqid() . '.' . $request->resume->getClientOriginalExtension();
            $request->resume->move(public_path('uploads/resume/'), $filename);
            $data['resume'] = $filename;
        }

        // Create candidate
        $response = Candidate::create($data);

        if ($response) {
            return redirect()->back()->with([
                'success_message' => 'Candidate created successfully for ' . $recruitmentName
            ]);
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        $candi = Candidate::where('id', $id)->firstOrFail();

        $res = $candi->delete();

        if ($res) {
            return back()->with('success_message', 'Candidate Deleted successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $candidate = Candidate::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'source' => 'required',
            'country' => 'required',
            'state' => 'required',
            'resume' => 'nullable',
            'dob' => 'required',
            'recruitment_id' => 'required',
            'document' => 'nullable',
            'branch_id' => 'nullable'
        ]);

        // Fetch recruitment name
        $recruitment = Recruitment::find($data['recruitment_id']);
        $recruitmentName = $recruitment ? $recruitment->title : 'Unknown Recruitment';

        $data['job_name'] = $recruitmentName;

        // Upload Resume
        if ($request->hasFile('resume')) {
            $filename = uniqid() . '.' . $request->resume->getClientOriginalExtension();
            $request->resume->move(public_path('uploads/resume/'), $filename);
            $data['resume'] = $filename;
        }

        // Upload Document
        if ($request->hasFile('document')) {
            $filename = uniqid() . '.' . $request->document->getClientOriginalExtension();
            $request->document->move(public_path('uploads/document/'), $filename);
            $data['document'] = $filename;
        }

        // Update Candidate
        $response = $candidate->update($data);

        if ($response) {
            return redirect()->back()->with('success_message', 'Candidate updated successfully for ' . $recruitmentName);
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }


    public function updateStage(Request $request, $candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);
        $stageId = $request->input('stage_id');

        $stage = Stage::findOrFail($stageId);

        // Validate stage belongs to candidate's recruitment
        if ($stage->recruitment_id != $candidate->recruitment_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Selected stage does not belong to this candidate\'s recruitment.'
            ], 400);
        }

        $candidate->stage_id = $stageId;
        $candidate->save();




        // Identify final stage for this recruitment
        // $finalStage = Stage::where('recruitment_id', $candidate->recruitment_id)
        //                    ->orderBy('id', 'desc') // or use a "is_final" flag column
        //                    ->first();

        // if ($stageId == $finalStage->id) {
        //     $existingUser = User::where('email', $candidate->email)->first();
        //     if (!$existingUser) {
        //         User::create([
        //             'name' => $candidate->name,
        //             'email' => $candidate->email,
        //             'designation' => $candidate->recruitment->title,
        //             'password' => Hash::make('defaultPassword123'),
        //             'branch_id' => $candidate->branch_id ?? null,
        //             'role' => 'staff',
        //         ]);
        //     }
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'Candidate stage updated successfully.'
        ]);
    }



    // public function updateIsFinal(Request $request)
    // {
    //     $request->validate([
    //         'candidate_id' => 'required|exists:candidates,id',
    //         'is_final' => 'required|in:yes,no'
    //     ]);

    //     $candidate = Candidate::findOrFail($request->candidate_id);
    //     $candidate->is_final = $request->is_final;
    //     $candidate->save();

    //     // If candidate is marked final, create a user if not exists
    //     if ($request->is_final === 'yes') {
    //         $existingUser = User::where('email', $candidate->email)->first();
    //         if (!$existingUser) {
    //             User::create([
    //                 'name' => $candidate->name,
    //                 'email' => $candidate->email,
    //                 'designation' => $candidate->recruitment->title,
    //                 'password' => Hash::make('defaultPassword123'), // or generate dynamically
    //                 'branch_id' => $candidate->branch_id ?? null,
    //                 'role' => 'staff',
    //                 'document' => $candidate->document,
    //                 'status' => 'active'
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Candidate final stage updated successfully.'
    //     ]);
    // }

    public function updateIsFinal(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'is_final' => 'required|in:yes,no'
        ]);

        $candidate = Candidate::findOrFail($request->candidate_id);
        $candidate->is_final = $request->is_final;
        $res = $candidate->save();

        if ($res) {
            return back()->with('success_message', 'Shortlist status updated successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something want wrong');
        }
    }


    public function sendMail(Request $request)
    {
        $request->validate([
            'candidate_ids' => 'required|array',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $candidateIds = $request->candidate_ids;
        $subject = $request->subject;
        $messageTemplate = $request->message;

        $candidates = Candidate::whereIn('id', $candidateIds)->get();

        foreach ($candidates as $candidate) {
            $messageBody = str_replace('{{candidate_name}}', $candidate->name, $messageTemplate);

            Mail::to($candidate->email)->send(new CustomCandidateMail($subject, $messageBody, $candidate->name));
        }

        return response()->json(['message' => 'Mails sent successfully!']);
    }


    public function candiemp(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $emp = $request->is_emp;

        // dd($type);

        // Update candidate type
        $candidate->is_emp = $emp;
        // dd($candidate);
        $candidate->save();

        // If candidate is not selected → just reload
        // if ($emp !== 'selected') {
        //     return redirect()->back()->with('success', 'Candidate type updated successfully');
        // }

        // -------- Create Employee From Candidate --------
        $emp = new User();
        $emp->name = $candidate->name;
        $emp->email = $candidate->email;
        $emp->phone = $candidate->phone;
        $emp->present_address = $candidate->address;
        $emp->password = Hash::make('defaultPassword123');
        $emp->save();

        // Redirect to employee profile page
        return redirect()->route('admin.staff.profile', [
            'tab' => 'info',
            'user_id' => $emp->id
        ])->with('success', 'Candidate converted to Employee successfully');
    }

    public function updateTypeAndRedirect(Request $request, $candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);

        $type = $request->cand_type;

        // dd($type);

        // Update candidate type
        $candidate->cand_type = $type;
        // dd($candidate);
        $res =  $candidate->save();

        if ($res) {
            return back()->with('success_message', 'Candidate selected');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function show($id)
    {

        $candidate = Candidate::with('stage', 'recruitment', 'onboarding')->findOrFail($id);

        return view('admin.candidate.show', compact('candidate'));
    }


    public function exportCandidates()
    {
        $candidates = \App\Models\Candidate::with(['recruitment', 'stage'])->get();

        $filename = 'candidates_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($candidates) {

            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'name',
                'email',
                'phone',
                'address',
                'source',
                'country',
                'state',
                'dob',
                'resume',
                'recruitment',
                'stage',
                'job_name',
                'is_emp',
                'onboarding'
            ]);

            foreach ($candidates as $c) {
                fputcsv($file, [
                    $c->name,
                    $c->email,
                    $c->phone,
                    $c->address,
                    $c->source,
                    $c->country,
                    $c->state,
                    $c->dob,
                    $c->resume,
                    $c->recruitment->title ?? '',
                    $c->stage->title ?? '',
                    $c->job_name,
                    $c->is_emp,
                    $c->onboarding,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    public function importCandidates(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        if (($handle = fopen($file->getRealPath(), 'r')) === false) {
            return back()->with('error_message', 'File not readable');
        }

        $header = fgetcsv($handle);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle, 10000, ',')) !== false) {

            if (count($row) < 14) {
                $skipped++;
                continue;
            }

            try {
                $dob = !empty($row[7])
                    ? Carbon::parse($row[7])->format('Y-m-d')
                    : null;
            } catch (\Exception $e) {
                $dob = null;
            }

            // Relations
            $recruitment = \App\Models\Recruitment::where('title', $row[9])->first();
            $stage       = \App\Models\Stage::where('title', $row[10])->first();

            \App\Models\Candidate::create([
                'name'           => $row[0],
                'email'          => $row[1],
                'phone'          => $row[2],
                'address'        => $row[3],
                'source'         => $row[4],
                'country'        => $row[5],
                'state'          => $row[6],
                'dob'            => $dob,
                'resume'         => $row[8] ?? null, // optional
                'recruitment_id' => $recruitment->id ?? null,
                'stage_id'       => $stage->id ?? null,
                'job_name'       => $row[11] ?? null,
                'is_emp'         => $row[12] ?? 0,
                'onboarding'     => $row[13] ?? 0,
            ]);

            $imported++;
        }

        fclose($handle);

        return back()->with('success_message', "Imported: $imported, Skipped: $skipped");
    }

    public function downloadSampleCsv()
    {
        $filename = 'candidate_sample.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'name',
                'email',
                'phone',
                'address',
                'source',
                'country',
                'state',
                'dob',
                'resume',
                'recruitment',
                'stage',
                'job_name',
                'is_emp',
                'onboarding'
            ]);

            fputcsv($file, [
                'John Doe',
                'john@example.com',
                '9876543210',
                'Delhi',
                'LinkedIn',
                'India',
                'Delhi',
                '1995-05-10',
                'john_resume.pdf',
                'PHP Developer',
                'Screening',
                'Backend Developer',
                '0',
                '0'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportStageCandidates($stageId)
    {
        $stage = \App\Models\Stage::with([
            'candi.recruitment',
            'candi.stage'
        ])->findOrFail($stageId);

        $filename = 'stage_candidates_' . $stage->title . '_' . date('Ymd_His') . '.csv';
        $filename = str_replace([' ', '/', '\\'], '_', $filename);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($stage) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Name',
                'Email',
                'Phone',
                'Address',
                'Source',
                'Country',
                'State',
                'DOB',
                'Resume',
                'Recruitment',
                'Short List',
                'Stage',
            ]);

            foreach ($stage->candi as $key => $candi) {
                fputcsv($file, [
                    $key + 1,
                    $candi->name ?? '',
                    $candi->email ?? '',
                    $candi->phone ?? '',
                    $candi->address ?? '',
                    $candi->source ?? '',
                    $candi->country ?? '',
                    $candi->state ?? '',
                    $candi->dob ?? '',
                    $candi->resume ?? '',
                    $candi->recruitment->title ?? '',
                    $candi->is_final ?? '',
                    $candi->stage->title ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportShortlists()
    {
        $shortlists = \App\Models\Candidate::with('recruitment')
            ->where('is_final', 'yes')
            ->get();

        $filename = 'shortlisted_candidates_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($shortlists) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Name',
                'Email',
                'Phone',
                'Address',
                'Source',
                'Country',
                'State',
                'DOB',
                'Resume',
                'Recruitment',
            ]);

            foreach ($shortlists as $key => $candi) {
                fputcsv($file, [
                    $key + 1,
                    $candi->name ?? '',
                    $candi->email ?? '',
                    $candi->phone ?? '',
                    $candi->address ?? '',
                    $candi->source ?? '',
                    $candi->country ?? '',
                    $candi->state ?? '',
                    $candi->dob ?? '',
                    $candi->resume ?? '',
                    $candi->recruitment->title ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    public function exportOnboardingStageCandidates($stageId)
    {
        $stage = \App\Models\OnBoarding::with([
            'candidates.recruitment'
        ])->findOrFail($stageId);

        $stageName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $stage->title);
        $filename = 'onboarding_stage_' . $stageName . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($stage) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Name',
                'Email',
                'Phone',
                'Address',
                'Source',
                'Country',
                'State',
                'DOB',
                'Resume',
                'Recruitment',
                'Short List',
                'Stage',
                'Candi Type',
            ]);

            foreach ($stage->candidates as $key => $candi) {
                fputcsv($file, [
                    $key + 1,
                    $candi->name ?? '',
                    $candi->email ?? '',
                    $candi->phone ?? '',
                    $candi->address ?? '',
                    $candi->source ?? '',
                    $candi->country ?? '',
                    $candi->state ?? '',
                    $candi->dob ?? '',
                    $candi->resume ?? '',
                    $candi->recruitment->title ?? '',
                    $candi->is_final ?? '',
                    $stage->title ?? '',
                    $candi->cand_type ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function exportEmployeeCandidates()
    {
        $candidates = \App\Models\Candidate::with('recruitment')->get();

        $filename = 'candidate_employee_status_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($candidates) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Name',
                'Email',
                'Phone',
                'Address',
                'Source',
                'Country',
                'State',
                'DOB',
                'Resume',
                'Recruitment',
                'Is Emp',
            ]);

            foreach ($candidates as $key => $candi) {
                fputcsv($file, [
                    $key + 1,
                    $candi->name ?? '',
                    $candi->email ?? '',
                    $candi->phone ?? '',
                    $candi->address ?? '',
                    $candi->source ?? '',
                    $candi->country ?? '',
                    $candi->state ?? '',
                    $candi->dob ?? '',
                    $candi->resume ?? '',
                    $candi->recruitment->title ?? '',
                    $candi->is_emp ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
