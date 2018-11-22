<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EditQuoteSubscriber implements EventSubscriberInterface
{
    public function onQuoteEdit(CreateQuoteEvent $event)
    {
        $returnValue = $event->getReturnValue();
        // modify the original ``$returnValue`` value

        $event->setReturnValue($returnValue);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'quote.edit' => 'onQuoteEdit',
        );
    }

}
