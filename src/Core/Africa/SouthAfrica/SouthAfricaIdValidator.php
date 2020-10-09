<?php

namespace Reducktion\Socrates\Core\Africa\SouthAfrica;

use Illuminate\Support\Str;
use Reducktion\Socrates\Contracts\IdValidator;
use Reducktion\Socrates\Exceptions\InvalidLengthException;

class SouthAfricaIdValidator implements IdValidator
{
    public function validate(string $id): bool
    {
        //source: https://knowles.co.za/generating-south-african-id-numbers/
        $id = $this->sanitize($id);
        $lastDigit = (int)$id[-1];

        $numberSection = substr($id, 0, -1);

        $digit = $this->generateLuhnDigit($numberSection);

        return $lastDigit == $digit;
    }

    private function generateLuhnDigit (string $input) {
        $total = 0;
        $count = 0;

        for ($i = 0; $i < Str::length($input); $i++) {
            $multiple = ($count % 2) + 1;
            $count++;
            $temp = $multiple * (int)$input[$i];
            $temp = (int) floor($temp / 10) + ($temp % 10);
            $total += $temp;
        }

        $total = ($total * 9) % 10;

        return $total;
    }

    private function sanitize(string $id): string
    {
        $id = preg_replace('/[^0-9]/', '', $id);

        $idLength = strlen($id);

        if ($idLength !== 13) {
            throw new InvalidLengthException('South Africa ID', '13', $idLength);
        }

        return $id;
    }
}
