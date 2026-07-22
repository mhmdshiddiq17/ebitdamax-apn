<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));
        $roleId = $request->input('role_id');
        $sort = (string) $request->input('sort', 'name');
        $direction = (string) $request->input('direction', 'asc');

        $sort = in_array($sort, ['name', 'email', 'created_at'], true) ? $sort : 'name';
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $users = User::query()
            ->with('role')
            ->when($roleId, fn ($query) => $query->where('role_id', $roleId))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->orderBy('id')
            ->paginate(15)
            ->through(fn (User $user): array => $this->transformUser($user))
            ->appends($request->only(['search', 'role_id', 'sort', 'direction']));

        $roles = Role::query()
            ->ordered()
            ->get(['id', 'name', 'slug', 'level'])
            ->map(fn (Role $role): array => [
                'id' => $role->id,
                'name' => $role->name,
                'slug' => $role->slug,
                'level' => $role->level->value,
                'level_label' => $role->level->label(),
            ])
            ->values();

        return Inertia::render('Users/Index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => [
                'search' => $search,
                'role_id' => $roleId ? (int) $roleId : null,
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($this->prepareUserPayload($request->validated()));

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($this->prepareUserPayload($request->validated()));

        return back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * @param  array{role_id: int, name: string, email: string, password?: string|null}  $payload
     * @return array<string, mixed>
     */
    private function prepareUserPayload(array $payload): array
    {
        $data = [
            'role_id' => $payload['role_id'],
            'name' => $payload['name'],
            'email' => $payload['email'],
        ];

        if (! empty($payload['password'])) {
            $data['password'] = $payload['password'];
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function transformUser(User $user): array
    {
        return [
            'id' => $user->id,
            'role_id' => $user->role_id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at?->toIso8601String(),
            'created_at' => $user->created_at?->toIso8601String(),
            'updated_at' => $user->updated_at?->toIso8601String(),
            'role' => $user->role ? [
                'id' => $user->role->id,
                'name' => $user->role->name,
                'slug' => $user->role->slug,
                'level' => $user->role->level->value,
                'level_label' => $user->role->level->label(),
            ] : null,
        ];
    }
}
