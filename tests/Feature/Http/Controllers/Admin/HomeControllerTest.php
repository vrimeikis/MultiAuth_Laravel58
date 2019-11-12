<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Admin;
use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class HomeControllerTest
 *
 * @package Tests\Feature\Http\Controllers\Admin
 */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group admin
     */
    public function testFailRetrieveAdminHomepageWhenNotLoggedIn(): void {
        $this->get(route('admin.home'))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.login');
    }

    /**
     * @group admin
     */
    public function testFailRetrieveAdminHomePageWhenLoggedInAsCustomer(): void {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $this->get(route('admin.home'))
            ->assertResponseStatus(Response::HTTP_FOUND)
            ->assertRedirectedToRoute('admin.login')
            ->dontSee('Dashboard');
    }

    /**
     * @group admin
     * @group admin_success
     */
    public function testSuccessRetrieveAdminHomepage(): void {
        $admin = factory(Admin::class)->create();

        $this->actingAs($admin, 'admin');
        $this->get(route('admin.home'))
            ->assertResponseOk()
            ->see('Dashboard');
    }
}
