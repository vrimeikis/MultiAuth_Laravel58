<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): View {
        $admins = Admin::query()->paginate();

        return view('admin.administrator.list', [
            'admins' => $admins,
        ]);
    }

    /**
     * @param Admin $admin
     *
     * @return View
     */
    public function edit(Admin $admin): View {
        $roles = Role::all();

        return view('admin.administrator.edit', [
            'admin' => $admin,
            'roles' => $roles,
        ]);
    }

    /**
     * @param Request $request
     * @param Admin $admin
     *
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Admin $admin): RedirectResponse {
        $this->validate($request, [
            'name' => 'required|min:2',
        ]);

        $admin->name = $request->input('name');
        $admin->save();

        $admin->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.administrator.index')
            ->with('status', 'Update Success');
    }
}
