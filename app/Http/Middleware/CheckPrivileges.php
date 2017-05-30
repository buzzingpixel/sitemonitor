<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
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
     * @param Request $request
     * @param Closure $next
     * @param string $section
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $section)
    {
        // If the user is not an admin, show the noaccess view
        if (! $this->currentUser->{"access_{$section}"}) {
            return redirect('noaccess');
        }

        // Since the user is an admin, we can continue with the request
        return $next($request);
    }
}
