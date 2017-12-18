<?php
namespace Fredmz\Generator;


abstract class ValidationRules implements IValidationRules
{
    /**
     * @var $genericType string
     */
    protected $genericType;
    /**
     * @var $required bool
     */
    protected $required;

    /**
     * @var $min int
     */
    protected $min;

    /**
     * @var $max int
     */
    protected $max;

    /**
     * @var $imports StringSet
     */
    protected $imports;

    /**
     * @var $annotations StringSet
     */
    protected $annotations;

    /**
     * @var $columnAnnotationAttributes StringSet
     */
    protected $columnAnnotationAttributes;

    public function __construct(string $genericType, array $validations)
    {
        $this->genericType = $genericType;
        $this->required = $validations['required'] ?? true;
        $this->min = $validations['min'] ?? NULL;
        $this->max = $validations['max'] ?? NULL;

        $this->imports = new StringSet();
        $this->annotations = new StringSet();
        $this->columnAnnotationAttributes = new StringSet();
    }

    /**
     * @return StringSet
     */
    public function getImports(): StringSet
    {
        return $this->imports;
    }

    /**
     * @return string
     */
    public function getAnnotationsAsString(): string {
        if (count($this->annotations->getItems()) == 0) {
            return '';
        }
        return ' '.implode(' ', $this->annotations->getItems());
    }

    /**
     * @return string
     */
    public function getColumnAnnotationAttributesAsString(): string {
        if (count($this->columnAnnotationAttributes->getItems()) == 0) {
            return '';
        }
        return implode(', ', $this->columnAnnotationAttributes->getItems());
    }
}