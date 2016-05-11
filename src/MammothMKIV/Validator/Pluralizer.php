<?php
/**
 * Created by IntelliJ IDEA.
 * User: mammo
 * Date: 5/10/2016
 * Time: 8:21 PM
 */

namespace MammothMKIV\Validator;


class Pluralizer
{
    public static function pluralize($number, $many, $one, $two) {
        $numeric = abs((int)$number);

        switch (true) {
            case ($numeric % 100 == 1 || ($numeric % 100 > 20) && ($numeric % 10 == 1)):
                return $one;
                break;
            case ($numeric % 100 == 2 || ($numeric % 100 > 20) && ($numeric % 10 == 2)):
                return $two;
                break;
            case ($numeric % 100 == 3 || ($numeric % 100 > 20) && ($numeric % 10 == 3)):
                return $two;
                break;
            case ($numeric % 100 == 4 || ($numeric % 100 > 20) && ($numeric % 10 == 4)):
                return $two;
                break;
            default:
                return $many;
        }
    }
}