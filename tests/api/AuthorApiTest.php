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
    public function testAddAuthor()
    {
        $client = static::createClient();

        $authorData = [
            'firstName' => 'oui',
            'lastName' => 'non',
            'bibliography' => 'An amazing author!',
            'books' => [],
        ];

        $client->request('POST', '/api/authors', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode($authorData));

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals('oui', $data['firstName']);
        $this->assertEquals('non', $data['lastName']);
        $this->assertEquals('An amazing author!', $data['bibliography']);

        $authorDataFromDb = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($authorData['firstName'], $authorDataFromDb['firstName']);
        $this->assertEquals($authorData['lastName'], $authorDataFromDb['lastName']);
        $this->assertEquals($authorData['bibliography'], $authorDataFromDb['bibliography']);
    }
}
