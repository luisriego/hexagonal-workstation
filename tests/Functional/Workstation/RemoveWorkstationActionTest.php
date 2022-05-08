<?php

namespace App\Tests\Functional\Workstation;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveWorkstationActionTest extends WorkstationTestBase
{
    /**
     * @throws Exception
     */
    public function testRemoveWorkstation(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getWorkstation1234Id())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

//    /**
//     * @throws Exception
//     */
//    public function testRemoveWorkstationFailUnauthorizedUser(): void
//    {
//        self::$anotherAuthenticatedClient->request(
//            Request::METHOD_DELETE,
//            \sprintf('%s/%s', $this->endpoint, $this->getWorkstation1234Id())
//        );
//
//        $response = self::$anotherAuthenticatedClient->getResponse();
//
//        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
//    }
}