<?php
namespace Neilime\Bundle\CryptBundle\Crypt;

use Neilime\Bundle\CryptBundle\Client\ClientInterface;

interface CrypterInterface{

    /**
     * CrypterInterface constructor.
     * @param $name
     * @param $prefix
     * @param ClientInterface $client
     */
    public function __construct($name, $prefix, ClientInterface $client);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return CrypterInterface
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getPrefix();

    /**
     * @param string $prefix
     * @return CrypterInterface
     */
    public function setPrefix(string $prefix);

    /**
     * @return ClientInterface
     */
    public function getClient();

    /**
     * @param ClientInterface $client
     * @return CrypterInterface
     */
    public function setClient(ClientInterface $client);

    /**
     * @param $value
     * @return bool
     */
    public function canDecrypt($value);

    /**
     * @param $value
     * @return mixed
     */
    public function decrypt($value);

    /**
     * @param $value
     * @return bool
     */
    public function canCrypt($value);

    /**
     * @param $value
     * @return mixed
     */
    public function crypt($value);
}