<?php declare(strict_types=1);
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Service;

use ReallySimpleJWT\Exception\ValidateException;
use ReallySimpleJWT\Token;

/**
 * Class TokenService
 *
 * @package App\Service
 */
class TokenService
{
    /**
     * Creates the JWT - Token and returns it
     *
     * @param $id
     * @return string
     * @throws ValidateException
     */
    public function execute($id): string
    {
        $payload = [
            'iat' => time(),
            'uid' => $id,
            'exp' => time() + $_ENV['TOKEN_DURATION'],
            'iss' => $_ENV['TOKEN_ISSUER']
        ];

        return Token::customPayload($payload, $_ENV['TOKEN_SECRET']);
    }
}
