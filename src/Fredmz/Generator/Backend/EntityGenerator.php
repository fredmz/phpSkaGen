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
    private $dirGenBackend;
    private $projectPackage;
    private $relativeEntityPackage;
    private $entity;
    /**
     * @var StringSet
     */
    private $imports;
    
    function __construct($entityName, $entity, $dirGenBackend, $projectPackage, $relativeEntityPackage) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->dirGenBackend = $dirGenBackend;
        $this->projectPackage = $projectPackage;
        $this->relativeEntityPackage = $relativeEntityPackage;
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

    private function getModulePackage() {
        return $this->projectPackage.'.module'.'.'.$this->relativeEntityPackage;
    }

    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }
    
    private function getGenDomainDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'domain';
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
        $content.= "$type class $this->entityName (".self::ENTER;
        $content.= $this->getIdField();
        $content.= self::ENTER;
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
    
    function createEntityClass() {
        $content = 'package '. $this->getDomainPackage().self::ENTER;
        $content.= $this->getConstructorContent();
        $content.= $this->getRepositoryContent();
        $this->entityFile = $this->getGenDomainDir().DIRECTORY_SEPARATOR."$this->entityName.kt";
        FileGenerator::createFile($this->entityFile, $content);
    }
}
