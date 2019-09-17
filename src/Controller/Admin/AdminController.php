<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(
        PropertyRepository $repository,
        ObjectManager $em
    )
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property")
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();

        return $this->render('admin/property.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods={"GET", "POST"})
     * @return Response
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');

            return $this->redirectToRoute('admin.property');
        }
        $property = $this->repository->find($property->getId());

        return $this->render('admin/editproperty.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/new", name="admin.property.new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Créé avec succès');

            return $this->redirectToRoute('admin.property');
        }

        return $this->render('admin/newproperty.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @return Response
     */
    public function delete(Property $property, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Supprimé avec succès');
        }

        return $this->redirectToRoute('admin.property');

    }
}