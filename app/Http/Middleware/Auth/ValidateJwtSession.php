<?php

declare(strict_types=1);

namespace App\Http\Middleware\Auth;

use App\Repositories\Jwt\Contracts\JwtSessionRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ValidateJwtSession
{
    private JwtSessionRepository $sessionRepository;

    public function __construct(JwtSessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payload = Auth::payload();
        $tokenId = $payload->get('jti');

        $session = $this->sessionRepository->getSessionByTokenId($tokenId);

        if (!$session) {
            throw new UnauthorizedException('Sessão inválida');
        }

        if ($session->ip_address !== $request->ip()) {
            $this->sessionRepository->deleteSession($session->token_id);

            Auth::logout();

            // Notificar usuário
//            Mail::to($session->user)->send("Foi identificado um novo login na sua conta, Por segurança, faça login novamente.");

            throw new UnauthorizedException('IP alterado. Por segurança, faça login novamente.');
        }

        $session->update(['last_activity' => now()]);

        return $next($request);
    }
}
