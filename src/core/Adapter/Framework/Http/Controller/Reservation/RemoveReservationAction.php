<?php

namespace App\core\Adapter\Framework\Http\Controller\Reservation;

use App\Http\Response\ApiResponse;
use App\Service\Reservation\RemoveReservationService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Response;

class RemoveReservationAction
{
    public function __construct(private readonly RemoveReservationService $removeReservationService)
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(string $id): ApiResponse
    {
        $this->removeReservationService->__invoke($id);

        return new ApiResponse([], Response::HTTP_NO_CONTENT);
    }
}
