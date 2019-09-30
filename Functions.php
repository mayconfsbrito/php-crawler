<?php

class Functions
{
    private static $replacements = [
        'a' => 'z',
        'b' => 'y',
        'c' => 'x',
        'd' => 'w',
        'e' => 'v',
        'f' => 'u',
        'g' => 't',
        'h' => 's',
        'i' => 'r',
        'j' => 'q',
        'k' => 'p',
        'l' => 'o',
        'm' => 'n',
        'n' => 'm',
        'o' => 'l',
        'p' => 'k',
        'q' => 'j',
        'r' => 'i',
        's' => 'h',
        't' => 'g',
        'u' => 'f',
        'v' => 'e',
        'w' => 'd',
        'x' => 'c',
        'y' => 'b',
        'z' => 'a',
        '0' => '9',
        '1' => '8',
        '2' => '7',
        '3' => '6',
        '4' => '5',
        '5' => '4',
        '6' => '3',
        '7' => '2',
        '8' => '1',
        '9' => '0'
    ];
    
    public static function getResult($token): string
    {
        $chars = str_split($token);
        $e = $chars;
        for ($t = 0; $t < count($chars); $t++) {
            $char = $e[$t];
            $e[$t] = (array_key_exists($t, $e)) ? self::$replacements[$char] : $char;
        }
        $resultArray = implode("", $e);

        return $resultArray;
    }
}