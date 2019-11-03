<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_panel")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="admin_panel_index", methods={"Get", "HEAD"})
     */
    public function IndexAction()
    {
        return $this->render('AdminPanel/index.html.twig');
    }
}
