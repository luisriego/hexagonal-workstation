<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller\Workstation;

use App\Entity\User;
use App\Http\DTO\CreateWorkstationRequest;
use App\Service\Workstation\CreateWorkstationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateWorkstationAction
{
    public function __construct(private readonly CreateWorkstationService $createWorkstationService)
    {
    }

    public function __invoke(CreateWorkstationRequest $request, User $user): JsonResponse
    {
        $workstation = $this->createWorkstationService->__invoke($request->getNumber(), $request->getFloor(), $user);

        return new JsonResponse($workstation->toArray(), Response::HTTP_CREATED);
    }
}
