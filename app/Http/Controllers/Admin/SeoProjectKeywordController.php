<?php

// namespace App\Http\Controllers;
// namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;



use App\Models\SeoPlanClient;
use App\Models\SeoProjectKeyword;
use App\Models\SeoProjectLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SeoProjectKeywordController extends Controller
{
    /**
     * Show the SEO Project Keywords page for a given SEO Plan Client.
     */
    public function index(SeoPlanClient $seoPlanClient): View
    {
        $duration = $this->resolveDuration($seoPlanClient);
        $months = range(0, $duration);

        $keywords = SeoProjectKeyword::with('rankings')
            ->where('seo_plan_client_id', $seoPlanClient->id)
            ->orderBy('id')
            ->get()
            ->map(function (SeoProjectKeyword $keyword) {
                $keyword->rankingsByMonth = $keyword->rankings->pluck('ranking', 'month_no');

                return $keyword;
            });

        $areas = SeoProjectLocation::where('seo_plan_client_id', $seoPlanClient->id)
            ->areas()
            ->orderBy('id')
            ->get();

        $states = SeoProjectLocation::with('rankings')
            ->where('seo_plan_client_id', $seoPlanClient->id)
            ->states()
            ->orderBy('id')
            ->get()
            ->map(function (SeoProjectLocation $state) {
                $state->rankingsByMonth = $state->rankings->pluck('ranking', 'month_no');

                return $state;
            });

        return view('seo-project-keywords.index', [
            'seoPlanClient' => $seoPlanClient,
            'months' => $months,
            'duration' => $duration,
            'keywords' => $keywords,
            'areas' => $areas,
            'states' => $states,
        ]);
    }

    /**
     * Save keywords, areas and states (with their monthly rankings) in one go.
     */
    public function saveAll(Request $request, SeoPlanClient $seoPlanClient): RedirectResponse
    {
        $duration = $this->resolveDuration($seoPlanClient);
        $maxMonth = $duration;

        $validated = $request->validate([
            'keywords' => ['array'],
            'keywords.*.id' => ['nullable', 'integer', 'exists:seo_project_keywords,id'],
            'keywords.*.keyword' => ['required_with:keywords', 'string', 'max:255'],
            'keywords.*.search_volume' => ['nullable', 'integer', 'min:0'],
            'keywords.*.starting_rank' => ['nullable', 'integer', 'min:0'],
            'keywords.*.rankings' => ['array'],
            'keywords.*.rankings.*' => ['nullable', 'integer', 'min:0'],
            'deleted_keywords' => ['array'],
            'deleted_keywords.*' => ['integer'],

            'areas' => ['array'],
            'areas.*.id' => ['nullable', 'integer', 'exists:seo_project_locations,id'],
            'areas.*.name' => ['required_with:areas', 'string', 'max:255'],
            'deleted_areas' => ['array'],
            'deleted_areas.*' => ['integer'],

            'states' => ['array'],
            'states.*.id' => ['nullable', 'integer', 'exists:seo_project_locations,id'],
            'states.*.name' => ['required_with:states', 'string', 'max:255'],
            'states.*.rankings' => ['array'],
            'states.*.rankings.*' => ['nullable', 'integer', 'min:0'],
            'deleted_states' => ['array'],
            'deleted_states.*' => ['integer'],
        ]);

        DB::transaction(function () use ($validated, $seoPlanClient, $maxMonth) {
            // ---- Keywords ----
            $keywordIdsToDelete = $validated['deleted_keywords'] ?? [];
            if (!empty($keywordIdsToDelete)) {
                SeoProjectKeyword::where('seo_plan_client_id', $seoPlanClient->id)
                    ->whereIn('id', $keywordIdsToDelete)
                    ->delete();
            }

            foreach ($validated['keywords'] ?? [] as $row) {
                $keyword = SeoProjectKeyword::updateOrCreate(
                    [
                        'id' => $row['id'] ?? null,
                        'seo_plan_client_id' => $seoPlanClient->id,
                    ],
                    [
                        'seo_plan_client_id' => $seoPlanClient->id,
                        'keyword' => $row['keyword'],
                        'search_volume' => $row['search_volume'] ?? null,
                        'starting_rank' => $row['starting_rank'] ?? null,
                    ]
                );

                foreach (($row['rankings'] ?? []) as $monthNo => $ranking) {
                    if ((int) $monthNo > $maxMonth) {
                        continue;
                    }

                    $keyword->rankings()->updateOrCreate(
                        ['month_no' => (int) $monthNo],
                        ['ranking' => $ranking === '' ? null : $ranking]
                    );
                }
            }

            // ---- Areas We Serve ----
            $areaIdsToDelete = $validated['deleted_areas'] ?? [];
            if (!empty($areaIdsToDelete)) {
                SeoProjectLocation::where('seo_plan_client_id', $seoPlanClient->id)
                    ->where('type', SeoProjectLocation::TYPE_AREA)
                    ->whereIn('id', $areaIdsToDelete)
                    ->delete();
            }

            foreach ($validated['areas'] ?? [] as $row) {
                SeoProjectLocation::updateOrCreate(
                    [
                        'id' => $row['id'] ?? null,
                        'seo_plan_client_id' => $seoPlanClient->id,
                        'type' => SeoProjectLocation::TYPE_AREA,
                    ],
                    [
                        'seo_plan_client_id' => $seoPlanClient->id,
                        'type' => SeoProjectLocation::TYPE_AREA,
                        'name' => $row['name'],
                    ]
                );
            }

            // ---- States ----
            $stateIdsToDelete = $validated['deleted_states'] ?? [];
            if (!empty($stateIdsToDelete)) {
                SeoProjectLocation::where('seo_plan_client_id', $seoPlanClient->id)
                    ->where('type', SeoProjectLocation::TYPE_STATE)
                    ->whereIn('id', $stateIdsToDelete)
                    ->delete();
            }

            foreach ($validated['states'] ?? [] as $row) {
                $state = SeoProjectLocation::updateOrCreate(
                    [
                        'id' => $row['id'] ?? null,
                        'seo_plan_client_id' => $seoPlanClient->id,
                        'type' => SeoProjectLocation::TYPE_STATE,
                    ],
                    [
                        'seo_plan_client_id' => $seoPlanClient->id,
                        'type' => SeoProjectLocation::TYPE_STATE,
                        'name' => $row['name'],
                    ]
                );

                foreach (($row['rankings'] ?? []) as $monthNo => $ranking) {
                    if ((int) $monthNo > $maxMonth) {
                        continue;
                    }

                    $state->rankings()->updateOrCreate(
                        ['month_no' => (int) $monthNo],
                        ['ranking' => $ranking === '' ? null : $ranking]
                    );
                }
            }
        });

        return redirect()
            ->route('seo-project-keywords.index', $seoPlanClient->id)
            ->with('success', 'SEO Project Keywords saved successfully.');
    }

    /**
     * Determine the SEO Project duration (in months) for this client.
     *
     * NOTE: adjust the column name below to match wherever the SEO Project
     * duration is actually stored on SeoPlanClient (or its related project)
     * in your codebase. Falls back to 12 if none of these exist.
     */
    private function resolveDuration(SeoPlanClient $seoPlanClient): int
    {
        $candidates = ['duration', 'project_duration', 'duration_months', 'months', 'plan_duration'];

        foreach ($candidates as $column) {
            if (isset($seoPlanClient->{$column}) && is_numeric($seoPlanClient->{$column})) {
                return max(0, min(12, (int) $seoPlanClient->{$column}));
            }
        }

        return 12;
    }
}