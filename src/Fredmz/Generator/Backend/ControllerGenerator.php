<?php
namespace Fredmz\Generator\Backend;


use Fredmz\Generator\FileGenerator;
use Fredmz\Generator\StringSet;

class ControllerGenerator
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
                .DIRECTORY_SEPARATOR.'web';
        $this->projectPackage = $projectPackage;
        $this->moduleName = $moduleName;
        $this->imports = new StringSet();
        $this->imports->addList([
            $this->projectPackage.'.utils.ResponseUtil',
            $this->projectPackage.'.utils.HeaderUtil',
            $this->projectPackage.'.utils.PaginationUtil',
            $this->getDomainPackage().'.'.$this->entityName,
            $this->getServicePackage().'.'.$this->entityName.'Service',
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

    private function getControllerPackage() {
        return $this->getModulePackage().'.web';
    }

    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }

    private function getServicePackage() {
        return $this->getModulePackage().'.service';
    }

    function createClass() {
        if (!is_dir($this->dirGen)) {
            mkdir($this->dirGen, 0777, true);
        }
        $data = [
            'package' => $this->getControllerPackage(),
            'imports' => $this->getImporstAsString(),
            'domainObject' => $this->objectName,
            'domainClass' => $this->entityName,
            'url' => '/api/'.$this->moduleName.'/'.$this->objectName
        ];
        $file = $this->dirGen.DIRECTORY_SEPARATOR.$this->entityName.'Controller.kt';
        FileGenerator::createFile($file, FileGenerator::renderFile(__DIR__.'/template/controller.txt', $data));
    }
}