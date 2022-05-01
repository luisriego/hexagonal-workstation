<?php

declare(strict_types=1);

namespace App\Tests\Functional\Condo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddUserToCondoActionTest extends CondoTestBase
{
    public function testAddUserToCondosById(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s/user/%s', $this->endpoint, $this->getLuisCondoId(), $this->getAnotherId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertCount(2, $responseData['users']);
    }

    public function testAddUserToCondosByIdFailCondoNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s/user/%s', $this->endpoint, 'wrong-condo-id', $this->getAnotherId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testAddUserToCondosByIdFailUserNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s/user/%s', $this->endpoint, $this->getLuisCondoId(), 'wrong_id')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}