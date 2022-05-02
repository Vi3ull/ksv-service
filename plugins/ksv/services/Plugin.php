<?php namespace KSV\Services;

use Backend;
use System\Classes\PluginBase;

use KSV\Services\Models\Category as CategoryModel;

/**
 * Services Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['ReaZzon.Editor'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Services',
            'description' => 'Управление услугами компании',
            'author'      => 'KSV',
            'icon'        => 'icon-leaf'
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
    public function boot() {
        // sitemap.xml
        $typeName = 'Категория услуг';
        $typeTitle = 'Каталог услуг';
        
        \Event::listen( 'pages.menuitem.listTypes', function() use ( $typeName, $typeTitle ) {
            return [ $typeName => $typeTitle ];
        });
        
        \Event::listen( 'pages.menuitem.getTypeInfo', function( $type ) use ( $typeName ) {
            if ( $type == $typeName ) {
            return CategoryModel::getMenuTypeInfo( $type );
            }
        });
        
        \Event::listen( 'pages.menuitem.resolveItem', function( $type, $item, $url, $theme ) use ( $typeName ) {
            if ($type == $typeName) {
            return CategoryModel::resolveMenuItem( $item, $url, $theme );
            }
        });
        // end sitemap.xml
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'KSV\Services\Components\Category' => 'ServicesCategory',
            'KSV\Services\Components\Item' => 'ServicesItem'
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
            'ksv.services.some_permission' => [
                'tab' => 'Services',
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
            'services' => [
                'label'       => 'Услуги',
                'url'         => Backend::url('ksv/services/items'),
                'icon'        => 'icon-leaf',
                'iconSvg'     => 'plugins/ksv/services/assets/images/plugin-icon.svg',
                'permissions' => ['ksv.services.*'],
                'order'       => 500,

                'sideMenu' => [
                    'items' => [
                        'label'         => 'Услуги',
                        'url'           => Backend::url('ksv/services/items'),
                        'icon'          => 'icon-leaf',
                        'permissions'   => ['ksv.services.*'],
                        'order'         => 500,
                    ],
                    'categories' => [
                        'label'         => 'Категории',
                        'url'           => Backend::url('ksv/services/categories'),
                        'icon'          => 'icon-leaf',
                        'permissions'   => ['ksv.services.*'],
                        'order'         => 500,
                    ],
                    
                ]
            ],
        ];
    }
}
