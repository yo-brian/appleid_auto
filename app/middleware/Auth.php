<?php
declare (strict_types=1);

namespace app\middleware;

use Closure;
use think\facade\Session;

class Auth
{

    public function handle($request, Closure $next)
    {
        // 是否已经登陆
        if (Session::get('user_id')) {
            return redirect("/user/index");
        }
        return $next($request);
    }
}
