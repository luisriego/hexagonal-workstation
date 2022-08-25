<?php

namespace App\core\Adapter\Framework\Http\DTO;

use Exception;
use Symfony\Component\HttpFoundation\Request;

class CreateReservationRequest implements RequestDTO
{
    public readonly ?string $startDate;
    public readonly ?string $endDate;
    public readonly ?string $workstation;
    public readonly ?string $notes;

    /**
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        $this->startDate = $request->request->get('startDate');
        $this->endDate = $request->request->get('endDate');
        $this->workstation = $request->request->get('workstation');
        $this->notes = $request->request->get('notes');
    }
}
