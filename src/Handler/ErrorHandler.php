<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Handler;

use Ares\Framework\Exception\BaseException;
use Ares\Framework\Interfaces\CustomResponseInterface;
use Ares\Framework\Model\CustomResponse as CustomResponse;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

/**
 * Class ErrorHandler
 *
 * @package Ares\Framework\Handler
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @var CustomResponse
     */
    private CustomResponse $customResponse;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ErrorHandler constructor.
     *
     * @param ResponseFactoryInterface $responseFactory
     * @param CustomResponse           $customResponse
     * @param LoggerInterface          $logger
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        CustomResponse $customResponse,
        LoggerInterface $logger
    ) {
        $this->responseFactory = $responseFactory;
        $this->customResponse = $customResponse;
        $this->logger = $logger;
    }

    /**
     * Catches exception and returns it in json format.
     *
     * @param ServerRequestInterface $request
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $statusCode = $exception->getCode() ?: 500;

        $customResponse = response()
            ->setStatus('error')
            ->setCode($statusCode)
            ->setException(get_class($exception));

        $this->addErrors($customResponse, $exception);

        $response = $this->responseFactory->createResponse();
        $response->getBody()->write($customResponse->getJson());

        try {
            $response = $response->withStatus($exception->getCode());
        } catch (\Exception $exception) {
            $response = $response->withStatus(500);
        }

        /** @var \Exception $exception */
        $this->logger->error($exception);

        return $this->withCorsHeader($request, $response);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    private function withCorsHeader(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        return $response
            ->withHeader('Access-Control-Allow-Origin', $_ENV['WEB_FRONTEND_LINK'])
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader("Content-Type", "application/problem+json");
    }

    /**
     * @param CustomResponseInterface $customResponse
     * @param Throwable $exception
     * @return CustomResponseInterface
     */
    private function addErrors(CustomResponseInterface $customResponse, Throwable $exception): CustomResponseInterface
    {
        if (!$exception instanceof BaseException) {
            return $customResponse->addError([
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);
        }

        $errors = $exception->getErrors();

        if (!$errors) {
            return $customResponse->addError([
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString()
            ]);
        }

        foreach ($errors as $error) {
            $customResponse->addError($error);
        }

        return $customResponse;
    }
}
