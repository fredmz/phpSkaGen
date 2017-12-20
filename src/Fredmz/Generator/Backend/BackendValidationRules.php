<?php

namespace Fredmz\Generator\Backend;

use Fredmz\Generator\ValidationRules;

class BackendValidationRules extends ValidationRules
{
    /**
     * @var BackendType $type
     */
    protected $type;
    /**
     *
     * @var string
     */
    protected $genericType;

    const SIZE = 'javax.validation.constraints.Size';
    const MIN = 'javax.validation.constraints.Min';
    const MAX = 'javax.validation.constraints.Max';

    public function __construct($genericType, array $validations)
    {
        parent::__construct($genericType, $validations);
        $this->type = new BackendType($genericType);
    }

    /**
     * @return BackendType
     */
    public function getType(): BackendType
    {
        return $this->type;
    }

    function evalRequired()
    {
        if ($this->required) {
            $this->columnAnnotationAttributes->add('nullable = false');
        }
    }

    function evalMinAndMax()
    {
        if ($this->type->isString()) {
            $this->evalMinAndMaxAsString();
        } else if ($this->type->isNumeric()){
            $this->evalMinAndMaxAsNumeric();
        }
    }

    private function evalMinAndMaxAsNumeric() {
        if ($this->min != null) {
            $this->imports->add(self::MIN);
            $this->annotations->add('@Min('.$this->min.')');
        }
        if ($this->max != null) {
            $this->imports->add(self::MAX);
            $this->annotations->add('@Max('.$this->max.')');
        }
    }

    private function evalMinAndMaxAsString() {
        $arrSize = [];
        if ($this->min != null) {
            $this->imports->add(self::SIZE);
            $arrSize[] = 'min = '.$this->min;
        }
        if ($this->max != null) {
            $this->imports->add(self::SIZE);
            $this->columnAnnotationAttributes->add('length = '. $this->max);
            $arrSize[] = 'max = '.$this->max;
        }
        if (count($arrSize) > 0) {
            $this->annotations->add('@Size('.implode(', ', $arrSize).')');
        }
    }

    function evalValidations() {
        $this->evalRequired();
        $this->evalMinAndMax();
    }
}