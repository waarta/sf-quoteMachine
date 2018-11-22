<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeleteQuoteSubscriber implements EventSubscriberInterface
{
    public function onQuoteDelete(CreateQuoteEvent $event)
    {
        $returnValue = $event->getReturnValue();
        // modify the original ``$returnValue`` value

        $event->setReturnValue($returnValue);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'quote.delete' => 'onQuoteDelete',
        );
    }

}
