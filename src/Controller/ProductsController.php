<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * This function display all products
     *
     * @param ProductsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/products', name: 'products.index', methods:['GET'])]
    public function index(ProductsRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $product = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/products/index.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * This function is used to create a product
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/products/new', name: 'products.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $products = new Products();
        $form = $this->createForm(ProductsType::class, $products);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $products = $form->getData();
            
            $manager->persist($products);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été créé avec succès !'
            );

        return $this->redirectToRoute('products.index');

        }

        return $this->render('pages/products/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
    /**
     * This function is used to edit a product
     *
     * @param Products $products
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/products/edit/{id}', 'products.edit', methods:['GET', 'POST'])]
    public function edit(Products $products, EntityManagerInterface $manager, Request $request): Response
    {
        
        $form = $this->createForm(ProductsType::class, $products);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $products = $form->getData();
            
            $manager->persist($products);
            $manager->flush();

            $this->addFlash(
                'info',
                'Votre produit a été modifié avec succès !'
            );

        return $this->redirectToRoute('products.index');

        }

        return $this->render('pages/products/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This function is used to delete a product
     *
     * @param Products $products
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/products/delete/{id}', 'products.delete', methods:['GET'])]
    public function delete(Products $products, EntityManagerInterface $manager): Response
    {
        $manager->remove($products);
        $manager->flush();

        $this->addFlash(
            'warning',
            'Votre produit a été supprimé avec succès !'
        );
        return $this->redirectToRoute('products.index', []);
    }

}
