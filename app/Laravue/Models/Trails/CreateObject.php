<?php

namespace App\Laravue\Models\Trails;

trait CreateObject
{
    function create_object($data)
    {
        $array = $this->getFillable();
        foreach ($array as $key) {
            if (isset($data[$key])) {
                $this->{$key} = $data[$key];
            } else
                continue;
        }
    }
}
