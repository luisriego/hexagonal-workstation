<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller\Workstation;

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
        $responseData = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (null === $map = $responseData['map']) {
            throw new BadRequestHttpException('The Map image param is mandatory');
        }

        $workstation = $this->updateWorkstationService->__invoke($map, $id);

        return new ApiResponse($workstation->toArray());
    }
}
