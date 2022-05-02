<?php namespace KSV\ThemeBlocks\Classes\Twig;

use Cms\Classes\Theme;

class Filters {
    private static function searchBlock( $arr, $blockId ) {
        foreach ( $arr as $val ) {
            if ( $val->id === $blockId) {
                return $val;
            }
        }
        return null;
    }

    public static function getBlockData( $blockId ) {
        $theme = Theme::getActiveTheme();
        $themeData = $theme->getCustomData();
        $themeBlocks = json_decode( $themeData->ksv_theme_blocks ?? json_encode([]) );

        $block = self::searchBlock( $themeBlocks, $blockId );
        if( $block === null )
            return null;

        return $block->type;
    }

    public static function getThemeBlock( $blockId ) {
        return self::getBlockData( $blockId );
    }
}