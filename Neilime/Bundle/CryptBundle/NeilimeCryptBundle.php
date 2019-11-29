<?php

namespace Neilime\Bundle\CryptBundle;

use Neilime\Bundle\CryptBundle\DependencyInjection\Compiler\CryptCompilerPass;
use Neilime\Bundle\CryptBundle\DependencyInjection\Compiler\DecryptConfigCompilerPass;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NeilimeCryptBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CryptCompilerPass());
        $container->addCompilerPass(new DecryptConfigCompilerPass());
    }
}
