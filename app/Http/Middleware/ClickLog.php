<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ClickLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Redis::incr('click1'); //增加点击 1
        Redis::incrby('click2','10'); //增加点击 10
//        echo 'ClickLog';echo "</br>";
        return $next($request);
    }
}
