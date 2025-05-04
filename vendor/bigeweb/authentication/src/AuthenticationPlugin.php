<?php

namespace Bigeweb\Authentication;

use Composer\Plugin\PluginInterface;
use Composer\Composer;
use Composer\IO\IOInterface;

class AuthenticationPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        //$io->write("Bigeweb Authentication Plugin Activated!");
        // Your activation logic here
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        //$io->write("Bigeweb Authentication Plugin Deactivated!");
        // Logic to handle deactivation if needed
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        //$io->write("Bigeweb Authentication Plugin Uninstalled!");
        // Logic to clean up or remove resources if needed
    }
}
