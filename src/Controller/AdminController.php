<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\Projects1Type;
use App\Form\ProjectsType;;

use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @Route("/", name="projects_index_admin", methods={"GET"})
     */
    public function showAdmin(ProjectsRepository $projectsRepository): Response
    {
        return $this->render('admin/show.html.twig', [
            'projects' => $projectsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projects_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Projects $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Projects1Type::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projects/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="projects_delete", methods={"POST"})
     */
    public function delete(Request $request, Projects $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projects_index', [], Response::HTTP_SEE_OTHER);
    }
}
