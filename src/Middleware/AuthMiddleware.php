<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Middleware;

use Ares\Framework\Exception\AuthenticationException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReallySimpleJWT\Token;

/**
 * JWT Auth middleware.
 *
 * @package Ares\Framework\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * Auth constructor.
     *
     * @param   ResponseFactoryInterface  $responseFactory
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Process an incoming server request.
     *
     * @param   ServerRequestInterface   $request  The request
     * @param   RequestHandlerInterface  $handler  The handler
     *
     * @return ResponseInterface The response
     * @throws AuthenticationException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $token = explode(' ', (string) $request->getHeaderLine('Authorization'))[1] ?? '';

        if (!$token || !Token::validate($token, $_ENV['TOKEN_SECRET'])) {
            $this->responseFactory
                ->createResponse()
                ->withHeader('Content-Type', 'application/problem+json');

            throw new AuthenticationException(__('You arent allowed to visit this site'), 401);
        }

        return $handler->handle($request);
    }
}
