<?php

declare(strict_types=1);

namespace App\Service\Reservation;

use App\Entity\User;
use App\Exception\Reservation\ReservationNotFoundException;
use App\Exception\User\UserHasNotAuthorizationException;
use App\Repository\DoctrineReservationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Security;

class RemoveReservationService
{
    public function __construct(
        private readonly DoctrineReservationRepository $ReservationRepository,
        private readonly Security $security
    ) {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(string $id): void
    {
        /** @var User $user */
        if (null === $user = $this->security->getUser()) {
            throw new UserHasNotAuthorizationException();
        }

        if (null === $reservation = $this->ReservationRepository->findOneActiveById($id)) {
            throw ReservationNotFoundException::fromId($id);
        }

        if ($user !== $reservation->getUser()) {
            throw new UserHasNotAuthorizationException();
        }

        $this->ReservationRepository->remove($reservation);
    }
}
