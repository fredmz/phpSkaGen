<?php

namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\FileGenerator;
use Fredmz\Generator\StringSet;
use Fredmz\Generator\FileFormatter;

/**
 * Description of ModelGenerator
 *
 * @author fmartinez
 */
class ModelGenerator {
    const ENTER = "\r\n";
    private $entityName;
    private $dirGen;
    private $moduleName;
    private $entity;
    /**
     *
     * @var ImportHandler key value array
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
        $this->dirGen = $dirGenFrontend;
        $this->moduleName = $moduleName;
        $this->imports = new ImportHandler();
    }

    private function getAttributesAsString(): string {
        $attr = '';
        foreach($this->entity['fields'] as $field) {
            $fieldGen = new FieldGenerator($field['name'], $field['type'], $field['validation']);
            $attr.= $fieldGen->getContent();
        }
        return $attr;
    }
    
    function createClass() {
        $data = [
            'imports' => $this->imports->getAsString(),
            'domainClass' => $this->entityName,
            'attributes' => $this->getAttributesAsString()
        ];
        $entityFile = $this->dirGen.DIRECTORY_SEPARATOR.FileFormatter::fromCamelCaseToHyphen($this->entityName).'.ts';
        FileGenerator::createFile($entityFile,
                FileGenerator::renderFile(__DIR__.'/template/model.txt', $data));
    }
}
