<?php

namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\FileFormatter;
use Fredmz\Generator\FileGenerator;
/**
 * Description of ServiceGenerator
 *
 * @author fmartinez
 */
class ServiceGenerator {
    /**
     *
     * @var string 
     */
    private $entityName;
    /**
     *
     * @var array 
     */
    private $entity;
    /**
     *
     * @var string root directory for frontend generation entity
     */
    private $genDir;
    
    /**
     *
     * @var string
     */
    private $moduleName;
    
    
    /**
     * 
     * @param string $entityName
     * @param array $entity
     * @param string $genDir
     * @param string $moduleName
     */
    function __construct(string $entityName, array $entity, string $genDir, string $moduleName) {
        $this->entityName = $entityName;
        $this->entity = $entity;
        $this->genDir = $genDir;
        $this->moduleName = $moduleName;
    }

    function createClass() {
        $domainFile = FileFormatter::fromCamelCaseToHyphen($this->entityName);
        $file = $this->genDir
                .DIRECTORY_SEPARATOR.$domainFile.'.service.ts';
        $data = [
            'imports' => '',
            'domainClass' => $this->entityName,
            'domainFile' => $domainFile,
            'domainObject' => lcfirst($this->entityName),
            'url' => '/api/'.FileFormatter::fromCamelCaseToHyphen($this->moduleName)
                .'/'.FileFormatter::fromCamelCaseToHyphen($this->entityName)
        ];
        FileGenerator::createFile($file,
                FileGenerator::renderFile(__DIR__.'/template/service.txt', $data)
                );
    }
}
