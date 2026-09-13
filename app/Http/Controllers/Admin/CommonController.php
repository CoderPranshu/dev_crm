<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Http;
use Carbon\Carbon;
use App\Models\{Branch, Company, WarrantyClaim};
use DB;
use Maatwebsite\Excel\Facades\Excel;

class CommonController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:organization-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:organization-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:attendence', ['only' => ['atten']]);
    }


    public function atten(Request $request)
    {
        $fromDate = $request->from_date ?? Carbon::now()->subDays(7)->format('Y/m/d');
        $toDate   = $request->to_date ?? Carbon::now()->format('Y/m/d');

        $branchId = $request->branch_id;

        $branches = Branch::select('id', 'title', 'machine_serial_no')->get();

        $selectedBranches = $branchId
            ? $branches->where('id', $branchId)
            : $branches;

        $rows = [];

        foreach ($selectedBranches as $branch) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('http://ta.biumetrics.com/api/transaction/GetRowData', [
                'TXN_NAME' => 'GetRowData',
                'DATA' => json_encode([
                    'Company_Code' => '17',
                    'ReportDate_From' => $fromDate,
                    'ReportDate_To' => $toDate,
                    'MachineSerialNo' => $branch->machine_serial_no
                ])
            ]);

            $data = $response->json()['data'] ?? [];

            foreach ($data as $row) {
                $row['BRANCH_NAME'] = $branch->title;
                $rows[] = $row;
            }
        }

        $processedRows = [];

        $grouped = collect($rows)->groupBy(function ($row) {
            $punchDate = substr($row['OFFICEPUNCH'], 0, 10);
            return $row['PAYCODE'] . '_' . $punchDate;
        });

        foreach ($grouped as $items) {
            $items = collect($items)->sortBy('OFFICEPUNCH')->values();

            $first = $items->first();
            $second = $items->count() > 1 ? $items->get(1) : null;

            $processedRows[] = [
                'BRANCH_NAME' => $first['BRANCH_NAME'],
                'PAYCODE'     => $first['PAYCODE'],
                'CARDNO'      => $first['CARDNO'] ?? '',
                'DATE'        => substr($first['OFFICEPUNCH'], 0, 10),

                'PUNCH_IN'    => $first['OFFICEPUNCH'] ?? '-',
                'PUNCH_OUT'   => $second['OFFICEPUNCH'] ?? '-',

                'SYSTEMIP'    => $first['SYSTEMIP'] ?? '-',
            ];
        }

        return view('admin.attendance.atten', compact('processedRows', 'branches', 'branchId', 'fromDate', 'toDate'));
    }

public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'points'  => 'required|array',
    ]);

    $employeeId = $request->user_id;
    $month = $request->month;
    $year = $request->year;

    foreach ($request->points as $kpiId => $point) {

        if ($point === null || $point === '') {
            continue;
        }

        // Find existing record for same user + KPI + month + year
        $existing = DB::table('kpi_user')
            ->where('user_id', $employeeId)
            ->where('kpi_id', $kpiId)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();

        if ($existing) {

            // Update existing row
            DB::table('kpi_user')
                ->where('id', $existing->id)
                ->update([
                    'points' => $point,
                    'updated_at' => now(),
                ]);

        } else {

            // Insert new row
            DB::table('kpi_user')->insert([
                'user_id'    => $employeeId,
                'kpi_id'     => $kpiId,
                'points'     => $point,
                'created_at' => Carbon::create($year, $month, 1),
                'updated_at' => now(),
            ]);
        }
    }

    return back()->with('success_message', 'KPI points saved successfully.');
}

    public function exportAttendance(Request $request)
    {
        $fromDate = $request->from_date ?? Carbon::now()->subDays(7)->format('Y/m/d');
        $toDate   = $request->to_date ?? Carbon::now()->format('Y/m/d');

        $branchId = $request->branch_id;

        $branches = Branch::select('id', 'title', 'machine_serial_no')->get();

        $selectedBranches = $branchId
            ? $branches->where('id', $branchId)
            : $branches;

        $rows = [];

        foreach ($selectedBranches as $branch) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('http://ta.biumetrics.com/api/transaction/GetRowData', [
                'TXN_NAME' => 'GetRowData',
                'DATA' => json_encode([
                    'Company_Code' => '17',
                    'ReportDate_From' => $fromDate,
                    'ReportDate_To' => $toDate,
                    'MachineSerialNo' => $branch->machine_serial_no
                ])
            ]);

            $data = $response->json()['data'] ?? [];

            foreach ($data as $row) {
                $row['BRANCH_NAME'] = $branch->title;
                $rows[] = $row;
            }
        }

        $processedRows = [];

        $grouped = collect($rows)->groupBy(function ($row) {
            $punchDate = substr($row['OFFICEPUNCH'], 0, 10);
            return $row['PAYCODE'] . '_' . $punchDate;
        });

        foreach ($grouped as $items) {
            $items = collect($items)->sortBy('OFFICEPUNCH')->values();

            $first = $items->first();
            $second = $items->count() > 1 ? $items->get(1) : null;

            $processedRows[] = [
                'BRANCH_NAME' => $first['BRANCH_NAME'],
                'PAYCODE'     => $first['PAYCODE'],
                'CARDNO'      => $first['CARDNO'] ?? '',
                'DATE'        => substr($first['OFFICEPUNCH'], 0, 10),
                'PUNCH_IN'    => $first['OFFICEPUNCH'] ?? '-',
                'PUNCH_OUT'   => $second['OFFICEPUNCH'] ?? '-',
                'SYSTEMIP'    => $first['SYSTEMIP'] ?? '-',
            ];
        }

        // ✅ EXPORT CSV
        $filename = 'attendance_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($processedRows) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                '#',
                'Branch',
                'Card No',
                'PayCode',
                'Punch In',
                'Punch Out',
                'Created Date',
                'System IP',
            ]);

            foreach ($processedRows as $key => $row) {
                fputcsv($file, [
                    $key + 1,
                    $row['BRANCH_NAME'],
                    $row['CARDNO'],
                    $row['PAYCODE'],
                    $row['PUNCH_IN'],
                    $row['PUNCH_OUT'],
                    $row['DATE'],
                    $row['SYSTEMIP'],
                ]);
            }

            fclose($file);
        }, $filename);
    }

    public function vendorInventory()
    {
        return view('admin.company.products');
    }

    public function vendorReplaced(Request $request, $id, $vendorid)
    {
        $vendorid = Company::where('id', $vendorid)->firstOrFail();
        $vendoruserid = $vendorid->user_id;

        $repaired = WarrantyClaim::where('product_id', $id)->where('assign_to', $vendoruserid)->where('service_status', 'replaced')->get();

        return view('admin.company.replacedinventory', compact('repaired', 'vendorid', 'vendoruserid'));
    }
}