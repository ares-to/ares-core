<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Provider;

use Ares\Framework\Helper\LocaleHelper;
use Ares\Framework\Model\Locale;
use League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class LocaleServiceProvider
 *
 * @package Ares\Framework\Provider
 */
class LocaleServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        Locale::class
    ];

    /**
     * Registers new service.
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Locale::class, function () {
            $localeHelper = new LocaleHelper();
            return new Locale($localeHelper);
        });
    }
}
