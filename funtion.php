<?php

function get_var_name($var)
{
    foreach ($GLOBALS as $var_name => $value) {
        if ($value === $var) {
            return $var_name;
        }
    }
    return false;
}

function extract_get($index)
{
    if (!empty($_GET[$index])) {
        return $GLOBALS[$index] = $_GET[$index];
    } else {
        return $GLOBALS[$index] = null;
    }
}

