<?php

namespace FarshidRezaei\LaraLog;

use Illuminate\Support\ServiceProvider;

class LaraLogServiceProvider extends ServiceProvider
{
    protected $helpersPath;

    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    public function register()
    {

        $this->mergeConfig();
        $this->requireHelpers();

    }

    private function mergeConfig()
    {
        $this->mergeConfigFrom( $this->getConfigPath(), 'laralog' );
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes( [
            $path => config_path( 'laralog.php' )
        ], 'config' );
    }

    private function publishMigrations()
    {
        $this->publishes( [
            $this->getMigrationsPath() => database_path( 'migrations' )
        ], 'migrations' );
    }

    private function getConfigPath()
    {
        return __DIR__ . '/Configs/config.php';
    }

    private function getMigrationsPath()
    {
        return __DIR__ . '/Migrations';
    }

    protected function setHelpersPath()
    {
        $this->helpersPath = __DIR__ . '/Helpers/helpers.php';
    }

    protected function requireHelpers()
    {
        $this->setHelpersPath();
        require_once "$this->helpersPath";
    }
}