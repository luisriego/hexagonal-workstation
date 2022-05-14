<?php

declare(strict_types=1);

namespace App\Controller\Reservation;

use App\Entity\Workstation;
use App\Http\DTO\CreateReservationRequest;
use App\Service\Reservation\CreateReservationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateReservationAction
{
    public function __construct(private readonly CreateReservationService $createReservationService)
    {
    }

    public function __invoke(CreateReservationRequest $request): JsonResponse
    {
        $reservation = $this->createReservationService->__invoke(
            $request->startDate,
            $request->endDate,
            $request->workstation,
            $request->notes,
        );

        return new JsonResponse($reservation->toArray(), Response::HTTP_CREATED);
    }
}
