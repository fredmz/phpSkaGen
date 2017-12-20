<?php
/**
 * Created by PhpStorm.
 * User: fmartinez
 * Date: 18/12/2017
 * Time: 11:11 AM
 */

namespace Fredmz\Generator\Frontend;


use Fredmz\Generator\GenericTypes;

class FrontendType
{
    const STRING = 'string';
    const NUMBER = 'number';
    const ANY = 'any';
    const DATE = 'Date';

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
            GenericTypes::Currency => self::NUMBER,
            GenericTypes::Int => self::NUMBER,
            GenericTypes::Text => self::STRING,
            GenericTypes::Date => self::DATE,
            GenericTypes::Datetime => self::DATE
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
        return ($this->type == self::NUMBER);
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