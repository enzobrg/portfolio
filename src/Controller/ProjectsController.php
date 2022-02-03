<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\Projects1Type;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/projects")
 */
class ProjectsController extends AbstractController
{
    /**
     * @Route("/", name="projects_index", methods={"GET"})
     */
    public function index(ProjectsRepository $projectsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'projects' => $projectsRepository->findAll(),
        ]);
    }
}
