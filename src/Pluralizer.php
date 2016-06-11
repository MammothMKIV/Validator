<?php

namespace MammothMKIV\Validator;

interface Pluralizer
{
    /**
     * @param string $string
     * @param string $locale
     * @return string
     */
    public function pluralize($string, $locale);
}