<?php namespace KSV\Services\Models;

use Model;
/**
 * Category Model
 */
class Category extends Model
{

    /**
     * @var string table associated with the model
     */
    public $table = 'ksv_services_categories';

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // sitemap.xml
    public static function getMenuTypeInfo( $type ) {
        $theme = \Cms\Classes\Theme::getActiveTheme();
        $result = [
            'dynamicItems' => false,
            'cmsPages'  => \Cms\Classes\Page::listInTheme( $theme, true ),
        ];
    
        return $result;
    }
    
    public static function resolveMenuItem( $item, $url, $theme ) {
        if ( !$item->cmsPage )
        return;
    
        $result = [ 'items' => [] ];
        $rows = self::get();
    
        foreach ( $rows as $row ) {
        $new_item = [
            'title' => $row->name,
            'url' => \Cms\Classes\Page::url( $item->cmsPage, [ 'category' => $row->slug ] ),
            'mtime' => $row->updated_at,
        ];
        
        trace_log($item->cmsPage);

        $result[ 'items' ][] = $new_item;
        }
    
        return $result;
    }
    // sitemap.xml
}
