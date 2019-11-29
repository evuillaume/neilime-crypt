<?php

namespace Neilime\Bundle\CryptBundle\Command;

use Neilime\Bundle\CryptBundle\Crypt\CrypterInterface;
use Neilime\Bundle\CryptBundle\Crypt\CryptersBag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('neilime:crypt:list')
            ->setDescription('List available crypters')
            ;

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CryptersBag $cryptersBag */
        $cryptersBag = $this->getContainer()->get('neilime.crypt.crypters_bag');

        $table = new Table($output);
        $table->setHeaders([
            'Crypter Name',
            'Prefix',
            'Client Classname'
        ]);

        /**
         * @var  $crypter CrypterInterface
         */
        foreach($cryptersBag->getAll() as $crypter){
            $table->addRow([
                $crypter->getName(),
                $crypter->getPrefix(),
                get_class($crypter->getClient())
            ]);
        }

        $table->render();
    }
}
