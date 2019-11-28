<?php

namespace App\Controller;

use App\Entity\Image;
use App\Exceptions\ImageException;
use App\Form\ImageType;
use App\Services\ImageService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/image")
 */
class ImageController extends AbstractController
{
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * @Route("/", name="app_image_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $imageQueryBuilder = $this->listAction();
        $adapter = new DoctrineORMAdapter($imageQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(9);
        $pagerfanta->setCurrentPage($page);

        if (empty($imageQueryBuilder)) {
            return $this->render('image/index.html.twig', [
                'my_pager' => []
            ]);
        }

        return $this->render('image/index.html.twig', [
            'my_pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/add", name="app_image_add", methods={"POST", "GET"})
     */
    public function addAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['fileName']->getData();

            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            $imageFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $image->setFileName($newFilename);

            $this->imageService->save($image);
            return $this->redirectToRoute('app_image_index');
        }

        return $this->render('@AppTemplate/image/add-form.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_image_edit", methods={"POST", "GET"})
     */
    public function editAction(Image $image, Request $request)
    {
        $form = $this->createForm(ImageType::class, $image, ['requireImage' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->imageService->update($image);
            return $this->redirectToRoute('app_image_index');
        }

        return $this->render('@AppTemplate/image/edit-form.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_image_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $image = $this->imageService->getOneById($id);
            $filesystem = new Filesystem();
            $directoryPath = $this->getParameter('images_directory');
            $fileName = $image->getFileName();
            $fileToRemove = $directoryPath . '/' . $fileName;
            $filesystem->remove($fileToRemove);
            $this->imageService->remove($image);
            return new JsonResponse(['status' => 'ok']);
        }
    }

    private function listAction()
    {
        try {
            return $this->imageService->getAll();
        } catch (ImageException $e) {
            return [];
        }
    }
}
