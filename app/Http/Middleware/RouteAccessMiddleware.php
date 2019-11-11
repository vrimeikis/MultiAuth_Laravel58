<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\RouteAccessManagerService;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteAccessMiddleware
 *
 * @package App\Http\Middleware
 */
class RouteAccessMiddleware
{
    const ALIAS = 'admin-route-middleware';

    /**
     * @var RouteAccessManagerService
     */
    private $routeAccessManagerService;

    /**
     * RouteAccessMiddleware constructor.
     *
     * @param RouteAccessManagerService $routeAccessManagerService
     */
    public function __construct(RouteAccessManagerService $routeAccessManagerService) {
        $this->routeAccessManagerService = $routeAccessManagerService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($this->shouldBlockAccess()) {
            return redirect()->route('admin.home')
                ->with('danger', 'You have not access to this route!');
        }

        return $next($request);
    }

    /**
     * @return bool
     */
    private function shouldBlockAccess(): bool {
        return Auth::check() &&
            !$this->routeAccessManagerService->accessAllowed(
                Auth::user(),
                (string)Arr::get(Route::current()->action, 'as')
            );
    }
}
