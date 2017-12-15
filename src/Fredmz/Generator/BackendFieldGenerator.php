<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Fredmz\Generator;

/**
 * Description of BackendFieldGenerator
 *
 * @author fmartinez
 */
class BackendFieldGenerator {
    const ENTER = "\r\n";
    const SIZE = 'javax.validation.constraints.Size';
    const MIN = 'javax.validation.constraints.Min';
    const MAX = 'javax.validation.constraints.Max';
    private $name;
    private $imports = [];
    private $attr = [];

    public function __construct(string $fieldName, array $attributes) {
        $this->name = $fieldName;
        $this->attr = $attributes;
    }
    
    private function getType() {
        $types = [
            'string' => 'String',
            'currency' => 'BigDecimal',
            'string' => 'String',
            'string' => 'String',
            'string' => 'String'
        ];
        return $types[$this->attr['type']];
    }
    
    private function isString(): bool {
        return $this->attr['type'] == 'string';
    }

    private function isCurrency(): bool {
        return $this->attr['type'] == 'currency';
    }

    private function isText(): bool {
        return $this->attr['type'] == 'text';
    }

    private function isInt(): bool {
        return $this->attr['type'] == 'int';
    }

    private function isDate(): bool {
        return $this->attr['type'] == 'date';
    }

    private function isDatetime(): bool {
        return $this->attr['type'] == 'datetime';
    }
            
    private function getValidation() {
        $content = $this->getSizeValidation();
        return $content;
    }
    
    private function getNumberValidation() {
        $content = '';
        if ($this->isInt() || $this->isCurrency()) {
            $arr = [];
            foreach ($this->attr['validation'] as $rule => $value) {
                switch($rule) {
                    case 'min':
                        $content.= '@Min('.$value.')';
                        $this->imports[] = self::MIN;
                        break;
                    case 'max':
                        $content.= '@Max('.$value.')';
                        $this->imports[] = self::MAX;
                        break;
                }
            }
        }
        return $content;
    }


    private function getSizeValidation() {
        $content = '';
        if ($this->isString()) {
            $arr = [];
            foreach ($this->attr['validation'] as $rule => $value) {
                if (in_array($rule, ['min', 'max'])) {
                    $arr[$rule] = $rule.' = '.$value;
                }
            }
            if (count($arr) > 2 ) {
                throw new Exception("Size validation has more than 2 values");
            }
            if (count($arr) > 0) {
                $this->imports[] = self::SIZE;
                $content = "\t@Size(". implode(', ', $arr).')'.self::ENTER;
            }
        }
        return $content;
    }

    function getImports() {
        return $this->imports;
    }
    
    function getContent(): string {
        $content = self::ENTER;
        $content.= "\t@Column(nullable = false)".self::ENTER;
        $content.= $this->getValidation();
        $content.= "\tvar $this->name: ".$this->getType();
        return $content;
    }
}
