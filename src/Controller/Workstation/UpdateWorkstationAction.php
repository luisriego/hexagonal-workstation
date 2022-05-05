<?php

declare(strict_types=1);

namespace App\Controller\Workstation;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use App\Service\Workstation\UpdateWorkstationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateWorkstationAction
{
    public function __construct(private readonly UpdateWorkstationService $updateWorkstationService)
    {
    }

    public function __invoke(Request $request, string $id, User $user): ApiResponse
    {
        $responseData = \json_decode($request->getContent(), true);

        if (null === $name = $responseData['fantasyName']) {
            throw new BadRequestHttpException('The Fantasy Name param is mandatory');
        }

        $condo = $this->updateWorkstationService->__invoke($name, $id, $user);

        return new ApiResponse($condo->toArray());
    }
}
