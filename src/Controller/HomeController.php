<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/home", name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $projects = $managerRegistry->getRepository(Projects::class)->findAll();
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
