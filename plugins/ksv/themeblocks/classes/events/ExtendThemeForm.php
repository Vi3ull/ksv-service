<?php namespace KSV\ThemeBlocks\Classes\Events;

use Event;
use Yaml;
use File;
use KSV\ThemeBlocks\Classes\Helpers\Helpers;

class ExtendThemeForm {
    public function subscribe() {
        Event::listen('backend.form.extendFields', function($widget) {
            if ( !$widget->model instanceof \Cms\Models\ThemeData ) {
                return;
            }

            $model = $widget->model;
            $model->addJsonable( 'ksv_theme_blocks' );

            $model->bindEvent( 'model.beforeSave', function() use ( $model ) {
                $arr	= $model->ksv_theme_blocks;

                if( !$arr )
                    return;

                foreach( $model->ksv_theme_blocks as $key=>$item ) {
                    if( $item[ 'id' ] == '' )
                        $arr[ $key ][ 'id' ] = Helpers::generateHahs(7);
                }

                $model->ksv_theme_blocks = $arr;
            });

            if ( $widget->isNested )
                return;

            $fieldsConfigPath = plugins_path('ksv/themeblocks/config/theme-fields.yaml');
            $fieldsConfig = Yaml::parse( File::get( $fieldsConfigPath ) );
            $widget->addTabFields( $fieldsConfig );
        });
    }
}