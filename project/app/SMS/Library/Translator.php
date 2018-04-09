<?php

namespace App\SMS\Library;

use Stichoza\GoogleTranslate\TranslateClient;

class Translator
{
    /**
     * @var TranslateClient
     */
    private $translateClient;

    /**
     * Translator constructor.
     * @param TranslateClient $translateClient
     */
    public function __construct(TranslateClient $translateClient)
    {
        $this->translateClient = $translateClient;
    }

    public function translate($target, $content)
    {
        return $this->translateClient
            ->setSource('en')
            ->setTarget($target)
            ->translate($content);
    }

    public function convert($source, $target, $content)
    {
        return $this->translateClient
            ->setSource($source)
            ->setTarget($target)
            ->translate($content);
    }

    public function getTheSource($target, $content)
    {
        $this->translateClient
            ->setSource(null)
            ->setTarget($target)
            ->translate($content);
        return $this->translateClient->getLastDetectedSource();
    }
}
