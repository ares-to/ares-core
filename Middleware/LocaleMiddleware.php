<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Middleware;

use Ares\Framework\Model\Locale;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class LocaleMiddleware
 *
 * @package Ares\Framework\Middleware
 */
class LocaleMiddleware implements MiddlewareInterface
{
    /** @var string */
    private const FALLBACK_LOCALE = 'en';

    /** @var string */
    private const LOCALE_PATH_KEY = 0;

    /**
     * @var Locale
     */
    private Locale $locale;

    /**
     * LocaleMiddleware constructor.
     *
     * @param Locale $locale
     */
    public function __construct(
        Locale $locale
    ) {
        $this->locale = $locale;
    }

    /**
     * Process an incoming server request.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $locale = $this->getLocale($request);

        $this->locale->setLocale($locale);
        $this->locale->setFallbackLocale(self::FALLBACK_LOCALE);

        return $handler->handle($request);
    }

    /**
     * Returns locale of path.
     *
     * @param ServerRequestInterface $request
     * @return string
     */
    private function getLocale(ServerRequestInterface $request): string
    {
        $path = ltrim($request->getUri()->getPath(), '/');
        $splittedPath = explode('/', $path);

        return $splittedPath[self::LOCALE_PATH_KEY];
    }
}
