<?php

namespace App\Tests\Functional\Workstation;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetWorkstationActionTest extends WorkstationTestBase
{
//    private const ENDPOINT = '/api/v1/condos';

    /**
     * @throws Exception
     */
    public function testGetWorkstationById(): void
    {
        $wsid = $this->get1234WorkstationId();

        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, $this->get1234WorkstationId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('number', $responseData);
        self::assertArrayHasKey('floor', $responseData);
    }

    public function testGetWorkstationsByIdFailWhenWorkstationNotFound(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_GET,
            \sprintf('%s/%s', $this->endpoint, 'condo-not-found-id')
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

//    /**
//     * @throws Exception
//     */
//    public function testGetWorkstationByIdFailUnauthorized(): void
//    {
//        self::$anotherAuthenticatedClient->request(
//            Request::METHOD_GET,
//            \sprintf('%s/%s', $this->endpoint, $this->get1234WorkstationId())
//        );
//
//        $response = self::$anotherAuthenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
//    }
}