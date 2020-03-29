<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Determines if the given string contains the given value
     *
     * @param string $haystack
     * @param string $needle
     * 
     * @return bool
     */
    public static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Escape a string
     *
     * @param string $string
     * 
     * @return string
     */
    public static function escape($string)
    {
        $string = trim($string);
        $string = htmlspecialchars($string);
        $string = stripslashes($string);

        return $string;
    }
}
