<?php

namespace App\core\Adapter\Framework\Http\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateWorkstationRequest implements RequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 4)]
    private readonly ?string $floor;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 14)]
    private readonly ?string $number;

    public function __construct(Request $request)
    {
        $this->floor = $request->request->get('floor');
        $this->number = $request->request->get('number');
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }
}
