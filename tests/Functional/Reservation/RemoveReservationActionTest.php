<?php

namespace App\Tests\Functional\Reservation;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveReservationActionTest extends ReservationTestBase
{
    /**
     * @throws Exception
     */
    public function testRemoveReservation(): void
    {
        self::$authenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getReservationId())
        );

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testRemoveReservationFailedBecauseOnotherUser(): void
    {
        self::$anotherAuthenticatedClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getReservationId())
        );

        $response = self::$anotherAuthenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testRemoveReservationFailUnauthorizedUser(): void
    {
        self::$baseClient->request(
            Request::METHOD_DELETE,
            \sprintf('%s/%s', $this->endpoint, $this->getReservationId())
        );

        $response = self::$baseClient->getResponse();

        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}