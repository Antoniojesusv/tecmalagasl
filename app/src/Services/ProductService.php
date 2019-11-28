<?php

namespace App\Services;

use App\Entity\Product;
use App\Exceptions\ProductException;
use App\Repository\ProductRepository;

class ProductService
{

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        $productCollection = $this->productRepository->getAll();

        if (empty($productCollection)) {
            throw new ProductException('Empty text collection');
        }

        return $productCollection;
    }

    public function getOneById($id)
    {
        return $this->productRepository->findOneById($id);
    }

    public function save(Product $product): void
    {
        $this->productRepository->save($product);
    }

    public function update(Product $product): void
    {
        $product = $this->productRepository->find($product);

        if (empty($product)) {
            throw new ProductException('The entity ' . $product->name . ' does not exist');
        }

        $this->productRepository->update();
    }

    public function remove($id)
    {
        $productEntity = $this->productRepository->findOneById($id);

        if (!$productEntity) {
            throw new ProductException('The entity doesn´t exist');
        }

        $this->productRepository->remove($productEntity);
    }
}
