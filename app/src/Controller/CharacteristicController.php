<?php

namespace App\Controller;

use App\Entity\Characteristic;
use App\Exceptions\CharacteristicException;
use App\Form\CharacteristicType;
use App\Services\CharacteristicService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/characteristic")
 */
class CharacteristicController extends AbstractController
{
    public function __construct(CharacteristicService $characteristicService)
    {
        $this->characteristicService = $characteristicService;
    }
    /**
     * @Route("/", name="app_characteristic_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $characteristicQueryBuilder = $this->listAction();
        $adapter = new DoctrineORMAdapter($characteristicQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $pagerfanta->setCurrentPage($page);

        if (empty($characteristicQueryBuilder)) {
            return $this->render('characteristic/index.html.twig', [
                'my_pager' => []
            ]);
        }

        return $this->render('characteristic/index.html.twig', [
            'my_pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/add", name="app_characteristic_add", methods={"POST", "GET"})
     */
    public function addAction(Request $request)
    {
        $characteristic = new Characteristic();
        $form = $this->createForm(CharacteristicType::class, $characteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characteristicService->save($characteristic);
            return $this->redirectToRoute('app_characteristic_index');
        }

        return $this->render('@AppTemplate/characteristic/add-form.html.twig', [
            'characteristic' => $characteristic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_characteristic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Characteristic $characteristic): Response
    {
        $form = $this->createForm(CharacteristicType::class, $characteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characteristicService->update($characteristic);
            return $this->redirectToRoute('app_characteristic_index');
        }

        return $this->render('characteristic/edit.html.twig', [
            'characteristic' => $characteristic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_characteristic_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->characteristicService->remove($id);
            return new JsonResponse(['status' => 'ok']);
        }
    }

    private function listAction()
    {
        try {
            return $this->characteristicService->getAll();
        } catch (CharacteristicException $e) {
            return [];
        }
    }
}
