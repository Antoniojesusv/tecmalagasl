<?php

namespace App\Services;

use App\Entity\Footer;
use App\Exceptions\FooterException;
use App\Repository\FooterRepository;

class FooterService
{

    public function __construct(FooterRepository $footerRepository)
    {
        $this->footerRepository = $footerRepository;
    }

    public function getAll()
    {
        $footerCollection = $this->footerRepository->getAll();

        if (empty($footerCollection)) {
            throw new FooterException('Empty text collection');
        }

        return $footerCollection;
    }

    public function getOneById($id)
    {
        return $this->footerRepository->findOneById($id);
    }

    public function update(Footer $footer): void
    {
        $footer = $this->footerRepository->find($footer);

        if (empty($footer)) {
            throw new FooterException('The entity ' . $footer->name . ' does not exist');
        }

        $this->footerRepository->update();
    }
}
