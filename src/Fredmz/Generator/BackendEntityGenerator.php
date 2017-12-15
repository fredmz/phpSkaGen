<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fredmz\Generator;

/**
 * Description of BackendEntityGenerator
 *
 * @author fmartinez
 */
class BackendEntityGenerator {
    const ENTER = "\r\n";
    private $entityName;
    private $entityFile;
    private $dirGenBackend;
    private $rootPackage;
    private $package;
    private $entity;
    private $imports = ['javax.persistence.*'];
    
    function __construct($entityName, $entity, $dirGenBackend, $rootPackage, $package) {
        $this->entity = $entity;
        $this->entityName = $entityName;
        $this->dirGenBackend = $dirGenBackend;
        $this->rootPackage = $rootPackage;
        $this->package = $package;
    }

    private function getRepositoryContent() {
        $content = self::ENTER.self::ENTER;
        $content.= 'interface ';
        $content.= $this->entityName;
        $content.= 'Repository: JpaRepository<';
        $content.= $this->entityName. ', Long>';
        return $content;
    }
    
    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }
    
    private function getModulePackage() {
        return $this->rootPackage.'.module'.'.'.$this->package;
    }
    
    private function getGenDomainDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'domain';
    }
    
    private function getConstructorContent(): string {
        $type = '';
        $extend = '';
        if ($this->entity['type'] == 'entity') {
            $this->imports[] = 'org.springframework.data.jpa.repository.JpaRepository';
            $this->imports[] = 'pe.org.institutoapoyo.sig.utils.AbstractAuditingEntity';
            $type = 'data';
            $extend = ': AbstractAuditingEntity()';
        }
        $arrFields = [];
        foreach ($this->entity['fields'] as $fieldName => $fieldAttributes) {
            $fieldGenerator = new BackendFieldGenerator($fieldName, $fieldAttributes);
            $arrFields[] = $fieldGenerator->getContent();
            $this->addImports($fieldGenerator->getImports());
        }
        $content = self::ENTER;
        $content.= $this->getImportsAsString();
        $content.= self::ENTER;
        $content.= "$type class $this->entityName (".self::ENTER;
        $content.= $this->getIdField();
        $content.= implode(',', $arrFields).self::ENTER.')'.$extend;
        return $content;
    }
    
    private function getImportsAsString() {
        $content = '';
        foreach($this->imports as $import) {
            $content.= 'import '.$import.self::ENTER;
        }
        return $content;
    }
    
    private function getIdField() {
        $content = '';
        if ($this->entity['type'] == 'entity') {
            $content.= "\t@Id".self::ENTER;
            $content.= "\t@GeneratedValue(strategy = GenerationType.AUTO)".self::ENTER;
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
    
    private function addImport(string $import) {
        if (!in_array($import, $this->imports)) {
            $this->imports[] = $import;
        }
    }

    private function addImports(array $imports) {
        foreach($imports as $import) {
            $this->addImport($import);
        }
    }
}
