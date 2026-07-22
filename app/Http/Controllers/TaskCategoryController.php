<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskCategoryRequest;
use App\Http\Requests\UpdateTaskCategoryRequest;
use App\Models\TaskCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TaskCategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));
        $sort = (string) $request->input('sort', 'name');
        $direction = (string) $request->input('direction', 'asc');

        $sort = in_array($sort, ['name', 'created_at'], true) ? $sort : 'name';
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $taskCategories = TaskCategory::query()
            ->when(
                Schema::hasTable('tasks'),
                fn ($query) => $query->withCount('tasks')
            )
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->orderBy('id')
            ->paginate(15)
            ->through(fn (TaskCategory $taskCategory): array => $this->transformTaskCategory($taskCategory))
            ->appends($request->only(['search', 'sort', 'direction']));

        return Inertia::render('TaskCategories/Index', [
            'taskCategories' => $taskCategories,
            'filters' => [
                'search' => $search,
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function store(StoreTaskCategoryRequest $request): RedirectResponse
    {
        TaskCategory::query()->create($this->prepareTaskCategoryPayload($request->validated()));

        return back()->with('success', 'Kategori task berhasil ditambahkan.');
    }

    public function update(
        UpdateTaskCategoryRequest $request,
        TaskCategory $taskCategory
    ): RedirectResponse {
        $taskCategory->update($this->prepareTaskCategoryPayload($request->validated()));

        return back()->with('success', 'Kategori task berhasil diperbarui.');
    }

    public function destroy(TaskCategory $taskCategory): RedirectResponse
    {
        if (Schema::hasTable('tasks') && $taskCategory->tasks()->exists()) {
            return back()->with('error', 'Kategori task tidak dapat dihapus karena sudah digunakan oleh task.');
        }

        $taskCategory->delete();

        return back()->with('success', 'Kategori task berhasil dihapus.');
    }

    /**
     * @param  array{name: string, description?: string|null}  $payload
     * @return array{name: string, slug: string, description: string|null}
     */
    private function prepareTaskCategoryPayload(array $payload): array
    {
        return [
            'name' => $payload['name'],
            'slug' => Str::slug($payload['name']),
            'description' => $payload['description'] ?? null,
        ];
    }

    /**
     * @return array{
     *     id: int,
     *     uuid: string,
     *     name: string,
     *     slug: string,
     *     description: string|null,
     *     tasks_count: int,
     *     created_at: string|null,
     *     updated_at: string|null
     * }
     */
    private function transformTaskCategory(TaskCategory $taskCategory): array
    {
        return [
            'id' => $taskCategory->id,
            'uuid' => $taskCategory->uuid,
            'name' => $taskCategory->name,
            'slug' => $taskCategory->slug,
            'description' => $taskCategory->description,
            'tasks_count' => (int) ($taskCategory->tasks_count ?? 0),
            'created_at' => $taskCategory->created_at?->toIso8601String(),
            'updated_at' => $taskCategory->updated_at?->toIso8601String(),
        ];
    }
}
