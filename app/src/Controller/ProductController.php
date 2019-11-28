<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exceptions\ProductException;
use App\Form\ProductType;
use App\Services\ProductService;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * @Route("/", name="app_product_index")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $productQueryBuilder = $this->listAction();
        $adapter = new DoctrineORMAdapter($productQueryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(6);
        $pagerfanta->setCurrentPage($page);

        if (empty($productQueryBuilder)) {
            return $this->render('product/index.html.twig', [
                'my_pager' => []
            ]);
        }

        return $this->render('product/index.html.twig', [
            'my_pager' => $pagerfanta
        ]);
    }

    /**
     * @Route("/add", name="app_product_add", methods={"POST", "GET"})
     */
    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->save($product);
            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('@AppTemplate/product/add-form.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->update($product);
            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_product_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->productService->remove($id);
            return new JsonResponse(['status' => 'ok']);
        }
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_product_initial_show", methods={"GET"})
     */
    public function showInitial(Product $product): Response
    {
        return $this->render('Initial/show.html.twig', [
            'product' => $product,
        ]);
    }

    private function listAction()
    {
        try {
            return $this->productService->getAll();
        } catch (ProductException $e) {
            return [];
        }
    }
}
