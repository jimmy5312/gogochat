<?php

namespace GogoChat;

/**
 * This base class transform
 */
class BaseObject {
    function __construct($data = []) {
        $params = get_object_vars($this);
        foreach ($params as $key => $value) {
            $this->$key = $data[snake_case($key)] ?? null;
        }
    }
    // function __toString() {
    //     return [$this];
    // }
}