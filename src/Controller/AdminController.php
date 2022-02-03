<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/home", name="home_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/profil.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request): Response
    {
        $projects = new Projects();
        $form = $this->createForm(ProjectsType::class, $projects);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($projects);

            $entityManager->flush();

            return $this->redirectToRoute('home_index');
        }

        return $this->render('admin/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }
}
