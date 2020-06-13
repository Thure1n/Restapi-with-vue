<?php

namespace App\Http\Middleware;

use Closure;

class Post
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
        $key  = md5('api_key');//39802830831bed188884e193d8465226 =>key
        if(isset($request->key))
        {
            if($request->key == $key)
            {
                return $next($request);
            }
            else
            {
                return response()->json([
                    'status' => '0',
                    'message' => 'Api key was invalid'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status' => '0',
                'message' => 'Api key was not found'
            ]);
        }

    }
}
