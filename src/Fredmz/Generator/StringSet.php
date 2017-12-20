<?php
/**
 * Created by PhpStorm.
 * User: fmartinez
 * Date: 18/12/2017
 * Time: 11:02 AM
 */

namespace Fredmz\Generator;


class StringSet
{
    private $items = [];

    public function  add(string $value) {
        if (!in_array($value, $this->items)) {
            $this->items[] = $value;
        }
    }

    public function  addList(array $values)
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->items)) {
                $this->items[] = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function getItems(): array {
        return $this->items;
    }
}