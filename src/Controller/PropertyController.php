<?php

namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LocationController
 * @package App\Applications\Home\Controller
 */
class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(
        PropertyRepository $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('pages/properties.html.twig', [
            'properties' => $properties,
            'current_menu' => 'properties',
            ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9/-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response
    {
        $propertySlug = $property->getSlug();
        if($slug !== $propertySlug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
                ],
                301);
        }
        return $this->render('pages/show.html.twig', [
            'property' => $property,
            'current_menu' => "properties"
        ]);
    }
}