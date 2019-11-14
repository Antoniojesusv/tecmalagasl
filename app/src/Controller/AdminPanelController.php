<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="app_adminpannel")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="app_adminpanel_index", methods={"Get", "HEAD"})
     */
    public function IndexAction()
    {
        return $this->render('AdminPanel/index.html.twig');
    }
}
