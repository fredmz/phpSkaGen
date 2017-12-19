<?php

namespace Fredmz\Generator\Frontend;

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
    private $package;
    
    function __construct($entityName, $entity, $genDir, $moduleName) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $genDir;
        $this->entityGenerator = new EntityGenerator($entityName, $entity, $genDir, $moduleName);
        $this->serviceGenerator = new ServiceGenerator($entityName, $entity, $genDir, $moduleName);
        $this->controllerGenerator = new ControllerGenerator($entityName, $entity, $genDir, $moduleName);
    }

    function createEntity() {
        $this->createGeneratedDir();
        $this->entityGenerator->createClass();
    }
    
    function createService() {
        $this->createGeneratedDir();
        $this->serviceGenerator->createClass();
    }
    
    function createComponents() {
        $this->createGeneratedDir();
        $this->controllerGenerator->createClass();
    }
    
    private function getGenDomainDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getGenServiceDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'service';
    }
    
    private function getGenComponentDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'web';
    }
    
    private function createGeneratedDir() {
        if (!is_dir($this->genDir)) {
            mkdir($this->genDir, 0777, true);
        }
        if (!is_dir($this->getGenDomainDir())) {
            mkdir($this->getGenDomainDir(), 0777, true);
        }
        if (!is_dir($this->getGenServiceDir())) {
            mkdir($this->getGenServiceDir(), 0777, true);
        }
        if (!is_dir($this->getGenComponentDir())) {
            mkdir($this->getGenComponentDir(), 0777, true);
        }
    }
}
