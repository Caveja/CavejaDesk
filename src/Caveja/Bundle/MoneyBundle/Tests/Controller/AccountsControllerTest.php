<?php

namespace Caveja\Bundle\MoneyBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AccountsControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $client->request('POST', '/money/accounts', ['name' => $name = mt_rand()]);

        $response = $client->getResponse();

        $this->assertContentTypeIsJSON($response);

        $json = json_decode($response->getContent());

        $this->assertTrue($response->isSuccessful(), 'Response should be successful');
        $this->assertTrue(is_int($json->id), 'There should be an integer id in JSON response');

        $client->request('GET', '/money/accounts');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), 'Response should be successful');
        $this->assertContentTypeIsJSON($response);

        $json = json_decode($response->getContent());
        $this->assertGreaterThanOrEqual(1, count($json), 'At least one Account should be present');
    }

    public function testGetSingle()
    {
        $client = static::createClient();
        $client->request('POST', '/money/accounts', ['name' => $name = '' . mt_rand()]);
        $response = $client->getResponse();

        $this->assertContentTypeIsJSON($response);
        $json = json_decode($response->getContent());

        $id = $json->id;
        $resourceUri = '/money/accounts/' . $id;

        $client->request('GET', $resourceUri);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful(), 'GET response should be successful');
        $this->assertContentTypeIsJSON($response);
        $json = json_decode($response->getContent());

        $this->assertSame($id, $json->id, 'ID should match');
        $this->assertSame($name, $json->name, 'Name should match');
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
}
