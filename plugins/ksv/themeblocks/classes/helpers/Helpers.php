<?php namespace KSV\ThemeBlocks\Classes\Helpers;

use Cms\Classes\Theme;

class Helpers {
    public static function preparedBlocksOptions() {
        $theme = Theme::getActiveTheme();
        $themeData = $theme->getCustomData();
        $themeSettings = json_decode( $themeData->ksv_theme_blocks ?? json_encode([]) );

        $arr = [ 'empty' => '- не задано -' ];

        foreach ( $themeSettings as $item ) {
            $arr[ $item->id ] = $item->title;
        }

        return $arr;
    }

    public static function generateHahs( $length = 5 ){
        $characters			= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters			= md5(time().rand());
        $charactersLength	= strlen( $characters );
        if ( $length > $charactersLength ) $length = $charactersLength;
        $randomString		= '';

        for ( $i = 0; $i < $length; $i++ ) {
            $randomString	.= $characters[ rand( 0, $charactersLength - 1 ) ];
        }

        return mb_substr( md5( $randomString ), 0, $length );
    }
};