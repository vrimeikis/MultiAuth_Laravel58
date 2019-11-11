<?php

declare(strict_types = 1);

namespace App\Services;

use App\Admin;
use App\Role;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class RouteAccessManagerService
{
    /**
     * @return array
     */
    public function getManagementRoutes(): array {
        $routes = collect(Route::getRoutes());

        return $routes->filter(function(RoutingRoute $route) {
            return in_array('auth:admin', $route->gatherMiddleware());
        })->map(function(RoutingRoute $route) {
            return $route->getName();
        })->toArray();
    }

    /**
     * @param Authenticatable|Admin $user
     * @param string $routeName
     *
     * @return bool
     */
    public function accessAllowed(Authenticatable $user, string $routeName): bool {
        /** @var Collection|Role[] $roles */
        $roles = $user->roles()->get();

        if ($roles->contains('full_access', true)) {
            return true;
        }

        return $roles->flatMap(function(Role $role) {
            return $role->accessible_routes;
        })->contains($routeName);
    }
}