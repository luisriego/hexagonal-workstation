<?php

declare(strict_types=1);

namespace App\Tests\Functional\Workstation;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateWorkstationActionTest extends WorkstationTestBase
{
    /**
     * @throws Exception
     */
    public function testUpdateWorkstation(): void
    {
        $payload = [
            'map' => 'mapa_do_tesouro.jpg'
        ];

        self::$authenticatedClient->request(
            Request::METHOD_PUT,
            \sprintf('%s/%s', $this->endpoint, $this->getWorkstation1234Id()),
            [], [], [],
            \json_encode($payload)
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseData = \json_decode($response->getContent(), true);
        self::assertEquals('mapa_do_tesouro.jpg', $responseData['map']);
    }

//    public function testUpdateWorkstationFailNotBelong(): void
//    {
//        $payload = [
//            'fantasyName' => 'mapa_do_tesouro.jpg'
//        ];
//
//        self::$anotherAuthenticatedClient->request(
//            Request::METHOD_PUT,
//            \sprintf('%s/%s', $this->endpoint, $this->getWorkstation1234Id()),
//            [], [], [],
//            \json_encode($payload)
//        );
//
//        $response = self::$anotherAuthenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
//    }
}