<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Command;

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
            $isRemoved = rmdir(tmp_dir());

            if (!$isRemoved) {
                throw new \Exception('Cache directory could not be deleted, check rights or error log');
            }
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return 1;
        }

        $output->writeln('<info>Application cache successfully cleared</info>');

        return 0;
    }
}
