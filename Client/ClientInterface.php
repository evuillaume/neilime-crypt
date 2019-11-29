<?php
namespace Neilime\Bundle\CryptBundle\Client;

use Neilime\Bundle\CryptBundle\Exception\DecryptException;
use Neilime\Bundle\CryptBundle\Exception\EmptyDataException;

/**
 * Interface ClientInterface
 * @package Neilime\Bundle\CryptBundle\Client
 */
interface ClientInterface
{
    /**
     * @param $value
     * @return mixed|string|null
     * @throws DecryptException
     * @throws EmptyDataException
     */
    public function decrypt($value);

    /**
     * @param $value
     * @return mixed|string|null
     * @throws EmptyDataException
     */
    public function crypt($value);
}