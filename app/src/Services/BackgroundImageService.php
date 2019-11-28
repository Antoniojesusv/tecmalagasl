<?php

namespace App\Services;

use App\Entity\BackgroundImage;
use App\Exceptions\BackgroundImageException;
use App\Repository\BackgroundImageRepository;

class BackgroundImageService
{

    public function __construct(BackgroundImageRepository $backgroundImageRepository)
    {
        $this->backgroundImageRepository = $backgroundImageRepository;
    }

    public function getAll()
    {
        $backgroundImageCollection = $this->backgroundImageRepository->getAll();

        if (empty($backgroundImageCollection)) {
            throw new BackgroundImageException('Empty text collection');
        }

        return $backgroundImageCollection;
    }

    public function getOneById($id)
    {
        return $this->backgroundImageRepository->findOneById($id);
    }

    public function update(BackgroundImage $backgroundImage): void
    {
        $backgroundImage = $this->backgroundImageRepository->find($backgroundImage);

        if (empty($backgroundImage)) {
            throw new BackgroundImageException('The entity ' . $backgroundImage->name . ' does not exist');
        }

        $this->backgroundImageRepository->update();
    }
}
