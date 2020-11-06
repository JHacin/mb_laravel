<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Tests\Utilities\TestData\TestUserAdmin;
use Tests\Utilities\TestData\TestUserAuthenticated;
use Tests\Utilities\TestData\TestUserEditor;
use Tests\Utilities\TestData\TestUserSuperAdmin;

/**
 * Class UserSeeder
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        $this->createOneSuperAdmin();
        $this->createOneAdmin();
        $this->createOneEditor();
        $this->createOneAuthenticated();
    }

    protected function createOneSuperAdmin()
    {
        /** @var User $user */
        $user = User::factory()->createOne([
            'email' => TestUserSuperAdmin::getEmail(),
            'password' => User::generateSecurePassword(TestUserSuperAdmin::getPassword()),
        ]);
        $user->assignRole(User::ROLE_SUPER_ADMIN);
    }

    protected function createOneAdmin()
    {
        /** @var User $user */
        $user = User::factory()->createOne([
            'email' => TestUserAdmin::getEmail(),
            'password' => User::generateSecurePassword(TestUserAdmin::getPassword()),
        ]);
        $user->assignRole(User::ROLE_ADMIN);
    }

    protected function createOneEditor()
    {
        /** @var User $user */
        $user = User::factory()->createOne([
            'email' => TestUserEditor::getEmail(),
            'password' => User::generateSecurePassword(TestUserEditor::getPassword()),
        ]);
        $user->assignRole(User::ROLE_EDITOR);
    }

    protected function createOneAuthenticated()
    {
        /** @var User $user */
        User::factory()->createOne([
            'email' => TestUserAuthenticated::getEmail(),
            'password' => User::generateSecurePassword(TestUserAuthenticated::getPassword()),
        ]);
    }
}
