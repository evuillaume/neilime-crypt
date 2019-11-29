<?php

namespace Neilime\Bundle\CryptBundle\DependencyInjection\Compiler;

use Neilime\Bundle\CryptBundle\Crypt\CryptersBag;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class DecryptConfigCompilerPass implements CompilerPassInterface
{
    /**
     * @var CryptersBag
     */
    private $cryptersBag;

    public function process(ContainerBuilder $container)
    {
        if(
            !$container->hasParameter('neilime.crypt.enabled')
            || false === boolval($container->getParameter('neilime.crypt.enabled'))
        ){
            return;
        }

        if (!$container->hasDefinition('neilime.crypt.crypters_bag')) {
            return;
        }

        $this->cryptersBag = $container->get('neilime.crypt.crypters_bag');

        foreach($container->getParameterBag()->all() as $key => $parameters){
            if(is_array($parameters)){
                array_walk_recursive(
                    $parameters,
                    function (&$value) {
                        $value = $this->getDecrypteValue($value);
                    }
                );
                $container->setParameter($key, $parameters);
            }else{
                $container->setParameter($key, $this->getDecrypteValue($parameters));
            }
        }
    }

    /**
     * @param $value
     * @return mixed|null
     */
    private function getDecrypteValue($value)
    {
        return $this->cryptersBag->decrypt($value);
    }
}
