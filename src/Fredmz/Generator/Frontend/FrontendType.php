<?php
/**
 * Created by PhpStorm.
 * User: fmartinez
 * Date: 18/12/2017
 * Time: 11:11 AM
 */

namespace Fredmz\Generator\Backend;


use Fredmz\Generator\GenericTypes;

class FrontendType
{
    const string = 'string';
    const number = 'number';
    const any = 'any';
    const Date = 'Date';

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
            GenericTypes::String => self::string,
            GenericTypes::Currency => self::number,
            GenericTypes::Int => self::number,
            GenericTypes::Text => self::string,
            GenericTypes::Date => self::Date,
            GenericTypes::Datetime => self::Date
        ];
        $this->type = $types[$genericType];
    }

    /**
     * @return bool
     */
    function isString() {
        return ($this->type == self::string);
    }

    /**
     * @return bool
     */
    function isNumeric() {
        return ($this->type == self::number);
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