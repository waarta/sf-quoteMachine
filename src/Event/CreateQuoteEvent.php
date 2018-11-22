<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class CreateQuoteEvent extends Event
{
    private $returnValue;

    public function __construct($returnValue)
    {
        $this->returnValue = $returnValue;
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }

    public function setReturnValue($returnValue)
    {
        $this->returnValue = $returnValue;
    }
}
