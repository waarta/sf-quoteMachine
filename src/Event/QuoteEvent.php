<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class QuoteEvent extends Event
{
    private $quote;

    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function setQuote($quote)
    {
        $this->quote = $quote;
    }
}
