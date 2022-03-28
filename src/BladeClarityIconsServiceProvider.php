<?php

declare(strict_types=1);

namespace Codeat3\BladeClarityIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeClarityIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-clarity-icons', []);

            $factory->add('clarity', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-clarity-icons.php', 'blade-clarity-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-clarity-icons'),
            ], 'blade-clarity-icons');

            $this->publishes([
                __DIR__ . '/../config/blade-clarity-icons.php' => $this->app->configPath('blade-clarity-icons.php'),
            ], 'blade-clarity-icons-config');
        }
    }
}
