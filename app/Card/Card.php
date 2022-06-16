<?php

namespace App\Zeus\App;

class CardValidation
{
    public function validateCardLuhn($attribute, $value, $parameters)
    {
//        return false;
        return $this->is_luhn_valid($value);
    }

    protected function digits_of($number)
    {
        return str_split($number);
    }

    protected function luhn_checksum($card)
    {
        $digits = $this->digits_of($card);
        $odd_digits = array_filter($digits, function($k){
            return ($k%2) != 0;
        }, ARRAY_FILTER_USE_KEY);
        $even_digits = array_filter($digits, function($k){
            return ($k%2) == 0;
        }, ARRAY_FILTER_USE_KEY);
        $total = array_sum($odd_digits);
        foreach($even_digits as $digit){
            $total += array_sum($this->digits_of(2 * $digit));
        }
        return $total % 10;
    }

    protected function is_luhn_valid($card)
    {
        return $this->luhn_checksum($card) == 0;
    }

    public function validateCardDate($attribute, $value, $parameters)
    {
        if($this->isValideDate($value)) {
            return $value;
        }

        return false;
    }

    public function isValideDate($dateValue)
    {
        $date = strtotime($dateValue);
        $today = strtotime(date('y-m-01'));

        if($date >= $today) {
            return true;
        }

        return false;
    }
}