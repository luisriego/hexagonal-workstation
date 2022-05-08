<?php

declare(strict_types=1);

namespace App\Tests\Functional\Workstation;

use App\Tests\Functional\FunctionalTestBase;
use Doctrine\DBAL\Exception;

class WorkstationTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/workstations';
    }


    /**
     * @throws Exception
     */
    protected function get1234WorkstationId()
    {
        $value = $this->initDbConnection()->query('SELECT id FROM workstation WHERE number = "1234"')->fetchOne(0);

        return $value;
    }
}