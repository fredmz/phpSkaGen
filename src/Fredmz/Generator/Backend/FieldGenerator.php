<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fredmz\Generator\Backend;
use Fredmz\Generator\StringSet;

/**
 * Description of FieldGenerator
 *
 * @author fmartinez
 */
class FieldGenerator {
    const ENTER = "\r\n";
    const SIZE = 'javax.validation.constraints.Size';
    const MIN = 'javax.validation.constraints.Min';
    const MAX = 'javax.validation.constraints.Max';
    private $fieldName;

    /**
     * @var $validationRules BackendValidationRules
     */
    private $validationRules;

    public function __construct(string $fieldName, string $type, array $validations) {
        $this->fieldName = $fieldName;
        $this->validationRules = new BackendValidationRules($type, $validations);
        $this->validationRules->evalValidations();
    }

    function getContent(): string {
        $content = self::ENTER;
        $content.= self::ENTER;
        $content.= "\t@Column(".$this->validationRules->getColumnAnnotationAttributesAsString().")";
        $content.= $this->validationRules->getAnnotationsAsString();
        $content.= self::ENTER;
        $content.= "\tvar $this->fieldName: ".$this->validationRules->getType()->getType();
        return $content;
    }

    /**
     * @return StringSet
     */
    function getImports(): StringSet {
        return $this->validationRules->getImports();
    }
}
