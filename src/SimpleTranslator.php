<?php

namespace MammothMKIV\Validator;

class SimpleTranslator implements Translator
{
    /**
     * @var Pluralizer
     */
    private $pluralizer;

    /**
     * @var string
     */
    private $locale;

    /**
     * PlainTranslator constructor.
     * @param string $locale
     * @param Pluralizer|null $pluralizer
     */
    public function __construct($locale = 'en', Pluralizer $pluralizer = null)
    {
        if ($this->pluralizer) {
            $this->pluralizer = $pluralizer;
        } else {
            $this->pluralizer = new SimplePluralizer();
        }

        $this->locale = $locale;
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
     * @return string
     * @internal param string $locale
     */
    public function translate($string)
    {
        return $this->pluralizer->pluralize($string, $this->locale);
    }
}