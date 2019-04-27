<?php

declare(strict_types=1);

namespace AppBundle\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use AppBundle\Exception\RedirectException;

class RedirectListener
{

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $redirectException = $this->getRedirectException($event);

        if (!$redirectException) {
            return;
        }

        $response = new RedirectResponse($redirectException->getUrl(), $redirectException->getCode(), $redirectException->getHeaders());

        foreach ($redirectException->getCookies() as $cookie) {
            $response->headers->setCookie($cookie);
        }

        $event->setResponse($response);
    }

    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return RedirectException|\Exception|null
     */
    private function getRedirectException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof RedirectException) {
            $exception = $event->getException()->getPrevious();
        }

        return $exception instanceof RedirectException ? $exception : null;
    }

}
