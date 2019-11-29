<?php
namespace Neilime\Bundle\CryptBundle\Crypt;

use Neilime\Bundle\CryptBundle\Client\ClientInterface;

class Crypter implements CrypterInterface {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * CrypterInterface constructor.
     * @param $name
     * @param $prefix
     * @param ClientInterface $client
     */
    public function __construct($name, $prefix, ClientInterface $client)
    {
        $this->setName($name);
        $this->setPrefix($prefix);
        $this->setClient($client);
    }

    /**
     * @param $value
     * @return bool
     */
    public function canDecrypt($value)
    {
        return $this->getPrefix() == substr($value, 0, strlen($this->getPrefix()));
    }

    /**
     * @param $value
     * @return mixed
     */
    public function decrypt($value)
    {
        $value = substr($value, strlen($this->getPrefix()));

        return $this->getClient()->decrypt($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function canCrypt($value)
    {
        return $this->getPrefix() == substr($value, 0, strlen($this->getPrefix()));
    }

    /**
     * @param $value
     * @return mixed
     */
    public function crypt($value)
    {
        $value = substr($value, strlen($this->getPrefix()));

        return $this->getClient()->crypt($value);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Crypter
     */
    public function setName(string $name): Crypter
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return Crypter
     */
    public function setPrefix(string $prefix): Crypter
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     * @return Crypter
     */
    public function setClient(ClientInterface $client): Crypter
    {
        $this->client = $client;
        return $this;
    }
}