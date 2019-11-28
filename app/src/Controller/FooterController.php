<?php

namespace App\Controller;

use App\Entity\Footer;
use App\Exceptions\FooterException;
use App\Form\FooterType;
use App\Services\FooterService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/footer")
 */
class FooterController extends AbstractController
{
    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }
    /**
     * @Route("/", name="app_footer_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $productQueryBuilder = $this->listAction();
        $adapter = new DoctrineORMAdapter($productQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);

        if (empty($productQueryBuilder)) {
            return $this->render('footer/index.html.twig', [
                'my_pager' => []
            ]);
        }

        return $this->render('footer/index.html.twig', [
            'my_pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_footer_edit", methods={"GET","POST"})
     */
    public function edit(Footer $footer, Request $request)
    {
        $form = $this->createForm(FooterType::class, $footer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->footerService->update($footer);
            return $this->redirectToRoute('app_footer_index');
        }

        return $this->render('footer/edit.html.twig', [
            'footer' => $footer,
            'form' => $form->createView(),
        ]);
    }

    private function listAction()
    {
        try {
            return $this->footerService->getAll();
        } catch (FooterException $e) {
            return [];
        }
    }
}
