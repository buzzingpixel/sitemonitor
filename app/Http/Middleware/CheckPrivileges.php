<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\User;

/**
 * Class CheckPrivileges
 */
class CheckPrivileges
{
    /** @var User $currentUser */
    private $currentUser;

    /**
     * CheckPrivileges constructor
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        /** @var User $currentUser */
        $this->currentUser = $auth->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the user is not an admin, show the noaccess view
        if (! $this->currentUser->is_admin) {
            return redirect('noaccess');
        }

        // Since the user is an admin, we can continue with the request
        return $next($request);
    }
}
