<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Subscription::class)
            ->selectFields($request->input('fields.subscriptions'))
            ->allowedSorts(['plan', 'name'])
            ->allowedFilters([
                AllowedFilter::custom('plan', new FilterOr()),
            ])
            ->allowedIncludes(['owner'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    public function destroy(Subscription $subscription): JsonResponse
    {
        $deleted = $subscription->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }
}
