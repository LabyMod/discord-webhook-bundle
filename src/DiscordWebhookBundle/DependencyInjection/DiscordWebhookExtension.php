<?php
declare(strict_types=1);

namespace DiscordWebhookBundle\DependencyInjection;

use DiscordWebhookBundle\DiscordWebhook;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DiscordWebhookExtension
 *
 * @package DiscordWebhookBundle\DependencyInjection
 */
class DiscordWebhookExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Configure the default client
        $container
            ->register(DiscordWebhook::class, DiscordWebhook::class)
            ->setPublic(true)
            ->setArgument('$url', $config['default_url'])
            ->addTag('discord_webhook.client', ['key' => DiscordWebhook::class]);

        // configure the additional named clients
        $this->configureClients($config, $container, $loader);
    }

    private function configureClients(array $config, ContainerBuilder $container, FileLoader $loader): void
    {
        if (count($config['clients']) === 0) {
            return;
        }

        foreach ($config['clients'] as $name => $clientConfig) {
            $container
                ->register($name, DiscordWebhook::class)
                ->setPublic(true)
                ->setArgument('$url', $clientConfig['webhook_url'])
                ->addMethodCall('setUsername', [$clientConfig['username']])
                ->addMethodCall('setAvatar', [$clientConfig['avatar_url']])
                ->addTag('discord_webhook.client', ['key' => $name]);
        }
    }
}
