<?php

namespace App\Http\Middleware;

use App\Http\Resources\BaseResource;
use Closure;
use Exception;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JwtMiddleware
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
        $token = $request->header('token');
        if (!$token) {
            return new BaseResource(401, '用户未登录');
        } else {
            try {
                $parser = (new Parser())->parse($token);
                if (!$parser->verify(new Sha256(), config('app.jwt.secret'))) {
                    return new BaseResource(400, 'Token错误，别闹了');
                }
                if ($parser->isExpired()) {
                    return new BaseResource(401, '登录信息已过期，请重新登录');
                }
                $request->user_id = $parser->getClaim('id');
            } catch (Exception $e) {
                return new BaseResource(400, 'Token错误，别闹了');
            }
        }
        return $next($request);
    }
}
