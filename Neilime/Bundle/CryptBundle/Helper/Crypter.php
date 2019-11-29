<?php
namespace Neilime\Bundle\CryptBundle\Helper;

use Neilime\Bundle\CryptBundle\Crypt\CryptersBag;

/**
 * Class Crypter
 */
class Crypter
{
    /**
     * @var array
     */
    private $cache = array();

    /**
     * @var CryptersBag
     */
    private $crypters;

    /**
     * Crypter constructor.
     * @param CryptersBag $crypters
     */
    public function __construct(CryptersBag $crypters)
    {
        $this->crypters = $crypters;
        $this->cache = array();
    }

    /**
     * @param $value
     * @param bool $withCache
     * @return mixed|null
     */
    public function decrypt($value, $withCache = false)
    {
        if(!$withCache){
            return $this->crypters->decrypt($value);
        }
        return $this->getCache($value);
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function crypt($value)
    {
        return $this->crypters->crypt($value);
    }

    /**
     * @param $value
     * @return mixed|null
     */
    private function getCache($value)
    {
        if (isset($this->cache[$value])) {
            return $this->cache[$value];
        }

        $result = $this->crypters->decrypt($value);
        $this->setCache($value, $result);

        return $result;
    }

    /**
     * @param $value
     * @param $result
     * @return mixed|null
     */
    private function setCache($value, $result)
    {
        $this->cache[$value] = $result;
    }
}