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

    private $entity;
    private $projectPackage;
    private $package;
    
    function __construct($entityName, $entity, $genDir, $projectPackage, $relativeEntityPackage) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $genDir;
        $this->projectPackage = $projectPackage;
        $this->entityGenerator = new EntityGenerator($entityName, $entity, $genDir, $projectPackage, $relativeEntityPackage);
        $this->serviceGenerator = new ServiceGenerator($entityName, $entity, $genDir, $projectPackage, $relativeEntityPackage);
    }

    function createEntity() {
        $this->createGeneratedDirBackend();
        $this->entityGenerator->createEntityClass();
    }
    
    function createService() {
        $this->createGeneratedDirBackend();
        $this->serviceGenerator->createServiceClass();
    }
    
    function createController() {
        $this->createGeneratedDirBackend();
        echo "<br>createController not implemented<br>";
    }
    
    private function getGenDomainDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getGenServiceDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'service';
    }
    
    private function getGenControllerDir() {
        return $this->genDir.DIRECTORY_SEPARATOR.'web';
    }
    
    private function createGeneratedDirBackend() {
        if (!is_dir($this->genDir)) {
            mkdir($this->genDir, 0777, true);
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
