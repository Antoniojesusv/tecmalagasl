<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="app_product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("", name="app_product")
     */
    public function indexAction()
    { }
}
