<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fredmz\Generator;

/**
 * Description of BackendGenerator
 *
 * @author fmartinez
 */
class BackendGenerator {
    private $entityName;
    private $genDir;
    /* @var $entityGenerator BackendEntityGenerator */
    private $entityGenerator;
    private $entity;
    private $rootPackage;
    private $package;
    
    function __construct($entityName, $entity, $genDir, $rootPackage, $package) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $genDir;
        $this->rootPackage = $rootPackage;
        $this->entityGenerator = new BackendEntityGenerator($entityName, $entity, $genDir, $rootPackage, $package);
    }

    function createEntity() {
        $this->createGeneratedDirBackend();
        $this->entityGenerator->createEntityClass();
    }
    
    function createService() {
        $this->createGeneratedDirBackend();
        echo "createService not implemented<br>";
    }
    
    function createController() {
        $this->createGeneratedDirBackend();
        echo "createController not implemented<br>";
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
