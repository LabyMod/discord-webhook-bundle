<?php
declare(strict_types=1);

namespace DiscordWebhookBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package DiscordWebhookBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('discord_webhook');
        $rootNode = $treeBuilder->getRootNode();

        // @formatter:off
        $rootNode
            ->children()
                ->scalarNode('default_url')
                    ->info('The Webhook URL for the default service.')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('clients')
                    ->useAttributeAsKey('name')
                    ->normalizeKeys(false)
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('webhook_url')
                                ->info('The Discord Webhook URL for this client.')
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('username')
                                ->info('The username for the Discord bot.')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('avatar_url')
                                ->info('URL which is used for the Bot avatar.')
                                ->defaultNull()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        // @formatter:on

        return $treeBuilder;
    }
}
