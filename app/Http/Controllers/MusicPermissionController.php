<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MusicPermissionController extends Controller
{
    private const TZ = 'Asia/Kolkata';

    private function now(): Carbon
    {
        return Carbon::now(self::TZ);
    }

    private function manager($user): bool
    {
        $role = strtolower((string) ($user->role ?? ''));
        return in_array($role, ['admin', 'hr'], true)
            || (method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'Admin', 'HR', 'hr']));
    }

    private function assertManager(): void
    {
        abort_unless($this->manager(auth()->user()), 403);
    }

    private function employee($id)
    {
        return DB::table('users')->where('id', $id)->where('status', 'active')
            ->first(['id', 'name', 'department', 'branch_id']);
    }

    private function peers($person)
    {
        return DB::table('users')->where('status', 'active')
            ->where('department', $person->department)->where('branch_id', $person->branch_id);
    }

    private function audit(string $entity, int $id, string $event, array $details = []): void
    {
        DB::table('music_audit_events')->insert([
            'actor_id' => auth()->id(), 'entity_type' => $entity, 'entity_id' => $id,
            'event' => $event, 'details' => json_encode($details, JSON_UNESCAPED_UNICODE),
            'created_at' => $this->now()->toDateTimeString(),
        ]);
    }

    private function refreshStates(): void
    {
        $now = $this->now()->toDateTimeString();
        DB::table('music_requests')->where('status', 'voting')->where('voting_ends_at', '<=', $now)
            ->update(['status' => 'expired', 'updated_at' => $now]);
        DB::table('music_requests')->where('status', 'approved')->whereNull('started_at')
            ->where('request_date', '<', $this->now()->toDateString())
            ->update(['status' => 'expired', 'updated_at' => $now]);
        DB::table('music_requests')->where('status', 'approved')->whereNotNull('ends_at')
            ->where('ends_at', '<=', $now)->update(['status' => 'finished', 'updated_at' => $now]);
    }

    public function index()
    {
        $this->refreshStates();
        $user = auth()->user();
        $manager = $this->manager($user);
        $me = $this->employee($user->id);
        $today = $this->now()->toDateString();
        $eligible = $me && $me->department ? $this->peers($me)->where('id', '!=', $me->id)->count() : 0;
        $requests = DB::table('music_requests as r')->join('users as u', 'u.id', '=', 'r.user_id')
            ->join('departments as d', 'd.id', '=', 'r.department_id')
            ->when(! $manager, fn ($q) => $q->where('r.department_id', $me->department ?? 0)
                ->where('r.branch_id', $me->branch_id ?? null))
            ->orderByDesc('r.id')->limit(60)
            ->get(['r.*', 'u.name as employee_name', 'd.title as department_name']);
        $voteIds = DB::table('music_request_voters')->where('voter_id', $user->id)
            ->whereIn('request_id', $requests->pluck('id'))->pluck('request_id')->all();
        $myRequest = DB::table('music_requests')->where('user_id', $user->id)
            ->where('request_date', $today)->first();
        $employees = $manager
            ? DB::table('users')->where('status', 'active')->whereNotNull('department')->orderBy('name')
                ->get(['id', 'name', 'department', 'branch_id'])
            : ($me && $me->department ? $this->peers($me)->where('id', '!=', $me->id)
                ->orderBy('name')->get(['id', 'name', 'department', 'branch_id']) : collect());
        $complaints = DB::table('music_complaints as c')
            ->join('users as s', 's.id', '=', 'c.subject_id')
            ->join('users as reporter', 'reporter.id', '=', 'c.reporter_id')
            ->when(! $manager, fn ($q) => $q->where('c.reporter_id', $user->id))
            ->orderByDesc('c.id')->limit(40)
            ->get(['c.*', 's.name as subject_name', 'reporter.name as reporter_name']);
        $penalties = DB::table('music_penalty_proposals as p')->join('users as u', 'u.id', '=', 'p.user_id')
            ->when(! $manager, fn ($q) => $q->where('p.user_id', $user->id))
            ->orderByDesc('p.id')->limit(100)->get(['p.*', 'u.name as employee_name']);
        return view('music-permission.index', compact('manager', 'me', 'today', 'eligible',
            'requests', 'voteIds', 'myRequest', 'employees', 'complaints', 'penalties'));
    }

    public function request(): \Illuminate\Http\RedirectResponse
    {
        $person = $this->employee(auth()->id());
        abort_unless($person && $person->department, 422, 'Assign your department first.');
        $now = $this->now();
        $peers = $this->peers($person)->where('id', '!=', $person->id)->pluck('id');
        $count = $peers->count();
        $required = max(1, (int) ceil($count * 0.4));
        try {
            DB::transaction(function () use ($person, $now, $peers, $count, $required) {
                $id = DB::table('music_requests')->insertGetId([
                    'user_id' => $person->id, 'department_id' => $person->department,
                    'branch_id' => $person->branch_id, 'request_date' => $now->toDateString(),
                    'status' => 'voting', 'eligible_count' => $count, 'required_votes' => $required,
                    'voting_ends_at' => $now->copy()->addMinutes(5)->toDateTimeString(),
                    'created_at' => $now->toDateTimeString(), 'updated_at' => $now->toDateTimeString(),
                ]);
                foreach ($peers as $peerId) DB::table('music_request_voters')->insert([
                    'request_id' => $id, 'voter_id' => $peerId,
                ]);
                $this->audit('request', $id, 'opened', ['eligible' => $count, 'required_yes' => $required]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() !== '23000') throw $e;
            return back()->withErrors(['request' => 'Aaj ki request pehle hi ban chuki hai.']);
        }
        return back()->with('message', 'Request bhej di. Voting ke liye 5 minutes hain.');
    }

    public function vote(Request $http, int $id): \Illuminate\Http\RedirectResponse
    {
        $choice = $http->validate(['choice' => ['required', Rule::in(['yes', 'no'])]])['choice'];
        DB::transaction(function () use ($id, $choice) {
            $r = DB::table('music_requests')->where('id', $id)->lockForUpdate()->first();
            abort_unless($r, 404);
            $now = $this->now();
            abort_unless($r->status === 'voting' && $now->lt(Carbon::parse($r->voting_ends_at, self::TZ)), 422, 'Voting closed.');
            $voter = DB::table('music_request_voters')->where('request_id', $id)
                ->where('voter_id', auth()->id())->lockForUpdate()->first();
            abort_unless($voter && $voter->choice === null && $r->user_id != auth()->id(), 403);
            DB::table('music_request_voters')->where('request_id', $id)->where('voter_id', auth()->id())
                ->update(['choice' => $choice, 'voted_at' => $now->toDateTimeString()]);
            $yes = DB::table('music_request_voters')->where('request_id', $id)->where('choice', 'yes')->count();
            $no = DB::table('music_request_voters')->where('request_id', $id)->where('choice', 'no')->count();
            DB::table('music_requests')->where('id', $id)->update([
                'yes_votes' => $yes, 'no_votes' => $no,
                'status' => $yes >= $r->required_votes ? 'approved' : 'voting',
                'updated_at' => $now->toDateTimeString(),
            ]);
            $this->audit('request', $id, 'vote', ['choice' => $choice]);
        });
        return back()->with('message', 'Vote saved.');
    }

    public function override(Request $http, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->assertManager();
        $data = $http->validate([
            'decision' => ['required', Rule::in(['approved', 'denied'])],
            'reason' => ['required', 'string', 'min:5', 'max:500'],
        ]);
        DB::transaction(function () use ($id, $data) {
            $r = DB::table('music_requests')->where('id', $id)->lockForUpdate()->first();
            abort_unless($r && in_array($r->status, ['voting', 'expired', 'denied', 'approved'], true)
                && $r->request_date === $this->now()->toDateString() && ! $r->started_at, 422);
            DB::table('music_requests')->where('id', $id)->update([
                'status' => $data['decision'], 'approved_by' => auth()->id(),
                'override_reason' => $data['reason'], 'updated_at' => $this->now()->toDateTimeString(),
            ]);
            $this->audit('request', $id, 'management_decision', $data);
        });
        return back()->with('message', 'Management decision saved.');
    }

    public function start(int $id): \Illuminate\Http\RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $r = DB::table('music_requests')->where('id', $id)->lockForUpdate()->first();
            $now = $this->now();
            abort_unless($r && $r->user_id == auth()->id() && $r->status === 'approved'
                && ! $r->started_at && $r->request_date === $now->toDateString(), 422);
            $end = $now->copy()->addHour()->min($now->copy()->endOfDay());
            DB::table('music_requests')->where('id', $id)->update([
                'started_at' => $now->toDateTimeString(), 'ends_at' => $end->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ]);
            $this->audit('request', $id, 'listening_started', ['ends_at' => $end->toDateTimeString()]);
        });
        return back()->with('message', '1-hour timer shuru ho gaya.');
    }

    public function stop(int $id): \Illuminate\Http\RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $r = DB::table('music_requests')->where('id', $id)->lockForUpdate()->first();
            abort_unless($r && $r->user_id == auth()->id() && $r->status === 'approved' && $r->started_at, 422);
            $now = $this->now()->toDateTimeString();
            DB::table('music_requests')->where('id', $id)->update([
                'ends_at' => $now, 'status' => 'finished', 'updated_at' => $now,
            ]);
            $this->audit('request', $id, 'listening_stopped');
        });
        return back()->with('message', 'Listening session finished.');
    }

    public function complain(Request $http): \Illuminate\Http\RedirectResponse
    {
        $manager = $this->manager(auth()->user());
        $data = $http->validate([
            'subject_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'observed_at' => ['required', 'date_format:Y-m-d\\TH:i'],
            'details' => ['required', 'string', 'min:10', 'max:1000'],
            'source' => ['required', Rule::in(['colleague', 'management'])],
        ]);
        abort_if($data['source'] === 'management' && ! $manager, 403);
        $subject = $this->employee($data['subject_id']);
        $reporter = $this->employee(auth()->id());
        abort_unless($subject && $reporter && $subject->id != $reporter->id && $subject->department, 422);
        if ($data['source'] === 'colleague') abort_unless($subject->department == $reporter->department
            && $subject->branch_id == $reporter->branch_id, 403);
        $observed = Carbon::createFromFormat('!Y-m-d\\TH:i', $data['observed_at'], self::TZ);
        abort_unless($observed->lte($this->now()) && $observed->gte($this->now()->subDays(7)), 422,
            'Select a time in the last 7 days.');
        $now = $this->now()->toDateTimeString();
        DB::transaction(function () use ($subject, $data, $observed, $now) {
            $id = DB::table('music_complaints')->insertGetId([
                'subject_id' => $subject->id, 'reporter_id' => auth()->id(),
                'department_id' => $subject->department, 'branch_id' => $subject->branch_id,
                'source' => $data['source'], 'observed_at' => $observed->toDateTimeString(),
                'details' => $data['details'], 'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->audit('complaint', $id, 'reported', ['observed_at' => $observed->toDateTimeString()]);
        });
        return back()->with('message', 'Report submitted for HR/admin camera review.');
    }

    public function reviewComplaint(Request $http, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->assertManager();
        $data = $http->validate([
            'finding' => ['required', Rule::in(['substantiated', 'false', 'inconclusive'])],
            'camera_checked' => ['accepted'],
            'camera_reference' => ['nullable', 'string', 'max:255'],
            'review_notes' => ['required', 'string', 'min:10', 'max:1000'],
        ]);
        DB::transaction(function () use ($id, $data) {
            $case = DB::table('music_complaints')->where('id', $id)->lockForUpdate()->first();
            abort_unless($case && $case->status === 'pending'
                && ($case->source === 'management' || $case->reporter_id != auth()->id()), 422,
                'An independent HR/admin reviewer is required.');
            $observed = Carbon::parse($case->observed_at, self::TZ);
            $wasPermitted = DB::table('music_requests')->where('user_id', $case->subject_id)
                ->where('started_at', '<=', $case->observed_at)->where('ends_at', '>=', $case->observed_at)
                ->whereIn('status', ['approved', 'finished'])->exists();
            $otherReport = DB::table('music_complaints')->where('subject_id', $case->subject_id)
                ->where('source', 'colleague')->where('id', '!=', $id)
                ->whereBetween('observed_at', [$observed->copy()->subMinutes(15)->toDateTimeString(),
                    $observed->copy()->addMinutes(15)->toDateTimeString()])->exists();
            $now = $this->now()->toDateTimeString();
            DB::table('music_complaints')->where('id', $id)->update([
                'status' => $data['finding'], 'camera_checked' => 1,
                'camera_reference' => $data['camera_reference'] ?? null,
                'review_notes' => $data['review_notes'], 'reviewed_by' => auth()->id(),
                'reviewed_at' => $now, 'updated_at' => $now,
            ]);
            $targets = [];
            $reason = null;
            if ($case->source === 'colleague' && $data['finding'] === 'false') {
                $targets = [$case->reporter_id];
                $reason = 'false_complaint';
            } elseif ($case->source === 'management' && $data['finding'] === 'substantiated'
                && ! $wasPermitted && ! $otherReport) {
                $targets = $this->peers((object) [
                    'department' => $case->department_id, 'branch_id' => $case->branch_id,
                ])->where(function ($query) use ($observed) {
                    $query->whereNull('join_date')->orWhereDate('join_date', '<=', $observed->toDateString());
                })->pluck('id')->all();
                $reason = 'unreported_department_event';
            }
            foreach ($targets as $userId) DB::table('music_penalty_proposals')->insert([
                'complaint_id' => $id, 'user_id' => $userId, 'amount' => 500,
                'reason' => $reason, 'status' => 'notice', 'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->audit('complaint', $id, 'reviewed', [
                'finding' => $data['finding'], 'permission_at_time' => $wasPermitted,
                'related_colleague_report' => $otherReport, 'proposals' => count($targets),
            ]);
        });
        return back()->with('message', 'Camera review recorded. Any ₹500 entries are notices, not salary deductions.');
    }

    public function respond(Request $http, int $id): \Illuminate\Http\RedirectResponse
    {
        $data = $http->validate(['response_text' => ['required', 'string', 'min:5', 'max:2000']]);
        $updated = DB::table('music_penalty_proposals')->where('id', $id)->where('user_id', auth()->id())
            ->where('status', 'notice')->update([
                'response_text' => $data['response_text'], 'responded_at' => $this->now()->toDateTimeString(),
                'status' => 'response_received', 'updated_at' => $this->now()->toDateTimeString(),
            ]);
        abort_unless($updated, 403);
        $this->audit('proposal', $id, 'employee_response');
        return back()->with('message', 'Your response was recorded.');
    }

    public function decideProposal(Request $http, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->assertManager();
        $data = $http->validate([
            'decision' => ['required', Rule::in(['confirmed_for_payroll_review', 'withdrawn'])],
            'decision_notes' => ['required', 'string', 'min:10', 'max:1000'],
        ]);
        $proposal = DB::table('music_penalty_proposals')->where('id', $id)->first();
        abort_unless($proposal && $proposal->status === 'response_received'
            && $proposal->user_id != auth()->id(), 422,
            'Employee response and independent reviewer are required.');
        $updated = DB::table('music_penalty_proposals')->where('id', $id)->where('status', 'response_received')->update([
            'status' => $data['decision'], 'decision_notes' => $data['decision_notes'],
            'decided_by' => auth()->id(), 'decided_at' => $this->now()->toDateTimeString(),
            'updated_at' => $this->now()->toDateTimeString(),
        ]);
        abort_unless($updated, 422, 'This notice was already decided.');
        $this->audit('proposal', $id, 'decision', $data);
        return back()->with('message', 'Decision saved for payroll/legal review. No salary was deducted.');
    }
}
