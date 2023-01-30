<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    /**
     * This function display all menus
     *
     * @param MenuRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/menu', name: 'menu.index', methods:['GET'])]
    public function index(MenuRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $menus = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/menu/index.html.twig', [
            'menus' => $menus,
        ]);
    }

    /**
     * This function is used to create a menu
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/menu/new', name: 'menu.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $menus = new Menu();
        $form = $this->createForm(MenuType::class, $menus);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $menus = $form->getData();
            
            $manager->persist($menus);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre formule a été créée avec succès !'
            );

        return $this->redirectToRoute('menu.index');

        }

        return $this->render('pages/menu/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This function is used to edit a menu
     *
     * @param Menu $menu
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    #[Route('/menu/edit/{id}', 'menu.edit', methods:['GET', 'POST'])]
    public function edit(Menu $menu, EntityManagerInterface $manager, Request $request): Response
    {
        
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $menu = $form->getData();
            
            $manager->persist($menu);
            $manager->flush();

            $this->addFlash(
                'info',
                'Votre formule a été modifiée avec succès !'
            );

        return $this->redirectToRoute('menu.index');

        }

        return $this->render('pages/menu/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * This function is used to delete a menu
     *
     * @param Menu $menu
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/menu/delete/{id}', 'menu.delete', methods:['GET'])]
    public function delete(Menu $menu, EntityManagerInterface $manager): Response
    {
        $manager->remove($menu);
        $manager->flush();

        $this->addFlash(
            'warning',
            'Votre formule a été supprimée avec succès !'
        );
        return $this->redirectToRoute('menu.index', []);
    }

}
