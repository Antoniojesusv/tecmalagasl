<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Exceptions\SliderException;
use App\Form\SliderType;
use App\Services\SliderService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/slider")
 */
class SliderController extends AbstractController
{
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
    /**
     * @Route("/", name="app_slider_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $sliderQueryBuilder = $this->listAction();
        $adapter = new DoctrineORMAdapter($sliderQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $pagerfanta->setCurrentPage($page);

        if (empty($sliderQueryBuilder)) {
            return $this->render('slider/index.html.twig', [
                'my_pager' => []
            ]);
        }

        return $this->render('slider/index.html.twig', [
            'my_pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/add", name="app_slider_add", methods={"POST", "GET"})
     */
    public function addAction(Request $request)
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sliderService->save($slider);
            return $this->redirectToRoute('app_slider_index');
        }

        return $this->render('@AppTemplate/slider/add-form.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_slider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Slider $slider): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sliderService->update($slider);
            return $this->redirectToRoute('app_slider_index');
        }

        return $this->render('slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_slider_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->sliderService->remove($id);
            return new JsonResponse(['status' => 'ok']);
        }
    }

    /**
     * @Route("/{id}", name="app_slider_show", methods={"GET"})
     */
    public function show(Slider $slider): Response
    {
        return $this->render('slider/show.html.twig', [
            'slider' => $slider,
        ]);
    }

    private function listAction()
    {
        try {
            return $this->sliderService->getAll();
        } catch (SliderException $e) {
            return [];
        }
    }
}
