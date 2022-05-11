<?php

namespace App\Tests\Functional\Reservation;

use App\Entity\Reservation;
use App\Tests\Functional\FunctionalTestBase;

class ReservationTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/reservations';
    }


    protected function getWorkstation1234Id(): ?Reservation
    {
        return $this->initDbConnection()->query('SELECT id FROM reservation WHERE fantasy_name = "Luis Condo"')->fetchColumn(0);
    }
}