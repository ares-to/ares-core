<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Service;

use Ares\Framework\Model\Locale;

/**
 * Class LocaleService
 *
 * @package Ares\Framework\Service
 */
class LocaleService
{
    /**
     * @var Locale
     */
    private Locale $locale;

    /**
     * LocaleService constructor.
     *
     * @param Locale $locale
     */
    public function __construct(
        Locale $locale
    ) {
        $this->locale = $locale;
    }

    /**
     * Takes message and placeholder to translate them in given locale.
     *
     * @param string $key
     * @param array  $placeholder
     * @return string
     */
    public function translate(string $key, array $placeholder = []): string
    {
        $message = $this->locale->translate($key);

        if (!$placeholder) {
            return $message;
        }

        return vsprintf($message, $placeholder);
    }
}
