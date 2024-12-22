<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorApiTest extends WebTestCase
{
    public function testGetAllAuthors()
    {
        $client = static::createClient();
        $client->request('GET', '/api/authors');

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(4, $data['member']);
    }
    
}
