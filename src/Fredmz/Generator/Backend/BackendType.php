<?php
/**
 * Created by PhpStorm.
 * User: fmartinez
 * Date: 18/12/2017
 * Time: 11:11 AM
 */

namespace Fredmz\Generator\Backend;


use Fredmz\Generator\GenericTypes;

class BackendType
{
    const String = 'String';
    const BigDecimal = 'BigDecimal';
    const Int = 'Int';
    const LocalDate = 'LocalDate';
    const ZonedDateTime = 'ZonedDateTime';

    /**
     * Backend type of kotlin
     * @var $type string
     */
    private $type;
    /**
     * Is the type of the json file
     * @var $genericType string
     */
    private $genericType;

    public function __construct(string $genericType)
    {
        $this->genericType = $genericType;
        $types = [
            GenericTypes::String => self::String,
            GenericTypes::Currency => self::BigDecimal,
            GenericTypes::Int => self::Int,
            GenericTypes::Text => self::String,
            GenericTypes::Date => self::LocalDate,
            GenericTypes::Datetime => self::ZonedDateTime
        ];
        $this->type = $types[$genericType];
    }

    /**
     * @return bool
     */
    function isString() {
        return ($this->type == self::String);
    }

    /**
     * @return bool
     */
    function isNumeric() {
        return ($this->type == self::BigDecimal || $this->type == Self::Int);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getGenericType(): string
    {
        return $this->genericType;
    }
}