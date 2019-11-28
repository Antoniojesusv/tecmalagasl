<?php

namespace App\Controller;

use App\Entity\BackgroundImage;
use App\Entity\Footer;
use App\Entity\Product;
use App\Entity\Slider;
use App\Entity\Text as AppText;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InitialController extends AbstractController
{
    /**
     * @Route("/", name="initial")
     */
    public function index()
    {
        $backgroundImagesCollection = $this->getDoctrine()->getRepository(BackgroundImage::class)->getAll();

        $productsCollection = $this->getDoctrine()->getRepository(Product::class)->findAll();

        $chunkedProductsCollection = array_chunk($productsCollection, 6);

        $footerCollection = $this->getDoctrine()->getRepository(Footer::class)->findAll();

        $sliderCollection = $this->getDoctrine()->getRepository(Slider::class)->findAll();

        $textCollection = $this->getDoctrine()->getRepository(AppText::class)->findAll();

        return $this->render('Initial/index.html.twig', [
            'backgroundImagesCollection' => $backgroundImagesCollection,
            'chunkedProductCollection' => $chunkedProductsCollection,
            'footerCollection' => $footerCollection,
            'sliderCollection' => $sliderCollection,
            'textCollection' => $textCollection
        ]);
    }
}
