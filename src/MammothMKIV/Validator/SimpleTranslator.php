<?php

namespace MammothMKIV\Validator;

class SimpleTranslator implements Translator
{
    /**
     * @var Pluralizer
     */
    private $pluralizer;

    /**
     * PlainTranslator constructor.
     * @param Pluralizer|null $pluralizer
     */
    public function __construct(Pluralizer $pluralizer = null)
    {
        if ($this->pluralizer) {
            $this->pluralizer = $pluralizer;
        } else {
            $this->pluralizer = new SimplePluralizer();
        }
    }

    /**
     * @param Pluralizer $pluralizer
     */
    public function setPluralizer(Pluralizer $pluralizer)
    {
        $this->pluralizer = $pluralizer;
    }

    /**
     * @param string $string
     * @param string $locale
     * @return string
     */
    public function translate($string, $locale)
    {
        return $this->pluralizer->pluralize($string, $locale);
    }
}