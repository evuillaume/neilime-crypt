<?php

namespace Neilime\Bundle\CryptBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeilimeCryptExtension extends Extension implements ExtensionInterface
{
    public function getAlias()
    {
        return 'neilime_crypt';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        try {
            $loader->load('services.yml');
        }catch (\Exception $exception){}

        // Set all configurations in parameter to be able to retrieve it
        foreach ($config as $key => $value) {
            $container->setParameter('neilime.crypt.' . $key, $value);
        }
    }
}
