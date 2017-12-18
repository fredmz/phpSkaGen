<?php
namespace Fredmz\Generator\Backend;


use Fredmz\Generator\FileGenerator;
use Fredmz\Generator\StringSet;

class ServiceGenerator
{
    const ENTER = "\r\n";
    private $entityName;
    private $objectName;
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
        $this->objectName = lcfirst($entityName);
        $this->entityName = $entityName;
        $this->dirGenBackend = $dirGenBackend;
        $this->projectPackage = $projectPackage;
        $this->relativeEntityPackage = $relativeEntityPackage;
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
        return $this->projectPackage.'.module'.'.'.$this->relativeEntityPackage;
    }

    private function getServicePackage() {
        return $this->getModulePackage().'.service';
    }

    private function getDomainPackage() {
        return $this->getModulePackage().'.domain';
    }

    private function getGenserviceDir() {
        return $this->dirGenBackend.DIRECTORY_SEPARATOR.'service';
    }

    function createServiceClass() {
        $data = [
            'package' => $this->getServicePackage(),
            'imports' => $this->getImporstAsString(),
            'domainObject' => $this->objectName,
            'domainClass' => $this->entityName
        ];
        $file = $this->getGenserviceDir().DIRECTORY_SEPARATOR.$this->entityName.'Service.kt';
        FileGenerator::createFile($file, FileGenerator::renderFile(__DIR__.'/template/service.txt', $data));
    }
}