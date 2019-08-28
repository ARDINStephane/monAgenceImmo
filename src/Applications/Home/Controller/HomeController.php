<?php

namespace App\Applications\Home\Controller;


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
     * @Route("/", name="home.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }
}