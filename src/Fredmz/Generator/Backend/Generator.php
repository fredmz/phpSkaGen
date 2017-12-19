<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
    private $package;
    
    function __construct($entityName, $entity, $genDir, $projectPackage, $relativeEntityPackage) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $genDir;
        $this->projectPackage = $projectPackage;
        $this->entityGenerator = new EntityGenerator($entityName, $entity, $this->getKotlinDir(), $projectPackage, $relativeEntityPackage);
        $this->serviceGenerator = new ServiceGenerator($entityName, $entity, $this->getKotlinDir(), $projectPackage, $relativeEntityPackage);
        $this->controllerGenerator = new ControllerGenerator($entityName, $entity, $this->getKotlinDir(), $projectPackage, $relativeEntityPackage);
    }

    function createEntity() {
        $this->createGeneratedDirBackend();
        $this->entityGenerator->createClass();
    }
    
    function createService() {
        $this->createGeneratedDirBackend();
        $this->serviceGenerator->createClass();
    }
    
    function createController() {
        $this->createGeneratedDirBackend();
        $this->controllerGenerator->createClass();
    }
    
    private function getGenDomainDir() {
        return $this->getKotlinDir().DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getGenServiceDir() {
        return $this->getKotlinDir().DIRECTORY_SEPARATOR.'service';
    }
    
    private function getGenControllerDir() {
        return $this->getKotlinDir().DIRECTORY_SEPARATOR.'web';
    }

    private function getKotlinDir() {
        $package = str_replace('.', DIRECTORY_SEPARATOR, $this->projectPackage);
        return $this->genDir.DIRECTORY_SEPARATOR
                    .'src'.DIRECTORY_SEPARATOR
                    .'main'.DIRECTORY_SEPARATOR
                    .'kotlin'.DIRECTORY_SEPARATOR.$package;
    }
    
    private function createGeneratedDirBackend() {
        if (!is_dir($this->getKotlinDir())) {
            mkdir($this->getKotlinDir(), 0777, true);
        }
        if (!is_dir($this->getGenDomainDir())) {
            mkdir($this->getGenDomainDir(), 0777, true);
        }
        if (!is_dir($this->getGenServiceDir())) {
            mkdir($this->getGenServiceDir(), 0777, true);
        }
        if (!is_dir($this->getGenControllerDir())) {
            mkdir($this->getGenControllerDir(), 0777, true);
        }
    }
}
