<?php namespace AbuseIO\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {

            if ($request->user()->can($permission)) {

                return $next($request);
            }
        }

        $request->session()->flash(
            'message',
            "Sorry! You are not authorized to access that resource. Missing permission : {$permission}"
        );
        return $request->ajax ? response('Unauthorized.', 401) : redirect()->back();

    }
}
