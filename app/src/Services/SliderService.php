<?php

namespace App\Services;

use App\Entity\Slider;
use App\Exceptions\SliderException;
use App\Repository\SliderRepository;

class SliderService
{

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    public function getAll()
    {
        $sliderCollection = $this->sliderRepository->getAll();

        if (empty($sliderCollection)) {
            throw new SliderException('Empty text collection');
        }

        return $sliderCollection;
    }

    public function getOneById($id)
    {
        return $this->sliderRepository->findOneById($id);
    }

    public function save(Slider $slider): void
    {
        $this->sliderRepository->save($slider);
    }

    public function update(Slider $slider): void
    {
        $slider = $this->sliderRepository->find($slider);

        if (empty($slider)) {
            throw new SliderException('The entity ' . $slider->name . ' does not exist');
        }

        $this->sliderRepository->update();
    }

    public function remove($id)
    {
        $sliderEntity = $this->sliderRepository->findOneById($id);

        if (!$sliderEntity) {
            throw new SliderException('The entity doesn´t exist');
        }

        $this->sliderRepository->remove($sliderEntity);
    }
}
