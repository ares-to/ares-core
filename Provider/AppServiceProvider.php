<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Provider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Slim\App;
use Slim\Factory\AppFactory;

/**
 * Class AppServiceProvider
 *
 * @package Ares\Framework\Provider
 */
class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string[]
     */
    protected $provides = [
        App::class
    ];

    /**
     * Registers new service.
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->add(App::class, function () use ($container) {
            AppFactory::setContainer($container);

            return AppFactory::create();
        });
    }
}
