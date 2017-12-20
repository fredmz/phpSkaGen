<?php

namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\FileFormatter;
/**
 * Description of Generator
 *
 * @author fmartinez
 */
class Generator {
    private $entityName;
    private $genDir;
    /* @var $modelGenerator ModelGenerator */
    private $modelGenerator;

    /**
     * @var $serviceGenerator ServiceGenerator
     */
    private $serviceGenerator;

    /**
     * @var $controllerGenerator ControllerGenerator
     */
    private $controllerGenerator;

    private $entity;
    
    /**
     * 
     * @param string $entityName
     * @param array $entity structure of the entity
     * @param string $rootGenDirectory root directory for project code generation
     * @param string $moduleName
     */
    function __construct(string $entityName, array $entity, string $rootGenDirectory, string $moduleName) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->genDir = $rootGenDirectory.DIRECTORY_SEPARATOR.'webapp'
                .DIRECTORY_SEPARATOR.'src'
                .DIRECTORY_SEPARATOR.'app'
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.FileFormatter::fromCamelCaseToHyphen($moduleName)
                .DIRECTORY_SEPARATOR.FileFormatter::fromCamelCaseToHyphen($entityName);
        
        if (!is_dir($this->genDir)) {
            mkdir($this->genDir, 0777, true);
        }
        
        $this->modelGenerator = new ModelGenerator($entityName, $entity, $this->genDir, $moduleName);
        $this->serviceGenerator = new ServiceGenerator($entityName, $entity, $this->genDir, $moduleName);
//        $this->controllerGenerator = new ControllerGenerator($entityName, $entity, $this->genDir, $moduleName);
    }

    function getModelGenerator(): ModelGenerator {
        return $this->modelGenerator;
    }

    function getServiceGenerator(): ServiceGenerator {
        return $this->serviceGenerator;
    }
}
