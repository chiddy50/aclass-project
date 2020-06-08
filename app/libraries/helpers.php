<?php

class Helpers
{
    public static function generate_filename($strength = 17) {

        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $filename = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $filename .= $random_character;
        }
        return $filename;
    }
}
