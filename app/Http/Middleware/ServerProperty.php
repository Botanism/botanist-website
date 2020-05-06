<?php


namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Server;
use Closure;


class ServerProperty
{
    public function handle ($request, Closure $next) {
        $server = (new Server())->where('id', $request->id);

        if($server->doesntExist()) return redirect(route('servers'));

        $ownerId = $server->first()->user_id;


        if ($ownerId != Auth::id()) {
            return redirect(route('servers'));
        }

        return $next($request);
    }
}