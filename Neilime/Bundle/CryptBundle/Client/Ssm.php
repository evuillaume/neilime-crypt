<?php
namespace Neilime\Bundle\CryptBundle\Client;

use Aws\Ssm\Exception\SsmException;
use Aws\Ssm\SsmClient;
use Neilime\Bundle\CryptBundle\Exception\ActionNotSupportedException;
use Neilime\Bundle\CryptBundle\Exception\DecryptException;

/**
 * Class Ssm
 * @package Neilime\Bundle\CryptBundle\Client
 */
class Ssm implements ClientInterface
{
    /**
     * @var SsmClient
     */
    private $client;

    /**
     * Ssm constructor.
     * @param string $region
     */
    public function __construct($region = 'eu-west-1')
    {
        $this->client = new SsmClient([
            'version'   => 'latest',
            'region'    => $region,
        ]);
    }

    /**
     * @param $value
     * @return mixed|string|null
     * @throws DecryptException
     */
    public function decrypt($value)
    {
        try {
            $result = $this->client->getParameter([
                'Name' => $value,
                'WithDecryption' => true
            ]);
            if ($result->hasKey('Parameter')) {
                $parameter = $result['Parameter'];

                return $parameter['Value'];
            }

        }catch (SsmException $exception){

        }

        throw new DecryptException("Decrypt error: parameter not found");
    }

    /**
     * @param $value
     * @return mixed|string|null
     * @throws ActionNotSupportedException
     */
    public function crypt($value)
    {
        throw new ActionNotSupportedException();
    }
}