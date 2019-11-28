<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="app_adminpanel_index", methods={"Get", "HEAD"})
     */
    public function IndexAction()
    {
        return $this->render('AdminPanel/admin.html.twig');
    }
}
