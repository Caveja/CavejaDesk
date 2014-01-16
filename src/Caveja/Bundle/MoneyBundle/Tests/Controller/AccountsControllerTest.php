<?php

namespace Caveja\Bundle\MoneyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountsControllerTest extends WebTestCase
{
    public function testCreateAndGet()
    {
        $client = static::createClient();

        // name should be a unique string
        $name = '' . mt_rand();

        $id = $this->createAccount($client, $name);
        $json = $this->getAccount($client, $id);

        $this->assertSame($id, $json->id, 'ID should match');
        $this->assertSame($name, $json->name, 'Name should match');
    }

    public function testRename()
    {
        $client = static::createClient();

        $id = $this->createAccount($client, 'foobar' . mt_rand());

        $client->request('POST', '/money/accounts/' . $id, ['name' => $name = mt_rand()]);
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful(), 'Response should be successful');

        $json = $this->getAccount($client, $id);
    }

    /**
     * @param $response
     */
    private function assertContentTypeIsJSON(Response $response)
    {
        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'Content type should be application/json'
        );
    }

    /**
     * @param  Client  $client
     * @param  string  $name
     * @return integer
     */
    private function createAccount(Client $client, $name)
    {
        $client->request('POST', '/money/accounts', ['name' => $name]);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), 'Response should be successful');
        $this->assertContentTypeIsJSON($response);
        $json = json_decode($response->getContent());

        $this->assertTrue(is_int($json->id), 'There should be an integer id in JSON response');

        return $json->id;
    }

    /**
     * @param  Client    $client
     * @param  integer   $id
     * @return \stdClass
     */
    private function getAccount(Client $client, $id)
    {
        $client->request('GET', '/money/accounts/' . $id);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), 'GET response should be successful');
        $this->assertContentTypeIsJSON($response);
        $json = json_decode($response->getContent());

        $this->assertEquals($id, $json->id, 'ID should match');

        return $json;
    }
}
