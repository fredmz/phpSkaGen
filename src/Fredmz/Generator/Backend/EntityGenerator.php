<?php

namespace Fredmz\Generator\Backend;
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
    /**
     *
     * @var string location to generate entity class 
     */
    private $dirGen;
    private $projectPackage;
    private $moduleName;
    /**
     *
     * @var string full path of module package
     */
    private $modulePackage;
    private $entity;
    /**
     * @var StringSet
     */
    private $imports;
    
    function __construct($entityName,
            $entity,
            $dirGen,
            $projectPackage,
            $moduleName) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->dirGen = $dirGen.DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$moduleName
                .DIRECTORY_SEPARATOR.'domain';
        $this->projectPackage = $projectPackage;
        $this->moduleName = $moduleName;
        $this->modulePackage = $this->projectPackage.'.module'.'.'.$this->moduleName;
        $this->imports = new StringSet();
    }

    private function getRepositoryContent() {
        $content = self::ENTER.self::ENTER;
        $content.= 'interface ';
        $content.= $this->entityName;
        $content.= 'Repository: JpaRepository<';
        $content.= $this->entityName. ', Long>';
        return $content;
    }

    private function getConstructorContent(): string {
        $type = '';
        $extend = '';
        if ($this->entity['type'] == 'entity') {
            $this->imports->addList([
                'javax.persistence.*',
                'org.springframework.data.jpa.repository.JpaRepository',
                $this->projectPackage.'.utils.AbstractAuditingEntity'
            ]);
            $type = 'data';
            $extend = ': AbstractAuditingEntity()';
        }
        $arrFields = [];
        foreach ($this->entity['fields'] as $field) {
            $fieldGenerator = new FieldGenerator($field['name'], $field['type'], $field['validation']);
            $arrFields[] = $fieldGenerator->getContent();
            $this->imports->addList($fieldGenerator->getImports()->getItems());
        }
        $content = self::ENTER;
        $content.= $this->getImportsAsString();
        $content.= self::ENTER;
        $content.= '@Entity'. self::ENTER;
        $content.= '@Table(name = "'. strtolower(substr($this->moduleName, 0, 3)).'_'.\Fredmz\Generator\SnakeConverter::fromCamelCase($this->entityName).'")';
        $content.= self::ENTER;
        $content.= "$type class $this->entityName (".self::ENTER;
        $content.= $this->getIdField();
        $content.= implode(',', $arrFields).self::ENTER.')'.$extend;
        return $content;
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
        if (!is_dir($this->dirGen)) {
            mkdir($this->dirGen, 0777, true);
        }
        $content = 'package '. $this->modulePackage.'.domain'.self::ENTER;
        $content.= $this->getConstructorContent();
        $content.= $this->getRepositoryContent();
        $this->entityFile = $this->dirGen.DIRECTORY_SEPARATOR."$this->entityName.kt";
        FileGenerator::createFile($this->entityFile, $content);
    }
}
