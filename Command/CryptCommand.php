<?php

namespace Neilime\Bundle\CryptBundle\Command;

use Neilime\Bundle\CryptBundle\Crypt\CrypterInterface;
use Neilime\Bundle\CryptBundle\Crypt\CryptersBag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CryptCommand extends ContainerAwareCommand
{
    const ACTION_CRYPT      = 'crypt';

    const ACTION_DECRYPT    = 'decrypt';

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $crypterName = null;

    /**
     * @var bool
     */
    private $json = false;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('neilime:crypt')
            ->setDescription('Crypt or Decrypt string')
            ->addArgument(
                'action',
                InputArgument::REQUIRED,
                'Crypt or Decrypt'
            )
            ->addArgument(
                'hash',
                InputArgument::REQUIRED,
                'The string to process'
            )
            ->addOption(
                "crypter",
                "-c",
                InputOption::VALUE_OPTIONAL,
                'Crypter name to use or empty to let the systeme to choose the right one based on hash prefix'
            )->addOption(
                "json",
                "-j",
                InputOption::VALUE_NONE,
                'Return json datas'
            );

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->action   = $input->getArgument("action");
        $this->hash     = $input->getArgument("hash");

        if($input->hasOption('crypter') && (null != $input->getOption('crypter')))
        {
            $this->crypterName = $input->getOption('crypter');
        }

        if($input->hasOption('json') && (null != $input->getOption('json')))
        {
            $this->json = true;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = null;
        switch ($this->action) {
            case self::ACTION_CRYPT:
                $result = $this->getProcessor()->crypt($this->hash);
                break;
            case self::ACTION_DECRYPT:
                $result = $this->getProcessor()->decrypt($this->hash);
                break;
        }

        if($this->json)
        {
            $data = array(
                'result' => $result
            );

            $response = new JsonResponse($data);
            $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            $output->write( $response->getContent() );

        }else{
            $output->write( $result );
        }
    }

    /**
     * @return object
     */
    private function getProcessor()
    {
        $cryptersBag = $this->getContainer()->get('neilime.crypt.crypters_bag');

        if (null != $this->crypterName) {

            $crypter = $cryptersBag->getCrypter($this->crypterName);
            if ($crypter instanceof CrypterInterface) {
                $this->hash = $crypter->getPrefix() . $this->hash;
                return $crypter;
            }
        }
        return $cryptersBag;
    }
}
