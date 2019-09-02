<?php

namespace App\Controller;


use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Applications\Home\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="home.index")
     * @return Response
     */
    public function index(): Response
    {
        $latestProperties = $this->repository->findLatest();
        dump($latestProperties);
        return $this->render('pages/home.html.twig', [
            'latestProperties' => $latestProperties
        ]);
    }
}