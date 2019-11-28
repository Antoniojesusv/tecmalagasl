<?php

namespace App\Services;

use App\Entity\Image;
use App\Exceptions\ImageException;
use App\Repository\ImageRepository;

class ImageService
{

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function getAll()
    {
        $imageCollection = $this->imageRepository->getAll();

        if (empty($imageCollection)) {
            throw new ImageException('Empty image collection');
        }

        return $imageCollection;
    }

    public function getOneById($id)
    {
        return $this->imageRepository->findOneById($id);
    }

    public function save(Image $image): void
    {
        $this->imageRepository->save($image);
    }

    public function update(Image $image): void
    {
        $image = $this->imageRepository->find($image);

        if (empty($image)) {
            throw new ImageException('The entity ' . $image->fileName . ' does not exist');
        }

        $this->imageRepository->update();
    }

    public function remove($id)
    {
        $imageEntity = $this->imageRepository->findOneById($id);

        if (!$imageEntity) {
            throw new ImageException('The entity doesn´t exist');
        }

        $this->imageRepository->remove($imageEntity);
    }
}
