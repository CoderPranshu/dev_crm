<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPlanClient;
use App\Models\SeoProjectKeyword;
use App\Models\SeoProjectLocation;
use App\Models\SeoProjectStateGroup;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeoProjectKeywordController extends Controller
{
    public function index(SeoPlanClient $seoPlanClient): View
    {
        $duration = $this->resolveDuration($seoPlanClient);
        $months = range(0, $duration);
        $serviceStartDate = $this->resolveServiceStartDate($seoPlanClient);
        $monthDates = [];

        foreach ($months as $month) {
            $monthDates[$month] = $serviceStartDate->addMonthsNoOverflow($month);
        }

        $keywords = SeoProjectKeyword::with('rankings')
            ->where('seo_plan_client_id', $seoPlanClient->id)
            ->orderBy('id')
            ->get();

        $keywords->each(function (SeoProjectKeyword $keyword): void {
            $keyword->rankingsByMonth = $keyword->rankings
                ->pluck('ranking', 'month_no');
        });

        $areas = SeoProjectLocation::where('seo_plan_client_id', $seoPlanClient->id)
            ->where('type', SeoProjectLocation::TYPE_AREA)
            ->orderBy('id')
            ->get();

        $stateGroups = SeoProjectStateGroup::with([
            'states' => function ($query) use ($seoPlanClient) {
                $query->where('seo_plan_client_id', $seoPlanClient->id)
                    ->where('type', SeoProjectLocation::TYPE_STATE)
                    ->orderBy('id');
            },
            'states.rankings',
        ])
            ->where('seo_plan_client_id', $seoPlanClient->id)
            ->orderBy('id')
            ->get();

        $stateGroups->each(function (SeoProjectStateGroup $group): void {
            $group->states->each(function (SeoProjectLocation $state): void {
                $state->rankingsByMonth = $state->rankings
                    ->pluck('ranking', 'month_no');
            });
        });

        return view('seo-project-keywords.index', compact(
            'seoPlanClient',
            'months',
            'monthDates',
            'serviceStartDate',
            'duration',
            'keywords',
            'areas',
            'stateGroups'
        ));
    }

    public function saveAll(
        Request $request,
        SeoPlanClient $seoPlanClient
    ): RedirectResponse {
        $maxMonth = $this->resolveDuration($seoPlanClient);

        $validated = $request->validate([
            'keywords' => ['nullable', 'array'],
            'keywords.*.id' => ['nullable', 'integer'],
            'keywords.*.keyword' => ['required', 'string', 'max:255'],
            'keywords.*.search_volume' => ['nullable', 'integer', 'min:0'],
            'keywords.*.starting_rank' => ['nullable', 'integer', 'min:0'],
            'keywords.*.rankings' => ['nullable', 'array'],
            'keywords.*.rankings.*' => ['nullable', 'integer', 'min:0'],
            'deleted_keywords' => ['nullable', 'array'],
            'deleted_keywords.*' => ['integer'],

            'areas' => ['nullable', 'array'],
            'areas.*.id' => ['nullable', 'integer'],
            'areas.*.name' => ['required', 'string', 'max:255'],
            'deleted_areas' => ['nullable', 'array'],
            'deleted_areas.*' => ['integer'],

            'states' => ['nullable', 'array'],
            'states.*.id' => ['required', 'integer'],
            'states.*.state_group_id' => ['required', 'integer'],
            'states.*.name' => ['required', 'string', 'max:255'],
            'states.*.rankings' => ['nullable', 'array'],
            'states.*.rankings.*' => ['nullable', 'integer', 'min:0'],
            'deleted_states' => ['nullable', 'array'],
            'deleted_states.*' => ['integer'],
        ]);

        DB::transaction(function () use ($validated, $seoPlanClient, $maxMonth): void {
            $this->deleteKeywords($validated['deleted_keywords'] ?? [], $seoPlanClient);
            $this->saveKeywords($validated['keywords'] ?? [], $seoPlanClient, $maxMonth);

            $this->deleteAreas($validated['deleted_areas'] ?? [], $seoPlanClient);
            $this->saveAreas($validated['areas'] ?? [], $seoPlanClient);

            $this->deleteStates($validated['deleted_states'] ?? [], $seoPlanClient);
            $this->saveStates($validated['states'] ?? [], $seoPlanClient, $maxMonth);
        });

        return redirect()
            ->route('seo-project-keywords.index', [
                'seoPlanClient' => $seoPlanClient->getRouteKey(),
            ])
            ->with('success', 'SEO Project data saved successfully.');
    }

    public function storeStateGroup(
        Request $request,
        SeoPlanClient $seoPlanClient
    ): JsonResponse {
        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $name = trim($validated['name']);

        $group = SeoProjectStateGroup::firstOrCreate([
            'seo_plan_client_id' => $seoPlanClient->id,
            'name' => $name,
        ]);

        return response()->json([
            'status' => true,
            'created' => $group->wasRecentlyCreated,
            'message' => $group->wasRecentlyCreated
                ? 'State group created successfully.'
                : 'This state group already exists.',
            'group' => $group,
        ]);
    }

    public function storeState(
        Request $request,
        SeoPlanClient $seoPlanClient,
        SeoProjectStateGroup $stateGroup
    ): JsonResponse {
        if ((int) $stateGroup->seo_plan_client_id !== (int) $seoPlanClient->id) {
            return response()->json([
                'status' => false,
                'message' => 'The selected state group does not belong to this client.',
            ], 422);
        }

        $request->merge([
            'name' => trim((string) $request->input('name')),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $state = SeoProjectLocation::firstOrCreate([
            'seo_plan_client_id' => $seoPlanClient->id,
            'state_group_id' => $stateGroup->id,
            'type' => SeoProjectLocation::TYPE_STATE,
            'name' => trim($validated['name']),
        ]);

        return response()->json([
            'status' => true,
            'created' => $state->wasRecentlyCreated,
            'message' => $state->wasRecentlyCreated
                ? 'State created successfully.'
                : 'This state already exists in the selected group.',
            'state' => $state,
        ]);
    }

    /**
     * Delete one keyword immediately from the page.
     */
    public function destroyKeyword(
        SeoPlanClient $seoPlanClient,
        SeoProjectKeyword $keyword
    ): JsonResponse {
        if ((int) $keyword->seo_plan_client_id !== (int) $seoPlanClient->id) {
            return response()->json([
                'status' => false,
                'message' => 'The selected keyword does not belong to this client.',
            ], 422);
        }

        DB::transaction(function () use ($keyword): void {
            $keyword->rankings()->delete();
            $keyword->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Keyword deleted successfully.',
        ]);
    }

    /**
     * Delete one area or state immediately from the page.
     */
    public function destroyLocation(
        SeoPlanClient $seoPlanClient,
        SeoProjectLocation $location
    ): JsonResponse {
        if ((int) $location->seo_plan_client_id !== (int) $seoPlanClient->id) {
            return response()->json([
                'status' => false,
                'message' => 'The selected location does not belong to this client.',
            ], 422);
        }

        if (!in_array($location->type, [
            SeoProjectLocation::TYPE_AREA,
            SeoProjectLocation::TYPE_STATE,
        ], true)) {
            return response()->json([
                'status' => false,
                'message' => 'This location cannot be deleted from this page.',
            ], 422);
        }

        DB::transaction(function () use ($location): void {
            if ($location->type === SeoProjectLocation::TYPE_STATE) {
                $location->rankings()->delete();
            }

            $location->delete();
        });

        return response()->json([
            'status' => true,
            'message' => 'Record deleted successfully.',
        ]);
    }

    private function deleteKeywords(array $ids, SeoPlanClient $client): void
    {
        if ($ids === []) {
            return;
        }

        $keywords = SeoProjectKeyword::where('seo_plan_client_id', $client->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($keywords as $keyword) {
            $keyword->rankings()->delete();
            $keyword->delete();
        }
    }

    private function saveKeywords(array $rows, SeoPlanClient $client, int $maxMonth): void
    {
        foreach ($rows as $row) {
            $id = isset($row['id']) && $row['id'] !== '' ? (int) $row['id'] : null;

            $keyword = $id
                ? SeoProjectKeyword::where('seo_plan_client_id', $client->id)->find($id)
                : null;

            if (!$keyword) {
                $keyword = new SeoProjectKeyword();
                $keyword->seo_plan_client_id = $client->id;
            }

            $keyword->keyword = trim($row['keyword']);
            $keyword->search_volume = $this->nullableInteger($row['search_volume'] ?? null);
            $keyword->starting_rank = $this->nullableInteger($row['starting_rank'] ?? null);
            $keyword->save();

            $this->saveRankings($keyword, $row['rankings'] ?? [], $maxMonth);
        }
    }

    private function deleteAreas(array $ids, SeoPlanClient $client): void
    {
        if ($ids === []) {
            return;
        }

        SeoProjectLocation::where('seo_plan_client_id', $client->id)
            ->where('type', SeoProjectLocation::TYPE_AREA)
            ->whereIn('id', $ids)
            ->delete();
    }

    private function saveAreas(array $rows, SeoPlanClient $client): void
    {
        foreach ($rows as $row) {
            $id = isset($row['id']) && $row['id'] !== '' ? (int) $row['id'] : null;

            $area = $id
                ? SeoProjectLocation::where('seo_plan_client_id', $client->id)
                    ->where('type', SeoProjectLocation::TYPE_AREA)
                    ->find($id)
                : null;

            if (!$area) {
                $area = new SeoProjectLocation();
                $area->seo_plan_client_id = $client->id;
                $area->type = SeoProjectLocation::TYPE_AREA;
            }

            $area->state_group_id = null;
            $area->name = trim($row['name']);
            $area->save();
        }
    }

    private function deleteStates(array $ids, SeoPlanClient $client): void
    {
        if ($ids === []) {
            return;
        }

        $states = SeoProjectLocation::where('seo_plan_client_id', $client->id)
            ->where('type', SeoProjectLocation::TYPE_STATE)
            ->whereIn('id', $ids)
            ->get();

        foreach ($states as $state) {
            $state->rankings()->delete();
            $state->delete();
        }
    }

    private function saveStates(array $rows, SeoPlanClient $client, int $maxMonth): void
    {
        foreach ($rows as $row) {
            $state = SeoProjectLocation::where('seo_plan_client_id', $client->id)
                ->where('type', SeoProjectLocation::TYPE_STATE)
                ->find((int) $row['id']);

            if (!$state) {
                continue;
            }

            $groupBelongsToClient = SeoProjectStateGroup::where('seo_plan_client_id', $client->id)
                ->where('id', (int) $row['state_group_id'])
                ->exists();

            if (!$groupBelongsToClient) {
                continue;
            }

            $state->name = trim($row['name']);
            $state->state_group_id = (int) $row['state_group_id'];
            $state->save();

            $this->saveRankings($state, $row['rankings'] ?? [], $maxMonth);
        }
    }

    private function saveRankings($owner, array $rankings, int $maxMonth): void
    {
        foreach ($rankings as $monthNo => $ranking) {
            $monthNo = (int) $monthNo;

            if ($monthNo < 0 || $monthNo > $maxMonth) {
                continue;
            }

            $owner->rankings()->updateOrCreate(
                ['month_no' => $monthNo],
                ['ranking' => $this->nullableInteger($ranking)]
            );
        }
    }

    private function nullableInteger($value): ?int
    {
        return $value === '' || $value === null ? null : (int) $value;
    }

    private function resolveDuration(SeoPlanClient $seoPlanClient): int
    {
        $candidates = [
            'duration',
            'project_duration',
            'duration_months',
            'months',
            'plan_duration',
        ];

        foreach ($candidates as $column) {
            $value = $seoPlanClient->{$column} ?? null;

            if (is_numeric($value)) {
                return max(0, min(12, (int) $value));
            }
        }

        return 12;
    }

    /**
     * Resolve the date on which the client started this SEO service.
     *
     * The first matching project-specific date is used. If the project does
     * not have a dedicated service date column, the SeoPlanClient creation
     * date is treated as Month 0.
     */
    private function resolveServiceStartDate(
        SeoPlanClient $seoPlanClient
    ): CarbonImmutable {
        $candidates = [
            'service_start_date',
            'start_date',
            'project_start_date',
            'seo_start_date',
            'subscription_start_date',
            'assigned_at',
            'assigned_date',
            'service_date',
            'created_at',
        ];

        foreach ($candidates as $column) {
            $value = $seoPlanClient->{$column} ?? null;

            if (blank($value)) {
                continue;
            }

            try {
                return CarbonImmutable::parse($value)->startOfDay();
            } catch (\Throwable $exception) {
                // Try the next supported date column.
            }
        }

        return CarbonImmutable::now()->startOfDay();
    }
}
