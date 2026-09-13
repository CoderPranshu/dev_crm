<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class AttendanceService
{
    public function getAttendance(array $filters = []): array
    {
        // 1️⃣ Dates (default: last 7 days)
        $fromDate = $filters['from_date']
            ?? Carbon::now()->subDays(7)->format('Y/m/d');

        $toDate = $filters['to_date']
            ?? Carbon::now()->format('Y/m/d');

        $branchId = $filters['branch_id'] ?? null;

        // 2️⃣ Get branches
        $branches = Branch::select('id', 'title', 'machine_serial_no')->get();

        $selectedBranches = $branchId
            ? $branches->where('id', $branchId)
            : $branches;

        $rows = [];

        // 3️⃣ API calls
        foreach ($selectedBranches as $branch) {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('http://ta.biumetrics.com/api/transaction/GetRowData', [
                'TXN_NAME'=> 'GetRowData',
                'DATA' => json_encode([
                    'Company_Code' => '17',
                    'ReportDate_From' => $fromDate,
                    'ReportDate_To' => $toDate,
                    'MachineSerialNo' => $branch->machine_serial_no
                ])
            ]);

            $data = $response->json()['Data'] ?? [];

            foreach ($data as $row) {
                $row['BRANCH_NAME'] = $branch->title;
                $rows[] = $row;
            }
        }

        // 4️⃣ Process Punch IN / OUT
        $processedRows = $this->processPunchData($rows);

        return [
            'branches' => $branches,
            'rows'     => $processedRows,
        ];
    }

    /**
     * Punch IN / OUT logic
     */
    private function processPunchData(array $rows): array
    {
        $processed = [];

        $grouped = collect($rows)->groupBy(function ($row) {
            // IMPORTANT: group by PAYCODE + punch DATE
            $punchDate = substr($row['OFFICEPUNCH'], 0, 10);
            return $row['PAYCODE'] . '_' . $punchDate;
        });

        foreach ($grouped as $items) {

            $items = collect($items)->sortBy('OFFICEPUNCH')->values();

            $first  = $items->first();
            $second = $items->count() > 1 ? $items->get(1) : null;

            $processed[] = [
                'BRANCH_NAME' => $first['BRANCH_NAME'],
                'PAYCODE'     => $first['PAYCODE'],
                'CARDNO'      => $first['CARDNO'] ?? '',
                'DATE'        => substr($first['OFFICEPUNCH'], 0, 10),
                'PUNCH_IN'    => $first['OFFICEPUNCH'] ?? '-',
                'PUNCH_OUT'   => $second['OFFICEPUNCH'] ?? '-',
                'SYSTEMIP'    => $first['SYSTEMIP'] ?? '-',
            ];
        }

        return $processed;
    }
}
