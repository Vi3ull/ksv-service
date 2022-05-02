<?php namespace KSV\Form;

use Backend;
use System\Classes\PluginBase;

/**
 * Form Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Form',
            'description' => 'Форма обратной связи',
            'author'      => 'KSV',
            'icon'        => 'icon-check-square'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'KSV\Form\Components\Feedback' => 'Feedback',
            'KSV\Form\Components\Callback' => 'Callback',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'ksv.form.some_permission' => [
                'tab' => 'Form',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'form' => [
                'label'       => 'Обратная связь',
                'url'         => Backend::url('ksv/form/feedbacks'),
                'icon'        => 'icon-check-square',
                'permissions' => ['ksv.form.*'],
                'order'       => 500,
                'sideMenu' => [
                    'feedback' => [
                        'label'       => 'Обратная связь',
                        'url'         => Backend::url('ksv/form/feedbacks'),
                        'icon'        => 'icon-question-circle-o',
                        'permissions' => ['ksv.form.*'],
                        'order'       => 500,
                    ],
                    'callback' => [
                        'label'       => 'Обратный звонок',
                        'url'         => Backend::url('ksv/form/callbacks'),
                        'icon'        => 'icon-volume-control-phone',
                        'permissions' => ['ksv.form.*'],
                        'order'       => 500,
                    ]
                ]
            ],
        ];
    }
}
