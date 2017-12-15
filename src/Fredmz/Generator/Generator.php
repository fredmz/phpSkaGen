<?php
namespace Fredmz\Generator;

class Generator {
    const ENTER = "\r\n";
    private $entity = [];
    private $entityName = '';
    private $dataSource = '';
    private $package = '';
    private $rootPackage = 'pe.org.institutoapoyo.sig';
    private $dirGen = '';
    private $dirGenBackend = '';
    private $dirGenFrontend = '';

    function __construct(string $dirModel, string $class, string $genDirectory) {
        $this->setDatasource($dirModel
                .DIRECTORY_SEPARATOR
                .str_replace('.', DIRECTORY_SEPARATOR, $class)
                .'.json');
        $this->setEntityInfo($class);
        $this->setGenPath($genDirectory);
    }

    private function setGenPath(string $genDirectory) {
        $this->dirGen = $genDirectory;
        $this->setDirGenBackend();
        $this->dirGenFrontend = $this->dirGen.DIRECTORY_SEPARATOR.'angular';
    }
    
    private function setDirGenBackend() {
        $this->dirGenBackend = $this->dirGen
                .DIRECTORY_SEPARATOR.'kotlin'
                .DIRECTORY_SEPARATOR
                . str_replace('.', DIRECTORY_SEPARATOR, $this->rootPackage)
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$this->package;
        d($this->dirGenBackend);
    }

        private function setEntityInfo(string $class) {
        $dir = explode('.', $class);
        $size = count($dir);
        if ($size == 2) {
            $this->entityName = $dir[1];
            $this->package = $dir[0];
        } else {
            throw new Exception("The class has to have a module package");
        }
    }
    
    private function setDatasource(string $datasource) {
        $this->dataSource = $datasource;
        $this->calculateEntityFromDatasource();
    }

    private function calculateEntityFromDatasource(){
        $string = file_get_contents($this->dataSource);
        $this->entity = json_decode($string, true);
    }
    
    private function getBackendModulePackage() {
        return $this->rootPackage.'.module'.'.'.$this->package;
    }
    
    private function getBackendDomainPackage() {
        return $this->getBackendModulePackage().'.domain';
    }
    
    private function getBackendServicePackage() {
        return $this->getBackendModulePackage().'.service';
    }
    
    private function getBackendControllerPackage() {
        return $this->getBackendModulePackage().'.web';
    }
    
    private function getGenBackendDomainDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getGenBackendServiceDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'service';
    }
    
    private function getGenBackendControllerDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'web';
    }
    
    function createBackend() {
        $this->createGeneratedDirBackend();
        $this->createBackendEntityClass();
        $this->createBackendServiceClass();
        $this->createBackendControllerClass();
    }
    
    function createBackendEntityClass() {
        $content = 'package '. $this->getBackendDomainPackage().self::ENTER;
        $content.= 'data class '. $this->entityName.'(';
        $path = $this->getGenBackendDomainDir().DIRECTORY_SEPARATOR."$this->entityName.kt";
        $classFile = fopen($path, "w");
        fwrite($classFile, $content);
        fclose($classFile);
    }
    
    function createBackendServiceClass() {
        echo 'createBackendServiceClass<br>';
    }
    
    function createBackendControllerClass() {
        echo 'createBackendControllerClass<br>';
    }
            
    private function createGeneratedDir() {
        if (!is_dir($this->dirGen)) {
            mkdir($this->dirGen, 0777, true);
        }
    }
    
    private function createGeneratedDirBackend() {
        $this->createGeneratedDir();
        if (!is_dir($this->dirGenBackend)) {
            mkdir($this->dirGenBackend, 0777, true);
        }
        if (!is_dir($this->getGenBackendDomainDir())) {
            mkdir($this->getGenBackendDomainDir(), 0777, true);
        }
        if (!is_dir($this->getGenBackendServiceDir())) {
            mkdir($this->getGenBackendServiceDir(), 0777, true);
        }
        if (!is_dir($this->getGenBackendControllerDir())) {
            mkdir($this->getGenBackendControllerDir(), 0777, true);
        }
    }
    
    private function createGeneratedDirFrontend() {
        $this->createGeneratedDir();
        if (!is_dir($this->dirGenFrontend)) {
            mkdir($this->dirGenFrontend, 0777, true);
        }
    }
    
    private function createDirectoryFromPackage() {
        echo 'module package: <br>';
        echo $this->getBackendModulePackage();
    }
}