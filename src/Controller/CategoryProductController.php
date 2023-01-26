<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Form\CategoryProductType;
use App\Repository\CategoryProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category/product')]
class CategoryProductController extends AbstractController
{
    #[Route('/', name: 'app_category_product_index', methods: ['GET'])]
    public function index(CategoryProductRepository $categoryProductRepository): Response
    {
        return $this->render('category_product/index.html.twig', [
            'category_products' => $categoryProductRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_category_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryProductRepository $categoryProductRepository): Response
    {
        $categoryProduct = new CategoryProduct();
        $form = $this->createForm(CategoryProductType::class, $categoryProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryProductRepository->save($categoryProduct, true);

            return $this->redirectToRoute('app_category_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_product/new.html.twig', [
            'category_product' => $categoryProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_product_show', methods: ['GET'])]
    public function show(CategoryProduct $categoryProduct): Response
    {
        return $this->render('category_product/show.html.twig', [
            'category_product' => $categoryProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategoryProduct $categoryProduct, CategoryProductRepository $categoryProductRepository): Response
    {
        $form = $this->createForm(CategoryProductType::class, $categoryProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryProductRepository->save($categoryProduct, true);

            return $this->redirectToRoute('app_category_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category_product/edit.html.twig', [
            'category_product' => $categoryProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_product_delete', methods: ['POST'])]
    public function delete(Request $request, CategoryProduct $categoryProduct, CategoryProductRepository $categoryProductRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryProduct->getId(), $request->request->get('_token'))) {
            $categoryProductRepository->remove($categoryProduct, true);
        }

        return $this->redirectToRoute('app_category_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
