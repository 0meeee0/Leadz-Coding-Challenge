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

        $this->assertArrayHasKey('id', $data); // Ensure the author was created
        $authorId = $data['id']; // Store the author ID for later use

        // Step 2: Delete the author
        $client->request('DELETE', '/api/authors/' . $authorId);

        $this->assertResponseIsSuccessful(); // Ensure the deletion request was successful (HTTP 200 or 204)

        // Step 3: Verify that the author was deleted by trying to retrieve the deleted author
        $client->request('GET', '/api/authors/' . $authorId);

        // Assert that the response status is 404, meaning the author no longer exists
        $this->assertResponseStatusCodeSame(404);
    }

}
