# Discord Webhook Bundle

Symfony Bundle for [labymod/discord-webhook](https://github.com/LabyMod/discord-webhook). Configure webhooks easily within your Symfony application

## Versions & Compatibility

| Release | Supported PHP Versions | Supported Symfony Versions | Release Date | Maintained | Branch |
|---------|------------------------|----------------------------|--------------|------------|--------|
| 1.x     | `^8.0`                 | `^5.0`, `^6.0`             | 24.01.2022   | Yes        | master |

## Installation

**Composer installation**
```bash
composer require labymod/discord-webhook-bundle
```

## Symfony configuration & usage
1. Enable your bundle in `config/bundles.php`:
    ```php
    return [
        // ...
        \DiscordWebhookBundle\DiscordWebhookBundle::class => ['all' => true],
    ]
    ```
2. Add a global and/or environment-based configuration file: `config/[env]/discord_webhook.yaml`

### Configuration reference
```yaml
# Default configuration
discord_webhook:
    default_url:          ~ # required, The Webhook URL for the default service.
    clients:
        # Prototype
        name: # choose a name (service-id) for your preconfigured client
            webhook_url:          ~ # required, The Discord Webhook URL for this client.
            username:             null # optional, The username for the Discord bot.
            avatar_url:           null # optional, URL which is used for the Bot avatar.
```

### Usage
#### Default Client
With `discord_webhook.default_url` configured, the basic service (`DiscordWebhookBundle\DiscordWebhook`) is configured and publicly available in the service container:

#### Additional named clients
If you have configured one or more named clients like below, you can access them in two ways by their name.
```yaml
discord_webhook
    # ...
    clients:
        announcements.client:
            webhook_url: 'https://discord.com/my/webhook/url'
```

Now this client is available as service too:
```php
use DiscordWebhookBundle\DiscordWebhook;

class MyController
{
   public function myAction(DiscordWebhook $announcementsClient) // <-- Thanks to an ArgumentValueResolver, name the parameter after your client, and it will be resolved automatically
   {
      // OR, resolve it from the container:
      $webhook = $this->container->get('announcements.client');
   }
}
```

## Documentation
For detailed documentation how to use the Webhooks, please refer to the underlying library:<br>
https://github.com/LabyMod/discord-webhook/blob/master/README.md

For further documentation have a look here:
* [Basics](https://github.com/LabyMod/discord-webhook/blob/master/docs/01_Basics.md)
* [Sending Files](https://github.com/LabyMod/discord-webhook/blob/master/docs/02_SendingFiles.md)
* [Embeds](https://github.com/LabyMod/discord-webhook/blob/master/docs/03_Embeds.md)
