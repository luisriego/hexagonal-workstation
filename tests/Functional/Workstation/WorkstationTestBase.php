<?php

declare(strict_types=1);

namespace App\Tests\Functional\Workstation;

use App\Tests\Functional\FunctionalTestBase;

class WorkstationTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/workstations';
    }

//
//    protected function getLuisCondoId()
//    {
//        return $this->initDbConnection()->query('SELECT id FROM condo WHERE fantasy_name = "Luis Condo"')->fetchColumn(0);
//    }
}