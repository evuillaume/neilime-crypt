<?php

namespace Neilime\Bundle\CryptBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class CryptCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('neilime.crypt.crypters_bag')) {
            return;
        }

        $definition = $container->getDefinition(
            'neilime.crypt.crypters_bag'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'neilime.crypt.crypter'
        );

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addCrypter',
                array(new Reference($id))
            );
        }
    }
}
