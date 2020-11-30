<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\User;

class AdminUserEditPage extends Page
{
    /**
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return str_replace('{id}', $this->user->id, $this->prefixUrl(config('routes.admin.users_edit')));
    }
}
