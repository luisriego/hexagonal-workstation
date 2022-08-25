<?php

declare(strict_types=1);

namespace App\core\Adapter\Framework\Http\Controller\Reservation;

use App\Http\DTO\CreateReservationRequest;
use App\Service\Reservation\CreateReservationService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateReservationAction
{
    public function __construct(private readonly CreateReservationService $createReservationService)
    {
    }

    /**
     * @throws Exception
     */
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
