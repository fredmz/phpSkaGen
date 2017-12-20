<?php
namespace Fredmz\Generator\Backend;

use Fredmz\Generator\FileGenerator;
use Fredmz\Generator\StringSet;

class ServiceGenerator
{
    const ENTER = "\r\n";
    private $entityName;
    private $objectName;
    private $dirGen;
    private $projectPackage;
    private $moduleName;
    private $entity;
    /**
     * @var StringSet
     */
    private $imports;

    function __construct($entityName, $entity, $dirGenBackend, $projectPackage, $moduleName) {
        $this->entity = $entity;
        $this->objectName = lcfirst($entityName);
        $this->entityName = $entityName;
        $this->dirGen = $dirGenBackend
                .DIRECTORY_SEPARATOR.'module'
                .DIRECTORY_SEPARATOR.$moduleName
                .DIRECTORY_SEPARATOR.'service';
        $this->projectPackage = $projectPackage;
        $this->moduleName = $moduleName;
        $this->imports = new StringSet();
        $this->imports->addList([
            $this->getDomainPackage().'.'.$this->entityName,
            $this->getDomainPackage().'.'.$this->entityName.'Repository',
            ]);
    }

    private function getImporstAsString(): string {
        $content = '';
        foreach ($this->imports->getItems() as $item) {
            $content.= self::ENTER.'import '. $item;
        }
        return $content;
    }

    private function getModulePackage() {
        return $this->projectPackage.'.module'.'.'.$this->moduleName;
    }

    private function getServicePackage() {
        return $this->getModulePackage().'.service';
    }

    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }

    function createClass() {
        if (!is_dir($this->dirGen)) {
            mkdir($this->dirGen, 0777, true);
        }
        $data = [
            'package' => $this->getServicePackage(),
            'imports' => $this->getImporstAsString(),
            'domainObject' => $this->objectName,
            'domainClass' => $this->entityName
        ];
        $file = $this->dirGen.DIRECTORY_SEPARATOR.$this->entityName.'Service.kt';
        FileGenerator::createFile($file, FileGenerator::renderFile(__DIR__.'/template/service.txt', $data));
    }
}