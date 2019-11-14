<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Admin;
use App\Role;
use App\Services\RouteAccessManagerService;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group role
     */
    public function testSuccessSeeRoleEditPage(): void {
        $mockService = Mockery::mock(RouteAccessManagerService::class, function(Mockery\MockInterface $mock) {
            $mock->shouldReceive('accessAllowed')
                ->andReturn(true);
            $mock->shouldReceive('getManagementRoutes')
                ->once()
                ->andReturn([
                    'admin.test.index',
                    'admin.test.update',
                ]);
        })->makePartial();

        $this->instance(RouteAccessManagerService::class, $mockService);

        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();

        /** @var Role $role */
        $role = factory(Role::class)->create();

        $this->actingAs($admin, 'admin');

        $this->get(route('admin.role.edit', ['role' => $role->id]))
            ->assertResponseOk()
            ->see('admin.test.index')
            ->dontSee('admin.role.index');
    }
}
