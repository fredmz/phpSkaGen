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
        $arrFile = explode('.', $file);
        $ext = $arrFile[count($arrFile) - 1];
        $languages = [
            'kt' => 'kotlin',
            'js' => 'javascript',
            'ts' => 'typescript',
            'html' => 'html',
            'css' => 'css'
        ];

        $fileContent = file_get_contents($file);
        $fileContent = str_replace("<", "&#60;", $fileContent);
        $fileContent = str_replace(">", "&#62;", $fileContent);
        $html = '<pre><code class="language-'.$languages[$ext].'">';
        $html.= $fileContent;
        $html.= '</code></pre>';
        echo $html;
    }

    static function renderFile(string $file, array $data) {
        $fileContent = file_get_contents($file);
        foreach ($data as $key => $value) {
            $fileContent = str_replace('{{'.$key.'}}', $value, $fileContent);
        }
        return $fileContent;
    }
}
