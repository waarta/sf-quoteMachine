<?php

namespace App\EventSubscriber;

use App\Event\CreateQuoteEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreateQuoteSubscriber implements EventSubscriberInterface
{
    public function onQuoteCreate(CreateQuoteEvent $event)
    {
        $returnValue = $event->getReturnValue();
        // modify the original ``$returnValue`` value

        $event->setReturnValue($returnValue);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'quote.create' => 'onQuoteCreate',
        );
    }

}
