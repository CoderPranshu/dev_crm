<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Department, Designation, Document};
use Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use DB;

class StaffController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $activeQuery = User::where('status', 'active')
            ->where('role', '!=', 'Admin');

        $inactiveQuery = User::where('status', 'inactive')
            ->where('role', '!=', 'Admin');

        if (!$user->hasRole('Admin')) {
            $activeQuery->where('branch_id', $user->branch_id);
            $inactiveQuery->where('branch_id', $user->branch_id);
        }

        $active_staffs = $activeQuery->orderBy('sort')->get();
        $inactive_staffs = $inactiveQuery->orderBy('sort')->get();

        // ✅ GROUP BY DEPARTMENT
        $active_departments = $active_staffs->groupBy('department');
        $inactive_departments = $inactive_staffs->groupBy('department');

        return view('admin.staff.index', compact(
            'active_departments',
            'inactive_departments'
        ));
    }

    function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'branch_id' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'roles' => 'required',
            'designation' => 'nullable|string',
            'department' => 'nullable|string',
            'paycode' => 'nullable|string',
            'is_manager' => 'nullable|string'
        ]);

        $data['name'] = $request->name;
        $data['branch_id'] = $request->branch_id;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->roles;
        $data['status'] = 'active';
        $data['designation_id'] = $request->designation;
        $data['department'] = $request->department;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['paycode'] = $request->paycode;
        $data['is_manager'] = $request->is_manager;

        if ($request->photo) {
            $data['photo'] = random(20) . '.' . $request->photo->extension();
            //Image optimization
            Image::make($request->photo->path())->orientate()->resize(200, null, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save(public_path() . '/uploads/user-image/' . $data['photo']);
        }

        $response = User::create($data);

        $response->assignRole($request->input('roles'));

        if ($response) {
            return redirect()->route('admin.staff.profile', ['info', $response->id])->with('success_message', __('New staff added successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    public function docupdate(Request $request, $user_id)
    {
        $staff = User::findOrFail($user_id);

        $request->validate([
            'document.*' => 'nullable|file',
            'pan_image' => 'nullable|file',
            'aadhar_image' => 'nullable|file',
            'bank_acc_image' => 'nullable|file'
        ]);

        if ($request->hasFile('pan_image')) {
            $filename = uniqid() . '.' . $request->pan_image->getClientOriginalExtension();
            $request->pan_image->move(public_path('uploads/document/'), $filename);
            $request->pan_image = $filename;
        }

        if ($request->hasFile('aadhar_image')) {
            $filenameaadhar = uniqid() . '.' . $request->aadhar_image->getClientOriginalExtension();
            $request->aadhar_image->move(public_path('uploads/document/'), $filenameaadhar);
            $request->aadhar_image = $filenameaadhar;
        }

        if ($request->hasFile('bank_acc_image')) {
            $filanamebank = uniqid() . '.' . $request->bank_acc_image->getClientOriginalExtension();
            $request->bank_acc_image->move(public_path('uploads/document/'), $filanamebank);
            $request->bank_acc_image = $filanamebank;
        }


        $staff->update([
            'pan_image' => $request->pan_image,
            'aadhar_image' => $request->aadhar_image,
            'bank_acc_image' => $request->bank_acc_image,
        ]);

        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $file) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/document/'), $filename);

                Document::create([
                    'user_id' => $user_id,
                    'document' => $filename,
                ]);
            }
        }

        return redirect()->back()->with('success_message', 'Documents uploaded successfully');
    }


    public function deleteDocument($id)
    {
        $document = Document::findOrFail($id);

        $document->delete();

        return redirect()->back()->with('success_message', 'Document deleted successfully');
    }



    function update($user_id = "", Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'branch_id' => 'required|max:255',
            'email' => "required|email|unique:users,email,$user_id",
            'roles' => 'required',
            'paycode' => 'required',
        ]);

        $user = User::findOrFail($user_id);

        $data = [
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'email' => $request->email,

            // ✅ FIXED HERE
            'designation_id' => $request->designation_id,
            'department_id' => $request->department_id,

            'updated_at' => now(),
            'role' => $request->roles,
            'paycode' => $request->paycode
        ];

        // ✅ Remove photo
        if ($request->remove_photo == 1 && $user->photo) {
            remove_file('uploads/user-image/' . $user->photo);
            $data['photo'] = null;
        }

        // ✅ Upload new photo
        if ($request->hasFile('photo')) {
            remove_file('uploads/user-image/' . $user->photo);

            $data['photo'] = random(20) . '.' . $request->photo->extension();

            Image::make($request->photo->path())
                ->orientate()
                ->resize(200, null, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })
                ->save(public_path('/uploads/user-image/' . $data['photo']));
        }

        $user->update($data);

        // ✅ Role sync (Spatie)
        $user->syncRoles([$request->roles]);

        return redirect()->back()->with('success_message', 'User updated successfully');
    }


    function delete($user_id = "")
    {
        remove_file('uploads/user-image/' . User::where('id', $user_id)->value('photo'));
        User::where('id', $user_id)->delete();
        return redirect()->back()->with('success_message', __('Staff deleted successfully'));
    }

    function staff_status($status = "", $user_id = "")
    {
        User::where('id', $user_id)->update(['status' => $status]);
        return redirect()->back()->with('success_message', __('Status changed successfully'));
    }

    function staff_sort(Request $request)
    {

        if (is_array($request->active_user_ids)) {
            foreach ($request->active_user_ids as $key => $active_user_id) {
                ++$key;
                User::where('id', $active_user_id)->update(['sort' => $key]);
            }
        }

        if (is_array($request->inactive_user_ids)) {
            foreach ($request->inactive_user_ids as $key => $inactive_user_id) {
                ++$key;
                User::where('id', $inactive_user_id)->update(['sort' => $key]);
            }
        }

        return redirect()->back()->with('success_message', __('User sorted successfully'));
    }

    function profile($tab = "", $user_id = "", Request $request)
    {
        $page_data['user'] = User::where('id', $user_id)->first();
        $page_data['tab'] = $tab;
        return view('admin.staff.profile', $page_data);
    }

    public function profile_update($user_id = "", Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => "required|email|unique:users,email,$user_id",
        ]);

        $data = [
            'name'                  => $request->name,
            'branch_id'             => $request->branch_id,
            'email'                 => $request->email,
            'department'            => $request->department_id,
            'designation_id'           => $request->designation_id,
            'phone'                 => $request->phone,
            'alternative_phone'     => $request->alternative_phone,
            'rel_of_alternative_phone' => $request->rel_of_alternative_phone,
            'blood_group'           => $request->blood_group,
            'gender'                => $request->gender,
            'birthday'              => $request->birthday ? date('Y-m-d H:i:s', strtotime($request->birthday)) : null,
            'present_address'       => $request->present_address,
            'permanent_address'     => $request->permanent_address,
            'bio'                   => $request->bio,
            'role'                  => $request->role,
            'employ_type'           => $request->employ_type,
            'shift'                 => $request->shift,
            'status'                => $request->status,
            'salary'                => $request->salary,
            'pan_no'            => $request->pan_number,
            'aadhar'                => $request->aadhar,
            'bank_account_no'       => $request->bank_account_n,
            'ifsc_code'             => $request->ifsc_code,
            'emg_contact_name'      => $request->emg_contact_name,
            'emg_contact_number'    => $request->emg_contact_number,
            'manager'               => $request->manager,
            'join_date'             => $request->join_date ? date('Y-m-d H:i:s', strtotime($request->join_date)) : null,
            'updated_at'            => now(),
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $oldPhoto = User::where('id', $user_id)->value('photo');
            if ($oldPhoto && file_exists(public_path('uploads/user-image/' . $oldPhoto))) {
                @unlink(public_path('uploads/user-image/' . $oldPhoto));
            }

            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // Optimize and save
            \Image::make($file->path())
                ->orientate()
                ->resize(200, null, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user-image/' . $filename));

            $data['photo'] = $filename;
        }

        // Update user
        $response = User::where('id', $user_id)->update($data);

        if ($response) {
            return redirect()->back()->with('success_message', __('User data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something went wrong!'));
        }
    }

    public function getDepartmentsByBranch(Request $request)
    {
        $departments = Department::where('branch', $request->branch_id)->get(['id', 'title']);
        return response()->json($departments);
    }

    public function getDesignationsByDepartment(Request $request)
    {
        $designations = Designation::where('department_id', $request->department_id)->get(['id', 'title']);
        return response()->json($designations);
    }



    public function createFromCandidate($id)
    {
        $candi = Candidate::findOrFail($id);

        // Create new Employee record
        $emp = Employee::create([
            'name'      => $candi->name,
            'email'     => $candi->email,
            'phone'     => $candi->phone,
            'address'   => $candi->address,
            'country'   => $candi->country,
            'state'     => $candi->state,
            'dob'       => $candi->dob,
            'resume'    => $candi->resume,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Employee created successfully',
            'emp_id' => $emp->id
        ]);
    }


    public function exportDepartment($departmentId, Request $request)
    {
        $type = $request->type; // active / inactive

        $user = auth()->user();

        $query = User::with(['designation', 'roles'])
            ->where('department', $departmentId)
            ->where('role', '!=', 'Admin');

        if (!$user->hasRole('Admin')) {
            $query->where('branch_id', $user->branch_id);
        }

        // ✅ FILTER BY STATUS
        if ($type == 'active') {
            $query->where('status', 'active');
        } elseif ($type == 'inactive') {
            $query->where('status', 'inactive');
        }

        $staffs = $query->get();

        $filename = "department_{$departmentId}_{$type}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($staffs) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Name', 'Email', 'Role', 'Branch', 'Designation', 'Status']);

            foreach ($staffs as $staff) {

                $roles = $staff->getRoleNames()->implode(', ');
                $branch = \DB::table('branches')->where('id', $staff->branch_id)->value('title');

                fputcsv($file, [
                    $staff->name,
                    $staff->email,
                    $roles ?: 'No Role',
                    $branch ?? 'N/A',
                    $staff->designation->title ?? 'N/A',
                    $staff->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportKpi(Request $request)
    {
        $userId = $request->user_id;
        $month  = $request->month;
        $year   = $request->year;

        $user = \App\Models\User::findOrFail($userId);

        $kpis = \App\Models\Kpi::where('department_id', $user->department)->get();

        $points = \DB::table('kpi_user')
            ->where('user_id', $userId)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->pluck('points', 'kpi_id');

        $filename = "kpi_{$user->name}_{$month}_{$year}.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($kpis, $points, $user, $month, $year) {

            $file = fopen('php://output', 'w');

            // HEADER INFO
            fputcsv($file, ['Employee', $user->name]);
            fputcsv($file, ['Month', date('F', mktime(0, 0, 0, $month, 1))]);
            fputcsv($file, ['Year', $year]);
            fputcsv($file, []); // empty row

            // TABLE HEADER
            fputcsv($file, ['#', 'KPI', 'Points']);

            foreach ($kpis as $index => $kpi) {

                $value = $points[$kpi->id] ?? '';

                fputcsv($file, [
                    $index + 1,
                    $kpi->title,
                    $value
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
