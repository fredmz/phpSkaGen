<?php

namespace Fredmz\Generator\Frontend;
use Fredmz\Generator\ValidationRules;
/**
 * Description of FieldValidationRules
 *
 * @author fmartinez
 */
class FieldValidationRules extends ValidationRules {
    /**
     *
     * @var FrontendType
     */
    protected $type;
    protected $genericType;

    function __construct(string $genericType, array $validations) {
        parent::__construct($genericType, $validations);
        $this->type = new FrontendType($genericType);
        $this->genericType = $genericType;
    }
    
    public function evalMinAndMax() {
    }

    public function evalRequired() {
    }

    public function evalValidations() {
        $this->evalRequired();
        $this->evalMinAndMax();
    }

    public function getType(): string {
        return $this->type->getType();
    }
}
