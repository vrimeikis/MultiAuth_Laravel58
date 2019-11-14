<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Services\RouteAccessManagerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * @var RouteAccessManagerService
     */
    private $routeAccessManagerService;

    /**
     * RoleController constructor.
     *
     * @param RouteAccessManagerService $routeAccessManagerService
     */
    public function __construct(RouteAccessManagerService $routeAccessManagerService) {
        $this->routeAccessManagerService = $routeAccessManagerService;
    }

    public function index(): View {
        $roles = Role::query()->paginate();

        return view('admin.role.list', [
            'roles' => $roles,
        ]);
    }

    public function edit(Role $role): View {
        $filteredRoutes = $this->routeAccessManagerService->getManagementRoutes();

        return view('admin.role.edit', [
            'role' => $role,
            'routes' => $filteredRoutes,
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
        $role->accessible_routes = $request->input('accessible_routes', []);
        $role->description = $request->input('description');
        $role->save();

        return redirect()->route('admin.role.index')
            ->with('status', 'Updated success!');
    }
}
