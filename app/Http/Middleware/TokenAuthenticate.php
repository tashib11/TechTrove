<?php
namespace App\Http\Middleware;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWTToken::ReadToken($token);

        if ($result === null) {
            if ($request->expectsJson()) {
        return ResponseHelper::Out('unauthorized', null, 401); // For fetch() requests -> expect json output
    } else {
        return redirect('/login'); // <a href="/xyz"> expects html page
    }
        } else {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userID);
            //controllers can access request()->header('id') or request()->header('role').-+'?
            if (isset($result->role)) {
                $request->headers->set('role', $result->role);
            }
            return $next($request);//. Middleware allows request to go to controller:
        }
    }
}
