<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIfAdmin
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        if (!$this->checkIfUserIsAdmin(backpack_user())) {
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }

    /**
     * Answer to unauthorized access request.
     *
     * @param Request $request
     *
     * @return Application|ResponseFactory|RedirectResponse|Response
     */
    private function respondToUnauthorizedRequest(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }

    /**
     * Checked that the logged in user is an administrator.
     *
     * --------------
     * VERY IMPORTANT
     * --------------
     * If you have both regular users and admins inside the same table,
     * change the contents of this method to check that the logged in user
     * is an admin, and not a regular user.
     *
     * @param Authenticatable|User $user
     *
     * @return bool
     */
    private function checkIfUserIsAdmin($user)
    {
        return $user->isAdmin();
    }

}
