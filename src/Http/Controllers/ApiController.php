<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
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

    protected function updatePartial(Subscription $subscription, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $subscription->$key = $value;
        }
        $saved = $subscription->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Subscription $subscription): JsonResponse
    {
        $deleted = $subscription->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Subscription $subscription): Collection
    {
        return $subscription->files;
    }

    public function attachFiles(Subscription $subscription, Request $request): JsonResponse
    {
        return $subscription->attachFiles($request);
    }

    public function detachFile(Subscription $subscription, File $file): void
    {
        $subscription->detachFile($file);
    }
}
