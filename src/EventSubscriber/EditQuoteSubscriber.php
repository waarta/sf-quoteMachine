<?php

namespace App\EventSubscriber;

use App\Event\QuoteEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EditQuoteSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onQuoteEdit(QuoteEvent $event)
    {
        $quote = $event->getQuote();
        $this->logger->info('Quote edit:' . $quote->getId());
    }

    public static function getSubscribedEvents()
    {
        return array(
            'quote.edit' => 'onQuoteEdit',
        );
    }

}
