<?php

namespace App\Controller;

use App\Entity\BackgroundImage;
use App\Exceptions\BackgroundImageException;
use App\Form\BackgroundImageType;
use App\Services\BackgroundImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/bacgroundimage")
 */
class BackgroundImageController extends AbstractController
{
    public function __construct(BackgroundImageService $backgroundImageService)
    {
        $this->backgroundImageService = $backgroundImageService;
    }
    /**
     * @Route("/", name="app_backgroundimage_index")
     */
    public function indexAction()
    {
        $backgroundImageCollection = $this->listAction();
        if (empty($backgroundImageCollection)) {
            return $this->render('backgroundimage/index.html.twig', [
                'backgroundImageCollection' => []
            ]);
        }

        return $this->render('backgroundImage/index.html.twig', [
            'backgroundImageCollection' => $backgroundImageCollection
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_backgroundimage_edit", methods={"GET","POST"})
     */
    public function edit(BackgroundImage $backgroundImage, Request $request)
    {
        $form = $this->createForm(BackgroundImageType::class, $backgroundImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->backgroundImageService->update($backgroundImage);
            return $this->redirectToRoute('app_backgroundimage_index');
        }

        return $this->render('backgroundImage/edit.html.twig', [
            'backgroundImage' => $backgroundImage,
            'form' => $form->createView(),
        ]);
    }

    private function listAction()
    {
        try {
            return $this->backgroundImageService->getAll();
        } catch (BackgroundImageException $e) {
            return [];
        }
    }
}
