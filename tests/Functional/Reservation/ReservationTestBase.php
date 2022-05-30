<?php

namespace App\Tests\Functional\Reservation;

use App\Entity\Reservation;
use App\Tests\Functional\FunctionalTestBase;
use Doctrine\DBAL\Exception;

class ReservationTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/reservations';
    }


    /**
     * @throws Exception
     */
    protected function getReservationId(): ?string
    {
        return $this->initDbConnection()->query('SELECT id FROM reservation WHERE notes = "Luis User"')->fetchOne(0);
    }
}