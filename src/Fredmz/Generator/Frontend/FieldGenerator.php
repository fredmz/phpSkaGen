<?php
namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\Frontend\FrontendType;

class FieldGenerator
{
    const ENTER = "\r\n";
    private $fieldName;
    /**
     *
     * @var FieldValidationRules
     */
    private $validations;
    
    function __construct($fieldName, string $type, array $validations) {
        $this->fieldName = $fieldName;
        $this->validations = new FieldValidationRules($type, $validations);
        $this->validations->evalValidations();
    }
    
    function getContent(): string {
        $content = self::ENTER;
        $content.= "\t\tpublic $this->fieldName?: ".$this->validations->getType().',';
        return $content;
    }
}