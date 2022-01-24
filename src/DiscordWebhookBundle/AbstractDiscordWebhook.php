<?php
declare(strict_types=1);

namespace DiscordWebhookBundle;

use DiscordWebhook\Webhook;
use GuzzleHttp\Client;

/**
 * Class AbstractDiscordWebhook
 *
 * @package DiscordWebhookBundle
 */
abstract class AbstractDiscordWebhook extends Webhook
{
    public function __construct(array|string $url = [])
    {
        parent::__construct($url);
    }

    public function setUrl(string $webhook): void
    {
        $this->getClients()->add(new Client([
            'base_uri' => $webhook
        ]));
    }
}
