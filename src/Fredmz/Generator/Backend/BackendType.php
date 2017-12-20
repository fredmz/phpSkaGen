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
    const STRING = 'String';
    const BIG_DECIMAL = 'BigDecimal';
    const INT = 'Int';
    const LOCAL_DATE = 'LocalDate';
    const ZONED_DATETIME = 'ZonedDateTime';

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
            GenericTypes::String => self::STRING,
            GenericTypes::Currency => self::BIG_DECIMAL,
            GenericTypes::Int => self::INT,
            GenericTypes::Text => self::STRING,
            GenericTypes::Date => self::LOCAL_DATE,
            GenericTypes::Datetime => self::ZONED_DATETIME
        ];
        $this->type = $types[$genericType];
    }

    /**
     * @return bool
     */
    function isString() {
        return ($this->type == self::STRING);
    }

    /**
     * @return bool
     */
    function isNumeric() {
        return ($this->type == self::BIG_DECIMAL || $this->type == Self::INT);
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