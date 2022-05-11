<?php

declare(strict_types=1);

namespace App\Tests\Functional\Reservation;

use _PHPStan_7bd9fb728\Nette\Utils\DateTime;
use App\Tests\Functional\FunctionalTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateReservationActionTest extends FunctionalTestBase
{
    private const ENDPOINT = '/api/v1/reservations/create';

    public function testCreateReservationFailedBecauseUnavailable(): void
    {
        $start = new DateTime('2032-06-15');
        $end = new DateTime('2032-06-17');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for unavaliable date',
            'workstation' => '',
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateReservation(): void
    {
        $start = new DateTime();
        $start->modify('+10 days');
        $end = new DateTime();
        $end->modify('+11 days');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for this reservation',
            'workstation' => '',
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('startDate', $responseData);
        self::assertArrayHasKey('endDate', $responseData);
        self::assertArrayHasKey('notes', $responseData);
    }

    public function testCreateReservationWithWorkstation(): void
    {
        $start = new DateTime();
        $start->modify('+10 days');
        $end = new DateTime();
        $end->modify('+11 days');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for the other reservation',
            'workstation' => $this->getWorkstation1234Id(),
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $responseData = \json_decode($response->getContent(), true);
        self::assertArrayHasKey('startDate', $responseData);
        self::assertArrayHasKey('endDate', $responseData);
        self::assertArrayHasKey('notes', $responseData);
    }

    public function testCreateReservationFailedBecauseUnauthorized(): void
    {
        $start = new DateTime();
        $start->modify('+10 days');
        $end = new DateTime();
        $end->modify('+11 days');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for this reservation',
            'workstation' => '',
        ];

        self::$baseClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$baseClient->getResponse();

        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    public function testCreateReservationFailedBecauseEndDateBeforeStartDate(): void
    {
        $start = new DateTime();
        $start->modify('+11 days');
        $end = new DateTime();
        $end->modify('+10 days');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for this reservation',
            'workstation' => $this->getWorkstation1234Id(),
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateReservationFailedBecauseStartDateBeforeToday(): void
    {
        $start = new DateTime();
        $start->modify('-1 day');
        $end = new DateTime();
        $end->modify('+10 days');
        $payload = [
            'startDate' => $start,
            'endDate' => $end,
            'notes' => 'notes for this reservation',
            'workstation' => $this->getWorkstation1234Id(),
        ];

        self::$authenticatedClient->request(Request::METHOD_POST, self::ENDPOINT, [], [], [], \json_encode($payload));

        $response = self::$authenticatedClient->getResponse();

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}