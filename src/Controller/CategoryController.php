<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * This function display all categories
     *
     * @param CategoryRepository $category
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/category', name: 'category.index', methods:['GET'])]
    public function index(CategoryRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * This function is used to create a category
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/category/new', 'category.new', methods:['GET', 'POST'])]
    public function new( Request $request,
    EntityManagerInterface $manager) : Response 
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();
            
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre categorie a été créé avec succès !'
            );

        return $this->redirectToRoute('category.index');

        }

        return $this->render('pages/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This function is used to modify a category
     *
     * @param Category $category
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/category/edit/{id}', 'category.edit', methods:['GET', 'POST'])]
    public function edit(Category $category, EntityManagerInterface $manager, Request $request): Response
    {
        
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();
            
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'info',
                'Votre categorie a été modifiée avec succès !'
            );

        return $this->redirectToRoute('category.index');

        }

        return $this->render('pages/category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/delete/{id}', 'category.delete', methods:['GET'])]
    public function delete(Category $category, EntityManagerInterface $manager): Response
    {
        $manager->remove($category);
        $manager->flush();

        $this->addFlash(
            'warning',
            'Votre categorie a été supprimée avec succès !'
        );
        return $this->redirectToRoute('category.index', []);
    }


}
