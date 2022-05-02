<?php namespace KSV\ThemeBlocks;

use Backend;
use System\Classes\PluginBase;
use KSV\ThemeBlocks\Classes\Events\ExtendThemeForm;
use KSV\ThemeBlocks\Classes\Twig\Filters;
use Event;

class Plugin extends PluginBase {
    public function pluginDetails() {
        return [
            'name'        => 'ThemeBlocks',
            'description' => 'Плагин для добавления на страницу контентных блоков',
            'author'      => 'KSV',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot() {
        Event::subscribe(ExtendThemeForm::class);
    }

    public function registerMarkupTags() {
        return [
            'functions' => [
                'get_theme_block' => [ Filters::class, 'getThemeBlock' ],
            ]
        ];
    }
}
