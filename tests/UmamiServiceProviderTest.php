<?php

use JeffersonGoncalves\Umami\Settings\UmamiSettings;
use JeffersonGoncalves\Umami\UmamiServiceProvider;

it('adds UmamiSettings to the settings.settings config without removing application settings', function () {
    // simulate an application that already defined some settings
    $this->app['config']->set('settings.settings', [
        'App\\Settings\\CustomSetting',
    ]);

    // re-run the provider registration step that merges the config
    $provider = $this->app->getProvider(UmamiServiceProvider::class);
    $provider->packageRegistered();

    $settings = $this->app['config']->get('settings.settings');

    expect($settings)->toBeArray()
        ->toEqual([UmamiSettings::class, 'App\\Settings\\CustomSetting']);
});

it('adds UmamiSettings when no application settings are present', function () {
    $this->app['config']->set('settings.settings', []);

    $provider = $this->app->getProvider(UmamiServiceProvider::class);
    $provider->packageRegistered();

    $settings = $this->app['config']->get('settings.settings');

    expect($settings)->toBeArray()
        ->toEqual([UmamiSettings::class]);
});
