<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View {
        $roles = Role::query()->paginate();

        return view('admin.role.list', [
            'roles' => $roles,
        ]);
    }

    public function edit(Role $role): View {
        return view('admin.role.edit', [
            'role' => $role,
        ]);
    }

    /**
     * @param Request $request
     * @param Role $role
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Role $role): RedirectResponse {

        $this->validate($request, [
            'name' => 'required|min:6',
        ]);

        $role->name = $request->input('name');
        $role->full_access = $request->input('full_access', 0);
//        $role->accessible_routes = $request->input('accessible_routes'); todo: make it
        $role->description = $request->input('description');
        $role->save();

        return redirect()->route('admin.role.index')
            ->with('status', 'Updated success!');
    }
}
