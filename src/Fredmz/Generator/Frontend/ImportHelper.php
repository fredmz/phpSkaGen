<?php
namespace Fredmz\Generator\Frontend;
/**
 * Description of ImportHelper
 *
 * @author fmartinez
 */
class ImportHelper {
    private $className;
    private $importLocation;
    
    function __construct($className) {
        $this->className = $className;
        $this->evalImportLocation();
    }
    
    function getClassName() {
        return $this->className;
    }

    function getImportLocation() {
        return $this->importLocation;
    }
    
    function evalImportLocation() {
        d('evalImportLocation not implemented');
        $this->importLocation = '';
    }
}
