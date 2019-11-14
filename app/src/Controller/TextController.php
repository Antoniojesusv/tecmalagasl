<?php

namespace App\Controller;

use App\Entity\Text;
use APP\Exceptions\TextException;
use App\Form\TextType;
use App\Services\TextService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/text")
 */
class TextController extends AbstractController
{
    public function __construct(TextService $textService)
    {
        $this->textService = $textService;
    }

    /**
     * @Route("/", name="app_text_index")
     */
    public function indexAction()
    {
        $textCollection = $this->listAction();

        if (empty($textCollection)) {
            return $this->render('text/index.html.twig', [
                'textCollection' => []
            ]);
        }

        return $this->render('text/index.html.twig', [
            'textCollection' => $textCollection
        ]);
    }

    /**
     * @Route("/add", name="app_text_add", methods={"POST", "GET"})
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(TextType::class);

        if ($request->isMethod('POST')) {
            $textData = $request->request->all();
            $this->textService->save($textData);
            return new JsonResponse(['status' => 'ok']);
        }
        // return $this->redirectToRoute('app_text_index');

        return $this->render('@AppTemplate/text/add-form.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Guarda',
            'path' => 'app_text_edit'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_text_edit", methods={"GET","POST"})
     */
    public function editAction($id, Request $request)
    {
        $text = $this->textService->getOneById($id);

        $form = $this->createForm(TextType::class, $text);

        if ($request->isMethod('POST')) {
            $textData = $request->request->all();
            $this->textService->update($id, $textData);
            return new JsonResponse(['status' => 'ok']);
        }

        return $this->render('@AppTemplate/text/edit-form.html.twig', [
            'form' => $form->createView(),
            'buttonText' => 'Actualizar',
            'path' => 'app_text_edit',
            'textId' => $id
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_text_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->textService->remove($id);
            return new JsonResponse(['status' => 'ok']);
        }
    }

    private function listAction()
    {
        try {
            return $this->textService->getAll();
        } catch (TextException $e) {
            return [];
        }
    }
}
