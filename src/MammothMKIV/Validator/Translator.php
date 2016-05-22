<?php

namespace MammothMKIV\Validator;

interface Translator
{
    /**
     * @param string $string
     * @param string $locale
     * @return string
     */
    public function translate($string, $locale);
}