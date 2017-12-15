<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fredmz\Generator;

/**
 * Description of FileGenerator
 *
 * @author fmartinez
 */
class FileGenerator {
    static function createFile($file, $content) {
        $classFile = fopen($file, "w");
        fwrite($classFile, $content);
        fclose($classFile);
        
        $fileContent = file_get_contents($file);
        $fileContent = str_replace("<", "&#60;", $fileContent);
        $fileContent = str_replace(">", "&#62;", $fileContent);
        $html = '<div class="code">';
        $html.= $fileContent;
        $html.= '</div>';
        echo $html;
    }
}
