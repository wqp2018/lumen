<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/30
 * Time: 10:50
 */

namespace App\Http\Middleware;

use App\Http\Tool\Result;
use Closure;
use Illuminate\Http\Request;

class AdminGuard{

    public function handle(Request $request, Closure $next){

        return $next($request);
    }
}