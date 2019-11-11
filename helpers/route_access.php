<?php

declare(strict_types = 1);

use App\Services\RouteAccessManagerService;
use Illuminate\Support\Facades\Auth;

/**
 * @param string $routeName
 *
 * @return bool
 */
function can_access(string $routeName): bool {
    /** @var RouteAccessManagerService $manager */
    $manager = app(RouteAccessManagerService::class);

    return $manager->accessAllowed(Auth::user(), $routeName);
}

/**
 * @param array $routeNamesArray
 *
 * @return bool
 */
function can_access_any(array $routeNamesArray): bool {
    /** @var RouteAccessManagerService $manager */
    $manager = app(RouteAccessManagerService::class);
    $user = Auth::user();

    foreach ($routeNamesArray as $routeName) {
        if ($manager->accessAllowed($user, $routeName)) {
            return true;
        }
    }

    return false;
}