<?php
namespace Fredmz\Generator;
use Fredmz\Generator\Backend\Generator as BackendGenerator;
use Fredmz\Generator\Frontend\Generator as FrontendGenerator;
class Generator {
    const ENTER = "\r\n";
    private $entity = [];
    private $entityName = '';
    private $dataSource = '';
    private $relativeModulePackage = '';
    private $projectPackage = '';
    private $genDir = '';
    
    /* @var $backendGenerator BackendGenerator */
    private $backendGenerator;

    /**
     * @var $frontendGenerator FrontendGenerator
     */
    private $frontendGenerator;

    function __construct(string $dirModel, string $class, string $projectPackage, string $genDirectory) {
        $this->setDatasource($dirModel
                .DIRECTORY_SEPARATOR
                .str_replace('.', DIRECTORY_SEPARATOR, $class)
                .'.json');
        $this->projectPackage = $projectPackage;
        $this->setEntityInfo($class);
        $this->setGenPath($genDirectory);
        $this->backendGenerator = new BackendGenerator($this->entityName,
                $this->entity,
                $this->genDir,
                $this->projectPackage,
                $this->relativeModulePackage);

        /*$this->frontendGenerator = new FrontendGenerator($this->entityName,
            $this->entity,
            $this->genDir,
            $this->relativeModulePackage);*/
    }

    private function setGenPath(string $genDirectory) {
        $this->genDir = $genDirectory;
    }

    private function setEntityInfo(string $class) {
        $dir = explode('.', $class);
        $size = count($dir);
        if ($size == 2) {
            $this->entityName = $dir[1];
            $this->relativeModulePackage = $dir[0];
        } else {
            throw new Exception("The class needs the format 'Module/Class'");
        }
    }
    
    private function setDatasource(string $datasource) {
        $this->dataSource = $datasource;
        $this->readEntityFromDatasource();
    }

    private function readEntityFromDatasource(){
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

    function createFrontend() {
        $this->frontendGenerator->createEntity();
        $this->frontendGenerator->createService();
        $this->frontendGenerator->createComponents();
    }
}