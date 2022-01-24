<?php
declare(strict_types=1);

namespace DiscordWebhookBundle\ArgumentResolver;

use DiscordWebhookBundle\DiscordWebhook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Traversable;
use function Symfony\Component\String\u;

/**
 * Class ClientValueResolver
 *
 * @package DiscordWebhookBundle\ArgumentResolver
 */
class ClientValueResolver implements ArgumentValueResolverInterface
{
    private array $clients;

    public function __construct(Traversable $clients)
    {
        $this->clients = iterator_to_array($clients);
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return DiscordWebhook::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $requestedServiceName = (string)u($argument->getName())->camel()->lower();

        foreach ($this->clients as $serviceId => $client) {
            $normalizedId = (string)u($serviceId)->camel()->lower();
            if ($normalizedId === $requestedServiceName) {
                yield $client;
            }
        }

        yield $this->clients[DiscordWebhook::class];
    }
}
