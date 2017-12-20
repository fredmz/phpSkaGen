<?php

namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\FileGenerator;
use Fredmz\Generator\StringSet;

/**
 * Description of EntityGenerator
 *
 * @author fmartinez
 */
class EntityGenerator {
    const ENTER = "\r\n";
    private $entityName;
    private $entityFile;
    private $dirGenFrontend;
    private $moduleName;
    private $entity;
    /**
     * @var StringSet
     */
    private $imports;

    /**
     * EntityGenerator constructor.
     * @param string $entityName
     * @param array $entity structure of the entity
     * @param string $dirGenFrontend directory for frontend code generation
     * @param string $moduleName
     */
    function __construct(string $entityName, array $entity, string $dirGenFrontend, string $moduleName) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->dirGenFrontend = $dirGenFrontend;
        $this->moduleName = $moduleName;
        $this->imports = new StringSet();
    }

    private function getModulePackage() {
        return $this->projectPackage.'.module'.'.'.$this->moduleName;
    }

    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }
    
    private function getGenDomainDir() {
        return $this->dirGenFrontend.DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getAttributes(): string {
        $attributes = '';
    }
    
    private function getImportsAsString() {
        $content = '';
        foreach($this->imports->getItems() as $import) {
            $content.= 'import '.$import.self::ENTER;
        }
        return $content;
    }
    
    private function getIdField() {
        $content = '';
        if ($this->entity['type'] == 'entity') {
            $content.= "\t@Id @GeneratedValue(strategy = GenerationType.AUTO)".self::ENTER;
            $content.= "\tvar id: Long?,";
        }
        return $content;
    }
    
    function createClass() {
        $content = 'package '. $this->getDomainPackage().self::ENTER;
        $content.= $this->getAttributes();
        $this->entityFile = $this->getGenDomainDir().DIRECTORY_SEPARATOR."$this->entityName.kt";

        FileGenerator::createFile($this->entityFile, $content);
    }
}
