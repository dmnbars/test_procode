<?php

namespace App;

class Messages
{
    /**
     * @var array $messages
     */
    private $messages;

    /**
     * @var string $language
     */
    private $language;

    /**
     * @var string $fallbackLanguage
     */
    private $fallbackLanguage;

    /**
     * @param $messages
     * @param $language
     * @param $fallbackLanguage
     */
    public function __construct(array $messages, $language, $fallbackLanguage)
    {
        $this->messages = $messages;
        $this->language = $language;
        $this->fallbackLanguage = $fallbackLanguage;
    }

    public function get($message)
    {
        if (isset($this->messages[$this->language][$message])) {
            return $this->messages[$this->language][$message];
        }

        if (isset($this->messages[$this->fallbackLanguage][$message])) {
           return $this->messages[$this->fallbackLanguage][$message];
        }

        return $message;
    }
}
