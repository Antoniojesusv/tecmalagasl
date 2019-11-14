<?php

namespace App\Services;

use App\Entity\Text;
use APP\Exceptions\TextException;
use App\Repository\TextRepository;

class TextService
{

    public function __construct(TextRepository $textRepository)
    {
        $this->textRepository = $textRepository;
    }

    public function getAll()
    {
        $textCollection = $this->textRepository->getAll();

        if (empty($textCollection)) {
            throw new TextException('Empty text collection');
        }

        return $textCollection;
    }

    public function getOneById($id)
    {
        return $this->textRepository->findOneById($id);
    }

    public function save(array $textData): void
    {
        $text = $textData['text[text]'];
        $textEntity = new Text();
        $textEntity->setText($text);
        $this->textRepository->save($textEntity);
    }

    public function update($id, array $textData): void
    {
        $textEntity = $this->textRepository->findOneById($id);

        if (!$textEntity) {
            throw new TextException('The entity doesn´t exist');
        }

        $text = $textData['text[text]'];
        $textEntity->setText($text);

        $this->textRepository->update($textEntity);
    }

    public function remove($id)
    {
        $textEntity = $this->textRepository->findOneById($id);

        if (!$textEntity) {
            throw new TextException('The entity doesn´t exist');
        }

        $this->textRepository->remove($textEntity);
    }
}
