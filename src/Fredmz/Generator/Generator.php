<?php
namespace Fredmz\Generator;

class Generator {
    const ENTER = "\r\n";
    private $entity = [];
    private $entityName = '';
    private $dataSource = '';
    private $package = '';
    private $rootPackage = 'pe.org.institutoapoyo.sig';
    private $genDir = '';
    private $genDirBackend = '';
    private $genDirFrontEnd = '';
    
    /* @var $backendGenerator BackendGenerator */
    private $backendGenerator;

    function __construct(string $dirModel, string $class, string $genDirectory) {
        $this->setDatasource($dirModel
                .DIRECTORY_SEPARATOR
                .str_replace('.', DIRECTORY_SEPARATOR, $class)
                .'.json');
        $this->setEntityInfo($class);
        $this->setGenPath($genDirectory);
        $this->backendGenerator = new BackendGenerator($this->entityName,
                $this->entity,
                $this->genDir,
                $this->rootPackage,
                $this->package);
    }

    private function setGenPath(string $genDirectory) {
        $this->genDir = $genDirectory;
        $this->setDirGenBackend();
        $this->genDirFrontEnd = $this->genDir.DIRECTORY_SEPARATOR.'angular';
    }
    
    private function setDirGenBackend() {
        $this->genDirBackend = $this->genDir
                .DIRECTORY_SEPARATOR.'kotlin'
                .DIRECTORY_SEPARATOR
                . str_replace('.', DIRECTORY_SEPARATOR, $this->rootPackage)
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$this->package;
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
    
    function createBackend() {
        $this->backendGenerator->createEntity();
        $this->backendGenerator->createService();
        $this->backendGenerator->createController();
    }
    
    function createBackendEntityClass() {
        $this->backendGenerator->createEntity();
    }
    
    function createBackendServiceClass() {
        $this->backendGenerator->createService();
    }
    
    function createBackendControllerClass() {
        $this->backendGenerator->createController();
    }
}