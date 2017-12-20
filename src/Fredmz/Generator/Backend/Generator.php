<?php

namespace Fredmz\Generator\Backend;

/**
 * Description of Generator
 *
 * @author fmartinez
 */
class Generator {
    private $entityName;
    private $genDir;
    /* @var $entityGenerator EntityGenerator */
    private $entityGenerator;

    /**
     * @var $serviceGenerator ServiceGenerator
     */
    private $serviceGenerator;

    /**
     * @var $controllerGenerator ControllerGenerator
     */
    private $controllerGenerator;

    private $entity;
    private $projectPackage;
    private $kotlinDir;
    private $moduleName;
    
    function __construct($entityName, $entity, $genDir, $projectPackage, $moduleName) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $genDir;
        $this->projectPackage = $projectPackage;
        $this->moduleName = $moduleName;
        $this->setKotlinDir();
        $this->entityGenerator = new EntityGenerator($entityName, $entity, $this->kotlinDir, $projectPackage, $moduleName);
        $this->serviceGenerator = new ServiceGenerator($entityName, $entity, $this->kotlinDir, $projectPackage, $moduleName);
        $this->controllerGenerator = new ControllerGenerator($entityName, $entity, $this->kotlinDir, $projectPackage, $moduleName);
    }

    function createEntity() {
        $this->entityGenerator->createClass();
    }
    
    function createService() {
        $this->serviceGenerator->createClass();
    }
    
    function createController() {
        $this->controllerGenerator->createClass();
    }
    
    private function getGenServiceDir() {
        return $this->kotlinDir
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$this->moduleName
                .DIRECTORY_SEPARATOR.'service';
    }
    
    private function getGenControllerDir() {
        return $this->kotlinDir
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$this->moduleName
                .DIRECTORY_SEPARATOR.'web';
    }

    private function setKotlinDir() {
        $this->kotlinDir = $this->genDir.DIRECTORY_SEPARATOR
                        .'kotlin'.DIRECTORY_SEPARATOR
                        .str_replace('.', DIRECTORY_SEPARATOR, $this->projectPackage);
    }
}
