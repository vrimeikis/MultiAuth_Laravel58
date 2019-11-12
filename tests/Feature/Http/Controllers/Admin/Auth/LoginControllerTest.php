<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers\Admin\Auth;

use App\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group admin_login
     */
    public function testLoginEndPoint(): void {
        $this->get(route('admin.login'))
            ->assertResponseOk()
            ->see('email')
            ->see('password');
    }

    /**
     * @group admin_login
     */
    public function testFailLoginWithEmptyInputs(): void {
        $response = $this->visitRoute('admin.login')
            ->press('Login');
        $response->assertResponseOk()
            ->see('email')
            ->see('password')
            ->dontSee('Dashboard');
    }

    /**
     * @group admin_login
     */
    public function testFailLoginWithNonExistingAdmin(): void {
        $response = $this->visitRoute('admin.login')
            ->type('admin@admin.com', 'email')
            ->type('secret', 'password')
            ->press('Login');

        $response->assertResponseOk()
            ->see('These credentials do not match our records.')
            ->see('email')
            ->see('password')
            ->dontSee('Dashboard');
    }

    /**
     * @group admin_login
     */
    public function testSuccessLogin(): void {
        $password = Str::random();
        $admin = factory(Admin::class)->create([
            'password' => Hash::make($password)
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => $admin->email,
            'password' => $password,
        ]);

        $response->see('<title>Redirecting to ' . route('admin.home') . '</title>');
        $response->seeStatusCode(Response::HTTP_FOUND);
        $response->assertSessionMissing('errors');
    }

    /**
     * @group admin_login
     */
    public function testFailLogout(): void {
        $this->post(route('admin.logout'))
            ->see('<title>Redirecting to ' . route('admin.login') .'</title>')
            ->assertResponseStatus(Response::HTTP_FOUND);
    }

    /**
     * @group admin_login
     */
    public function testSuccessLogout(): void {
        $admin = factory(Admin::class)->create();

        $this->actingAs($admin, 'admin');

        $this->post(route('admin.logout'))
            ->see('<title>Redirecting to ' . route('admin.login') .'</title>')
            ->assertRedirectedToRoute('admin.login')
            ->assertResponseStatus(Response::HTTP_FOUND);

        $this->visitRoute('admin.home')
            ->seePageIs(route('admin.login'));
    }
}
