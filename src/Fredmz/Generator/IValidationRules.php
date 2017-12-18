<?php
/**
 * Created by PhpStorm.
 * User: fmartinez
 * Date: 18/12/2017
 * Time: 10:45 AM
 */

namespace Fredmz\Generator;


interface IValidationRules
{
    function evalRequired();
    function evalMinAndMax();
    function evalValidations();
}