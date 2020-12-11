<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see       LICENSE (MIT)
 */

namespace Ares\Framework\Command;

use Predis\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearCacheCommand
 *
 * @package Ares\Framework\Command
 */
class ClearCacheCommand extends Command
{
    /** @var string */
    private const COMMAND_NAME = 'ares:clear-cache';

    /** @var string */
    private const TMP_PATH = 'tmp';

    /** @var string */
    private const CACHE_TYPE = 'Predis';

    /**
     * ClearCacheCommand constructor.
     *
     * @param Client $client
     */
    public function __construct(
        private Client $client
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Clears the application cache');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->deleteCache(self::TMP_PATH);
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return 1;
        }

        $output->writeln('<info>Application cache successfully cleared</info>');

        return 0;
    }

    /**
     * Deletes the cache recursive
     *
     * @param $dir
     *
     * @return bool
     */
    private function deleteCache($dir): bool
    {
        if ($_ENV['CACHE_TYPE'] == self::CACHE_TYPE) {
            $this->client->flushall();
            return true;
        }

        if (is_dir($dir)) {
            array_map([$this, 'deleteDir'], glob($dir . DIRECTORY_SEPARATOR . '{,.[!.]}*', GLOB_BRACE));
            return @rmdir($dir);
        }

        return @unlink($dir);
    }
}
