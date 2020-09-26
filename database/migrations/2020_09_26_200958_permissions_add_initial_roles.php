<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class PermissionsAddInitialRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create(['name' => User::ROLE_SUPER_ADMIN, 'label' => 'Super Administrator']);
        Role::create(['name' => User::ROLE_ADMIN, 'label' => 'Administrator']);
        Role::create(['name' => User::ROLE_EDITOR, 'label' => 'Urednik']);
        Role::create(['name' => User::ROLE_AUTHENTICATED, 'label' => 'Uporabnik']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Role::findByName(User::ROLE_SUPER_ADMIN)->delete();
        Role::findByName(User::ROLE_ADMIN)->delete();
        Role::findByName(User::ROLE_EDITOR)->delete();
        Role::findByName(User::ROLE_AUTHENTICATED)->delete();
    }
}
