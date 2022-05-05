<?php

declare(strict_types=1);

namespace App\Controller\Workstation;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Workstation\GetCondoByIdService;
use App\Service\Workstation\GetWorkstationByIdService;

class GetWorkstationByIdAction
{
    public function __construct(private readonly GetWorkstationByIdService $getWorkstationByIdService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $condo = $this->getWorkstationByIdService->__invoke($id, $user);

        return new ApiResponse($condo->toArray());
    }
}
