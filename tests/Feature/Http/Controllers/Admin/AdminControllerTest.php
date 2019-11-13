<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Admin;
use App\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group administrator
     */
    public function testFailSeeAdministratorIndexPage(): void {
        $this->get(route('admin.administrator.index'))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.login');
    }

    /**
     * @group administrator
     */
    public function testSuccessSeeAdministratorIndexPageByFullAccess(): void {
        /** @var Role $role */
        $role = factory(Role::class)->create([
            'full_access' => true,
        ]);

        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();
        $admin->roles()->sync([$role->id]);

        $this->actingAs($admin, 'admin');

        $this->visitRoute('admin.administrator.index')
            ->assertResponseOk()
            ->see('Admins')
            ->see($admin->email)
            ->see('Edit');
    }

    /**
     * @group administrator
     */
    public function testSuccessSeeAdministratorIndexPageByRolePermissions(): void {
        /** @var Role $role */
        $role = factory(Role::class)->create([
            'accessible_routes' => ['admin.administrator.index'],
        ]);

        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();
        $admin->roles()->sync([$role->id]);

        $this->actingAs($admin, 'admin');

        $this->visitRoute('admin.administrator.index')
            ->assertResponseOk()
            ->see('Admins')
            ->see($admin->email)
            ->dontSee('Edit');
    }

    /**
     * @group administrator
     */
    public function testFailSeeAdministratorEditPage(): void {
        $adminId = mt_rand(1, 10);

        $this->get(route('admin.administrator.edit', ['admin' => $adminId]))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.login');
    }

    /**
     * @group administrator
     */
    public function testFailSeeAdministratorEditPageWithoutPermission(): void {
        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();

        $this->actingAs($admin, 'admin');

        $this->get(route('admin.administrator.edit', ['admin' => $admin->id]))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.home');
    }

    /**
     * @group administrator
     */
    public function testSuccessSeeAdministratorEditPageWithPermission(): void {
        /** @var Role $role */
        $role = factory(Role::class)->create([
            'full_access' => true,
        ]);
        /** @var Role $roleAnother */
        $roleAnother = factory(Role::class)->create();

        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();
        $admin->roles()->sync([$role->id]);

        $this->actingAs($admin, 'admin');

        $this->visitRoute('admin.administrator.edit', ['admin' => $admin->id])
            ->assertResponseOk()
            ->see('Admin edit')
            ->see($admin->name)
            ->see($role->name)
            ->see($roleAnother->name);
    }

    /**
     * @group administrator
     */
    public function testFailAccessToAdministratorUpdateRoute(): void {
        $adminId = mt_rand(1, 10);
        $this->put(route('admin.administrator.update', ['admin' => $adminId]))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.login');
    }

    /**
     * @group administrator
     */
    public function testFailAccessToAdministratorUpdateWithoutPermissions(): void {
        /** @var Admin $admin */
        $admin = factory(Admin::class)->create();

        $this->actingAs($admin, 'admin');

        $this->put(route('admin.administrator.update', ['admin' => $admin->id]))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.home');

    }

    /**
     * @group administrator
     */
    public function testSuccessUpdateAdministratorData(): void {
        /** @var Role $roleFull */
        $roleFull = factory(Role::class)->create([
            'full_access' => true,
        ]);

        /** @var Collection|Role[] $roleCollectionNotFull */
        $roleCollectionNotFull = factory(Role::class, 3)->create();

        /** @var Admin $adminOne */
        $adminOne = factory(Admin::class)->create();
        $adminOne->roles()->sync([$roleFull->id]);

        /** @var Admin $adminTwo */
        $adminTwo = factory(Admin::class)->create([
            'name' => 'John',
        ]);

        $this->actingAs($adminOne, 'admin');

        $this->put(
            route('admin.administrator.update', ['admin' => $adminTwo->id]),
            [
                'name' => 'Peter',
                'roles' => $roleCollectionNotFull->pluck('id'),
            ]
        )
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.administrator.index');

        $this->seeInDatabase('admins', [
            'id' => $adminTwo->id,
            'name' => 'Peter'
        ]);

        foreach ($roleCollectionNotFull as $role) {
            $this->seeInDatabase('admin_role', [
                'admin_id' => $adminTwo->id,
                'role_id' => $role->id
            ]);
        }

        $this->dontSeeInDatabase('admin_role', [
            'admin_id' => $adminTwo->id,
            'role_id' => $roleFull->id,
        ]);
    }
}
