<?php

namespace Datacity\PrivateBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'dashboard[D[D[D[D[D[D[D[D[D[D[D[D[D[D[C[C[C[C[C/');
    }

}
