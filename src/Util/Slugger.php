<?php

namespace App\Util;

use App\Util\SluggerInterface;

class Slugger implements SluggerInterface
{
    public static function slugify(string $string): string
    {
        $string = strtolower($string);
        $string = trim($string);
        $string = str_replace(" ", "-", $string);

        return $string;
    }
}
