<?php
namespace Neilime\Bundle\CryptBundle\Client;

use Neilime\Bundle\CryptBundle\Exception\DecryptException;
use Neilime\Bundle\CryptBundle\Exception\EmptyDataException;
use phpseclib\Crypt\AES as SecLibAES;

/**
 * Class Crypter.
 */
class Aes implements ClientInterface
{
    /**
     * @var SecLibAES
     */
    private $cipher;

    /**
     * CoreCrypter constructor.
     *
     * @param $key
     * @param $iv
     */
    public function __construct($key, $iv)
    {
        $this->cipher = new SecLibAES();
        $this->cipher->setKey($key);
        $this->cipher->setIV($iv);
    }

    /**
     * @param $value
     * @return mixed|string|null
     * @throws DecryptException
     * @throws EmptyDataException
     */
    public function decrypt($value){

        if (empty($value) || is_null($value)) {
            throw new EmptyDataException("Data to decrypt is empty or null");
        }

        $decrypted = $this->cipher->decrypt( base64_decode($value) );

        if(false === $decrypted){
            throw new DecryptException("Decrypt error");
        }

        return $decrypted;
    }

    /**
     * @param $value
     * @return mixed|string|null
     * @throws EmptyDataException
     */
    public function crypt($value)
    {
        if (empty($value) || is_null($value)) {
            throw new EmptyDataException("Data to crypt is empty or null");
        }
        return base64_encode( $this->cipher->encrypt($value) );
    }
}
