<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ThemeBundle\Configuration\Test;

use Sylius\Bundle\ThemeBundle\Configuration\ConfigurationSourceFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

final class TestConfigurationSourceFactory implements ConfigurationSourceFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildConfiguration(ArrayNodeDefinition $node): void
    {
        // no configuration
    }

    /**
     * {@inheritdoc}
     */
    public function initializeSource(ContainerBuilder $container, array $config): Definition
    {
        $container->setDefinition(
            'sylius.theme.test_theme_configuration_manager',
            new Definition(TestThemeConfigurationManager::class, [
                new Reference('sylius.theme.configuration.processor'),
                new Parameter('kernel.cache_dir'),
            ])
        )->setPublic(true);

        return (new Definition(TestConfigurationProvider::class, [
            new Reference('sylius.theme.test_theme_configuration_manager'),
        ]))->setPublic(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'test';
    }
}
