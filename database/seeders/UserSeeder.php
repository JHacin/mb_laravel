<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $this->createSuperAdmin();
    }

    /**
     * @return void
     */
    protected function createSuperAdmin()
    {
        /** @var User $user */
        $user = User::factory()->createOne([
            'email' => 'test_super_admin@example.com',
            'password' => User::generateSecurePassword('RJWcO3fQQi05')
        ]);

        $user->assignRole(User::ROLE_SUPER_ADMIN);
    }
}
