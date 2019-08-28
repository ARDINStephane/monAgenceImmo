<?php

namespace App\Applications\Home\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LocationController
 * @package App\Applications\Home\Controller
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/location", name="location.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/locations.html.twig', ['current_menu' => 'locations']);
    }
}