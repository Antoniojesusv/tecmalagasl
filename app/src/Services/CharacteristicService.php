<?php

namespace App\Services;

use App\Entity\Characteristic;
use App\Exceptions\CharacteristicException;
use App\Repository\CharacteristicRepository;

class CharacteristicService
{

    public function __construct(CharacteristicRepository $characteristicRepository)
    {
        $this->characteristicRepository = $characteristicRepository;
    }

    public function getAll()
    {
        $characteristicCollection = $this->characteristicRepository->getAll();

        if (empty($characteristicCollection)) {
            throw new CharacteristicException('Empty text collection');
        }

        return $characteristicCollection;
    }

    public function getOneById($id)
    {
        return $this->characteristicRepository->findOneById($id);
    }

    public function save(Characteristic $characteristic): void
    {
        $this->characteristicRepository->save($characteristic);
    }

    public function update(Characteristic $characteristic): void
    {
        $characteristic = $this->characteristicRepository->find($characteristic);

        if (empty($characteristic)) {
            throw new CharacteristicException('The entity ' . $characteristic->name . ' does not exist');
        }

        $this->characteristicRepository->update();
    }

    public function remove($id)
    {
        $characteristicEntity = $this->characteristicRepository->findOneById($id);

        if (!$characteristicEntity) {
            throw new CharacteristicException('The entity doesn´t exist');
        }

        $this->characteristicRepository->remove($characteristicEntity);
    }
}
