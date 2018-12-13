<?php

namespace App\EventSubscriber;

use App\Event\QuoteEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeleteQuoteSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onQuoteDelete(QuoteEvent $event)
    {
        $quote = $event->getQuote();
        $this->logger->info('Quote delete:' . $quote->getId());

    }

    public static function getSubscribedEvents()
    {
        return array(
            'quote.delete' => 'onQuoteDelete',
        );
    }

}
