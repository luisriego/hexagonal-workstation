<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Repository\DoctrineUserRepository;
use App\Service\File\FileService;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{
    public final const VISIBILITY_PUBLIC = 'public';

    public function __construct(
        private readonly FileService $fileService,
        private readonly DoctrineUserRepository $userRepository,
        private readonly string $mediaPath
    ) { }

    /**
     * @throws FilesystemException
     */
    public function uploadAvatar(Request $request, User $user): User
    {
        $file = $this->fileService->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->fileService->deleteFile($user->getAvatar());

        $fileName = $this->fileService->uploadFile($file, FileService::AVATAR_INPUT_NAME, self::VISIBILITY_PUBLIC);

        $user->setAvatar($fileName);

        $this->userRepository->save($user);

        return $user;
    }
}