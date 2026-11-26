<div class="col-md-12 mt-3">
    <div class="border rounded p-3" style="background:#fff">
        <h5 class="mb-2">Attendance, absence & leave by date</h5>
        <p class="text-muted mb-2" style="font-size:13px">
            Full {{ $ledger['counts']['full'] }} · Half {{ $ledger['counts']['half'] }} · Single punch {{ $ledger['counts']['single'] }}
            · Absent {{ $ledger['counts']['absent'] }} · Leave pending {{ $ledger['counts']['pending_leave'] }}
            · Approved leave {{ $ledger['counts']['paid_leave'] }}.
            Single punch is unpaid. Pending leave without completed attendance is unpaid. Leave status is checked again when saving.
        </p>
        <div class="table-responsive" style="max-height:410px;overflow:auto">
            <table class="table table-sm table-bordered align-middle mb-0" style="font-size:13px;min-width:650px">
                <thead class="table-light" style="position:sticky;top:0;z-index:1">
                    <tr><th>Date</th><th>Attendance</th><th>Leave Taken / Status</th><th>Paid day</th><th>Salary effect</th></tr>
                </thead>
                <tbody>
                    @foreach($ledger['rows'] as $row)
                        @continue(in_array($row['status'], ['sunday', 'holiday', 'pre_join']))
                        @php
                            $attendanceStatus = $row['attendance_status'] ?? $row['status'];
                            $attendanceLabel = ['full' => 'Full', 'half' => 'Half', 'single' => 'Single punch',
                                'absent' => 'No punch', 'future' => 'Upcoming'][$attendanceStatus] ?? 'No punch';
                            $effect = ['full' => '1 day paid', 'half' => '0.5 day paid / 0.5 deducted',
                                'single' => '1 day unpaid', 'paid_leave' => '1 day paid',
                                'unpaid_leave' => '1 day unpaid', 'pending_leave' => '1 day unpaid until approved',
                                'absent' => '1 day unpaid', 'future' => 'Not due yet'][$row['status']] ?? '—';
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }} ({{ $row['day'] }})</td>
                            <td>{{ $attendanceLabel }}
                                @if(!empty($row['first'])) <small class="d-block">{{ $row['first'] }} – {{ $row['last'] ?? '?' }}</small> @endif
                                @if(($row['source'] ?? '') === 'Approved correction') <small class="d-block text-success">Correction approved</small> @endif
                            </td>
                            <td>
                                @forelse(($row['leave_requests'] ?? []) as $leave)
                                    <div>{{ $leave['label'] }}: <strong>{{ ucfirst($leave['decision']) }}</strong></div>
                                @empty
                                    —
                                @endforelse
                                @if($attendanceStatus === 'single' && !empty($row['leave_requests'])) <small class="d-block text-danger">Single punch remains unpaid until attendance correction</small> @endif
                            </td>
                            <td>{{ number_format($row['paid_units'], 1) }}</td>
                            <td>{{ $effect }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <small class="text-muted">Sundays, holidays and dates before joining are excluded. Reopen this page to see new leave decisions; Submit also checks current database status.</small>
    </div>
</div>
