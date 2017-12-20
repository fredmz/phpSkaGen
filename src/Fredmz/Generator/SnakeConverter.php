<?php
namespace Fredmz\Generator;

/**
 * Description of SnakeConverter
 *
 * @author fmartinez
 */
class SnakeConverter {
    static function fromCamelCase(string $input){ 
        if ( preg_match ( '/[A-Z]/', $input ) === 0 ) {
            return $input;
        }
        $pattern = '/([a-z])([A-Z])/';
        $r = strtolower ( preg_replace_callback ( $pattern, function ($a) {
            return $a[1] . "_" . strtolower ( $a[2] ); 
        }, $input ) );
        return $r;
    }
}
