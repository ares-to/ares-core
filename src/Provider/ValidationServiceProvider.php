<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Provider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use PHLAK\Config\Config;
use Rakit\Validation\Validator;

/**
 * Class ValidationServiceProvider
 *
 * @package Ares\Framework\Provider
 */
class ValidationServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        Validator::class
    ];

    /**
     * Registers new service.
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(Validator::class, function () use ($container) {
            $config = $container->get(Config::class);
            return new Validator($config->get('api_settings.validation'));
        });
    }
}
