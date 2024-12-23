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
    public function testDeleteAuthor()
    {
        $client = static::createClient();
        $authorData = [
            'firstName' => 'testing',
            'lastName' => 'delete',
            'bibliography' => 'A brilliant author!',
            'books' => [],
        ];

        $client->request('POST', '/api/authors', [], [], ['CONTENT_TYPE' => 'application/ld+json'], json_encode($authorData));

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $data);
        $authorId = $data['id'];

        $client->request('DELETE', '/api/authors/' . $authorId);

        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/authors/' . $authorId);

        $this->assertResponseStatusCodeSame(404);
    }
    public function testEditAuthor()
    {
        $client = static::createClient();

        $client->request('GET', '/api/authors');
        $this->assertResponseIsSuccessful();

        $authors = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($authors['member'], 'No authors found to edit.');

        $authorId = $authors['member'][0]['id'];

        $updatedData = [
            'firstName' => 'UpdatedName',
        ];

        $client->request(
            'PATCH',
            '/api/authors/' . $authorId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/merge-patch+json'],
            json_encode($updatedData)
        );

        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/authors/' . $authorId);
        $updatedAuthor = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('UpdatedName', $updatedAuthor['firstName']);
    }
}
