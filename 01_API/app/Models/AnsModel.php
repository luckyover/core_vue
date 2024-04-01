<?php

namespace App\Models;

class AnsModel
{
    public function __construct(array $input = [])
    {
        foreach ($input as $key => $val) {
            $isClass = false;
            if (isset($this->$key)) {
                if (is_object($this->$key)) {
                    $className = get_class($this->$key);
                    $this->$key = new $className($val);
                    $isClass = true;
                }
            }
            if (!$isClass) {
                if (isset($this->$key) &&
                    $val === null
                ) {
                    if (is_int($this->$key) || is_float($this->$key)) {
                        $this->$key = 0;
                    } if (is_string($this->$key)) {
                        $this->$key = '';
                    } else {
                        $this->$key = $val;
                    }
                } else {
                    $this->$key = $val;
                }
            }
        }
    }
}
