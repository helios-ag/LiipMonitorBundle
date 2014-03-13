<?php

namespace Liip\MonitorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Lukas Kahwe Smith <smith@pooteeweet.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('liip_monitor', 'array');

        $rootNode
            ->children()
                ->booleanNode('enable_controller')->defaultFalse()->end()
                ->arrayNode('checks')
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('php_extensions')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('php_flags')
                            ->info('Pairs of a PHP setting and an expected value')
                            ->example('session.use_only_cookies: false')
                            ->useAttributeAsKey('setting')
                            ->prototype('scalar')->defaultValue(true)->end()
                        ->end()
                        ->arrayNode('php_version')
                            ->info('Pairs of a version and a comparison operator')
                            ->example('5.4.15: >=')
                            ->useAttributeAsKey('version')
                            ->prototype('scalar')->end()
                        ->end()
                        ->variableNode('process_running')
                            ->info('Process name/pid or an array of process names/pids.')
                            ->example('[apache, foo]')
                        ->end()
                        ->arrayNode('readable_directory')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('writable_directory')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('class_exists')
                            ->example('["Lua", "My\Fancy\Class"]')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('cpu_performance')
                            ->info('Benchmark CPU performance and return failure if it is below the given ratio.')
                            ->example('1.0 # This is the power of an EC2 micro instance')
                        ->end()
                        ->arrayNode('disk_usage')
                            ->children()
                                ->integerNode('warning')->defaultValue(70)->end()
                                ->integerNode('critical')->defaultValue(90)->end()
                                ->scalarNode('path')->defaultValue('%kernel.cache_dir%')->end()
                            ->end()
                        ->end()
                        ->arrayNode('symfony_requirements')
                            ->children()
                                ->scalarNode('file')->defaultValue('%kernel.root_dir%/SymfonyRequirements.php')->end()
                            ->end()
                        ->end()
                        ->arrayNode('apc_memory')
                            ->children()
                                ->integerNode('warning')->defaultValue(70)->end()
                                ->integerNode('critical')->defaultValue(90)->end()
                            ->end()
                        ->end()
                        ->arrayNode('apc_fragmentation')
                            ->children()
                                ->integerNode('warning')->defaultValue(70)->end()
                                ->integerNode('critical')->defaultValue(90)->end()
                            ->end()
                        ->end()
                        ->variableNode('doctrine_dbal')
                            ->defaultNull()
                            ->info('Connection name or an array of connection names.')
                            ->example('[default, crm]')
                        ->end()
                        ->arrayNode('memcache')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('host')->defaultValue('localhost')->end()
                                    ->integerNode('port')->defaultValue(11211)->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('redis')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('host')->defaultValue('localhost')->end()
                                    ->integerNode('port')->defaultValue(6379)->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('http_service')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('host')->defaultValue('localhost')->end()
                                    ->integerNode('port')->defaultValue(80)->end()
                                    ->scalarNode('path')->defaultValue('/')->end()
                                    ->integerNode('status_code')->defaultValue(200)->end()
                                    ->scalarNode('content')->defaultNull()->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('rabbit_mq')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('host')->defaultValue('localhost')->end()
                                    ->integerNode('port')->defaultValue(5672)->end()
                                    ->scalarNode('user')->defaultValue('guest')->end()
                                    ->scalarNode('password')->defaultValue('guest')->end()
                                    ->scalarNode('vhost')->defaultValue('/')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->booleanNode('symfony_version')->end()
                        ->arrayNode('custom_error_pages')
                            ->children()
                                ->arrayNode('error_codes')
                                    ->isRequired()
                                    ->requiresAtLeastOneElement()
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('path')->defaultValue('%kernel.root_dir%')->end()
                                ->scalarNode('controller')->defaultValue('%twig.exception_listener.controller%')->end()
                            ->end()
                        ->end()
                        ->arrayNode('security_advisory')
                            ->children()
                                ->scalarNode('lock_file')->defaultValue('%kernel.root_dir%' . '/../composer.lock')->end()
                            ->end()
                        ->end()
                        ->arrayNode('stream_wrapper_exists')
                            ->example('[\'zlib\', \'bzip2\', \'zip\']')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}
