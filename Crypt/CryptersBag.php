<?php
namespace Neilime\Bundle\CryptBundle\Crypt;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class CryptersBag
{
    /**
     * @var array
     */
    private $crypters = array();

    /**
     * @param CrypterInterface $crypter
     */
    public function addCrypter(CrypterInterface $crypter)
    {
        $this->crypters[ $crypter->getName() ] = $crypter;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->crypters;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getCrypter(string $name)
    {
        if(isset($this->crypters[ $name ]))
            return $this->crypters[ $name ];

        return null;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function decrypt($value){

        /** @var CrypterInterface $crypter */
        foreach($this->crypters as $crypter){
            if($crypter->canDecrypt($value)){
                return $crypter->decrypt($value);
            }
        }
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function crypt($value){

        /** @var CrypterInterface $crypter */
        foreach($this->crypters as $crypter){
            if($crypter->canCrypt($value)){
                return $crypter->crypt($value);
            }
        }
        return $value;
    }
}
