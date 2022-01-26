<?php
declare(strict_types=1);

namespace DiscordWebhookBundle;

use DiscordWebhook\Webhook;
use GuzzleHttp\Client;

/**
 * Class DiscordWebhook
 *
 * @package DiscordWebhookBundle
 */
class DiscordWebhook extends Webhook
{
    private string $serviceName;

    public function __construct(array|string $url = [], string $serviceName = DiscordWebhook::class)
    {
        parent::__construct($url);

        $this->serviceName = $serviceName;
    }

    public function send(): bool
    {
        $status = parent::send(false);
        $ignoredFields = [];

        if ($this->serviceName !== DiscordWebhook::class) {
            $ignoredFields = ['username', 'avatarUrl'];
        }

        $this->reset($ignoredFields);

        return $status;
    }

    public function setUrl(string $webhook): void
    {
        $this->getClients()->add(new Client([
            'base_uri' => $webhook
        ]));
    }
}
