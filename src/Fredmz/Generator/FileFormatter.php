<?php
namespace Fredmz\Generator;

/**
 * Description of FileFormatter
 *
 * @author fmartinez
 */
class FileFormatter {
    static function fromCamelCaseToUnderline(string $input){ 
        if ( preg_match ( '/[A-Z]/', $input ) === 0 ) {
            return $input;
        }
        $pattern = '/([a-z])([A-Z])/';
        $r = strtolower ( preg_replace_callback ( $pattern, function ($a) {
            return $a[1] . "_" . strtolower ( $a[2] ); 
        }, $input ) );
        return $r;
    }

    static function fromCamelCaseToHyphen(string $input){ 
        if ( preg_match ( '/[A-Z]/', $input ) === 0 ) {
            return $input;
        }
        $pattern = '/([a-z])([A-Z])/';
        $r = strtolower ( preg_replace_callback ( $pattern, function ($a) {
            return $a[1] . "-" . strtolower ( $a[2] ); 
        }, $input ) );
        return $r;
    }
}
