<?php

declare(strict_types = 1);

use App\Admin;
use App\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class FirstAdminSeeder
 */
class FirstAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roleId = $this->createRole(
            'Super admin',
            [],
            'Has full access to all routes',
            true
        );
        $this->createRole('Moderator');

        $admin = $this->createAdmin(
            'admin@admin.com',
            'secret',
            'Admin'
        );
        $admin->roles()->sync([$roleId]);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $name
     *
     * @return Admin|Model
     */
    private function createAdmin(string $email, string $password, string $name = ''): Admin {
        return Admin::query()
            ->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
    }

    /**
     * @param string $name
     * @param array $accessibleRoutes
     * @param string|null $description
     * @param bool $fullAccess
     *
     * @return int
     */
    private function createRole(
        string $name,
        array $accessibleRoutes = [],
        ?string $description = null,
        bool $fullAccess = false
    ): int {
        $role = Role::query()->create([
            'name' => $name,
            'full_access' => $fullAccess,
            'accessible_routes' => $accessibleRoutes,
            'description' => $description,
        ]);

        return $role->id;
    }
}
