<?php
/**
 * @author Mamaev Yuriy (eXeCUT)
 * @link https://github.com/execut
 * @copyright Copyright (c) 2020 Mamaev Yuriy (eXeCUT)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace execut\peopleFinder\Name\Comparator;


use execut\peopleFinder\Name\Name;
use execut\peopleFinder\NamesNormalizer\Normalizer;

class Comparator
{
    public function compare(Name $nameA, Name $nameB): float
    {
        if (!$this->compareSurnames($nameA, $nameB)) {
            return 0.0;
        }

        $firstnameA = $nameA->getFirstname();
        $firstnameA = $this->normalizeName($firstnameA);
        $firstnameB = $nameB->getFirstname();
        $firstnameB = $this->normalizeName($firstnameB);
        $fullnameA = null;
        $fullnameB = null;
        if ($firstnameA !== null && $firstnameB !== null) {
            $fullnameA .= $firstnameA;
            $fullnameB .= $firstnameB;
        }

        $secondnameA = $nameA->getSecondname();
        $secondnameB = $nameB->getSecondname();
        if ($secondnameA !== null && $secondnameB !== null) {
            $fullnameA .= $secondnameA;
            $fullnameB .= $secondnameB;
        }

        $fullnameA = $this->replaceEqualChars($fullnameA);
        $fullnameB = $this->replaceEqualChars($fullnameB);

        $badChars = $this->levenshtein_utf8($fullnameA, $fullnameB);

        if ($badChars > 3) {
            return 0.0;
        }

        if (mb_strlen($fullnameA) > mb_strlen($fullnameB)) {
            $maxLen = mb_strlen($fullnameA);
        } else {
            $maxLen = mb_strlen($fullnameB);
        }

        return ($maxLen - $badChars) / $maxLen * 100;
    }

    protected ?Normalizer $normalizer = null;
    protected function normalizeName($name)
    {
        if ($this->normalizer === null) {
            $this->normalizer = new Normalizer();
        }

        $result = $this->normalizer->normalize($name);
        if ($result === null) {
            $result = $name;
        }

        return $result;
    }

    protected function compareSurnames(Name $nameA, Name $nameB): bool
    {
        $surnamesB = $surnamesA = [];
        if (($surnameA = $nameA->getSurname()) !== null) {
            $surnamesA[] = $surnameA;
        }

        if (($secondSurnameA = $nameA->getSecondSurname()) !== null) {
            $surnamesA[] = $secondSurnameA;
        }

        if (($surnameA = $nameA->getSurnameAtBirth()) !== null) {
            $surnamesA[] = $surnameA;
        }

        if (($surnameB = $nameB->getSurname()) !== null) {
            $surnamesB[] = $surnameB;
        }

        if (($secondSurnameB = $nameB->getSecondSurname()) !== null) {
            $surnamesB[] = $secondSurnameB;
        }

        if (($surnameB = $nameB->getSurnameAtBirth()) !== null) {
            $surnamesB[] = $surnameB;
        }

        if (empty($surnamesA) || empty($surnamesB)) {
            return true;
        }

        $surnamesB = array_map(function ($v) {
            return $this->replaceEqualChars($v);
        }, $surnamesB);

        foreach ($surnamesA as $surnameA) {
            $surnameA = $this->replaceEqualChars($surnameA);
            if (in_array($surnameA, $surnamesB)) {
                return true;
            }
        }

        return false;
    }

    protected function replaceEqualChars(string $string)
    {
        $string = $this->toLowerCase($string);

        return str_replace('ё', 'е', $string);
    }

    protected function utf8_to_extended_ascii($str, &$map)
    {
        // find all multibyte characters (cf. utf-8 encoding specs)
        $matches = [];
        if (!preg_match_all('/[\xC0-\xF7][\x80-\xBF]+/', $str, $matches))
            return $str; // plain ascii string

        // update the encoding map with the characters not already met
        foreach ($matches[0] as $mbc)
            if (!isset($map[$mbc]))
                $map[$mbc] = chr(128 + count($map));

        // finally remap non-ascii characters
        return strtr($str, $map);
    }

    protected function levenshtein_utf8($s1, $s2)
    {
        $charMap = [];
        $s1 = $this->utf8_to_extended_ascii($s1, $charMap);
        $s2 = $this->utf8_to_extended_ascii($s2, $charMap);

        return levenshtein($s1, $s2);
    }

    protected function calculateEqualChars(?string $a, ?string $b):?int
    {
        $result = 0;
        if ($a === null) {
            return null;
        }

        if ($b === null) {
            return null;
        }

        $aChars = mb_str_split($a, 1);
        $bChars = mb_str_split($b, 1);
        return $this->getMaxStringLengthFromCharsArray($aChars, $bChars);
//        $diff1 = array_diff($aChars, $bChars);
//        $diff2 = array_diff($bChars, $aChars);
//        if (empty($diff1)) {
//            $diff = $diff2;
//        } else {
//            $diff = $diff1;
//        }
//
//        if (count($aChars) > count($bChars)) {
//            $totalCount = count($aChars);
//        } else {
//            $totalCount = count($bChars);
//        }

//        return $totalCount - count($diff);
    }

    protected function toLowerCase($name)
    {
        return mb_strtolower($name);
    }
}