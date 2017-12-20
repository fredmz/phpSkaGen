<?php
namespace Fredmz\Generator\Frontend;

/**
 * Description of ImportHandler
 *
 * @author fmartinez
 */
class ImportHandler {
    const ENTER = "\r\n";
    /**
     *
     * @var ImportHelper
     */
    private $imports = [];
    
    public function add(ImportHelper $import) {
        if (isset($this->imports[$import->getImportLocation()])) {
            $this->imports[$import->getImportLocation()][] = $import->getClassName();
        } else {
            $this->imports[$import->getImportLocation()] = [$import->getClassName()];
        }
    }
    
    public function getAsString() {
        $content = '';
        foreach($this->imports as $importLocation => $classes) {
            $classesName = implode(', ', $classes);
            $content.= "import { $classesName } from '$importLocation'".self::ENTER;
        }
        return $content;
    }
}
