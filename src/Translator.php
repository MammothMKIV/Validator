<?php

namespace MammothMKIV\Validator;

interface Translator
{
    /**
     * @param string $string
     * @return string
     */
    public function translate($string);
}