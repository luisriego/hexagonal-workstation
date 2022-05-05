<?php

namespace App\Controller\Workstation;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Workstation\RemoveWorkstationService;
use Symfony\Component\HttpFoundation\Response;

class RemoveWorkstationAction
{
    public function __construct(private readonly RemoveWorkstationService $removeWorkstationService)
    {
    }

    public function __invoke(string $id, User $user): ApiResponse
    {
        $this->removeWorkstationService->__invoke($id, $user);

        return new ApiResponse([], Response::HTTP_NO_CONTENT);
    }
}
