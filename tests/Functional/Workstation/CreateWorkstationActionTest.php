<?php

declare(strict_types=1);

namespace App\Tests\Functional\Workstation;

use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateWorkstationActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/workstations/create';

    public function testCreateWorkstation(): void
    {
        $payload = [
            'number' => '4321',
            'floor' => '19'
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('number', $responseData);
        self::assertArrayHasKey('floor', $responseData);
        self::assertArrayHasKey('active', $responseData);
    }

//    public function testCreateWorkstationFailBecauseAlreadyExist(): void
//    {
//        $payload = [
//            'number' => '1235',
//            'floor' => '19'
//        ];
//
//        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));
//        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));
//
//        $response = self::$authenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
//    }
//
//    public function testCreateWorkstationFailedByCNPJTooShort(): void
//    {
//        $payload = [
//            'number' => '1234',
//            'floor' => '19'
//        ];
//
//        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));
//
//        $response = self::$authenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
//    }
//
//    public function testCreateWorkstationFailedByCNPJTooLong(): void
//    {
//        $payload = [
//            'number' => '1234',
//            'floor' => '19'
//        ];
//
//        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));
//
//        $response = self::$authenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
//    }
}