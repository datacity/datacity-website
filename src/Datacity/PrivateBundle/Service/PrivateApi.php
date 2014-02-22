<?php

namespace Datacity\PrivateBundle\Service;

use Symfony\Component\Security\Core\Util\SecureRandom;

class PrivateApi
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function createClient($username, $quota)
    {
    	$generator = new SecureRandom();
		$publicKey = hash('md5', $generator->nextBytes(10));
		$privateKey = hash('md5', $generator->nextBytes(10));
    	$request = $this->client->post('user', null, array(
    		'publicKey' => $publicKey,
    		'privateKey' => $privateKey,
    		'quota' => $quota,
    		'username' => $username));
    	return $request->send();
    }
}
