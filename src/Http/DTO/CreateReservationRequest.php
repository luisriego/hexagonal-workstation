<?php

namespace App\Http\DTO;


use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateReservationRequest implements RequestDTO
{
    #[Assert\NotBlank]
//    #[Assert\GreaterThan('today')]
    public readonly ?string $startDate;

    #[Assert\NotBlank]
//    #[Assert\GreaterThan('startDate')]
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
