<?php

namespace MammothMKIV\Validator;

class SimplePluralizer implements Pluralizer
{
    /**
     * @var string
     */
    private $delimiter = '|';

    /**
     * @var string
     */
    private $edgeSequence = '||||';

    /**
     * @param string $string
     * @param string $locale
     * @return string
     */
    public function pluralize($string, $locale)
    {
        $matches = array();
        $edgeSequence = preg_quote($this->edgeSequence);

        preg_match_all('/' . $edgeSequence . '([0-9]+.*?)' . $edgeSequence . '/', $string, $matches);

        if (count($matches) === 0) {
            return $string;
        }

        $groupedMatches = array();

        for ($i = 0; $i < count($matches[0]); $i++) {
            $groupedMatches[$matches[0][$i]] = $matches[1][$i];
        }

        $replacements = array();

        foreach ($groupedMatches as $match => $data) {
            $meta = explode($this->delimiter, $data);

            if (count($meta) < 2) {
                break;
            }

            $number = (int)array_shift($meta);

            $replacements[$match] = $number . ' ' . $this->doPluralize($number, $meta, $locale);
        }

        return str_replace(array_keys($replacements), array_values($replacements), $string);
    }

    /**
     * @param string $delimiter
     * @return Pluralizer
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @param string $edgeSequence
     * @return Pluralizer
     */
    public function setEdgeSequence($edgeSequence)
    {
        $this->edgeSequence = $edgeSequence;
        return $this;
    }

    /**
     * @param int $number
     * @param array $forms
     * @param string $locale
     * @return string
     */
    private function doPluralize($number, $forms, $locale) {
        $numeric = abs((int)$number);

        if ($locale === 'ru') {
            $one = $forms[0];
            $two = $forms[1];
            $many = $forms[2];

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
        } else {
            $one = $forms[0];
            $many = $forms[1];

            switch (true) {
                case ($numeric % 100 == 1 || ($numeric % 100 > 20) && ($numeric % 10 == 1)):
                    return $one;
                    break;
                case ($numeric % 100 == 2 || ($numeric % 100 > 20) && ($numeric % 10 == 2)):
                    return $many;
                    break;
                case ($numeric % 100 == 3 || ($numeric % 100 > 20) && ($numeric % 10 == 3)):
                    return $many;
                    break;
                case ($numeric % 100 == 4 || ($numeric % 100 > 20) && ($numeric % 10 == 4)):
                    return $many;
                    break;
                default:
                    return $many;
            }
        }
    }
}