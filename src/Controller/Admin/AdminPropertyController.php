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

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $propertyRepository;
    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(PropertyRepository $propertyRepository, ObjectManager $manager)
    {

        $this->propertyRepository = $propertyRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {

        $properties = $this->propertyRepository->findAll();

        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
            'controller_name' => 'AdminPropertyController',

        ]);
    }

    /**
     * @Route("admin/property/create", name="admin.property.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function new(Request $request)
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($property);
            $this->manager->flush();
            $this->addFlash('success', 'Bien créer avec succes');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash('success', 'Bien modifié avec succés');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
            $this->manager->remove($property);
            $this->manager->flush();
            $this->addFlash('success', 'Bien supprimé avec succes');
        }
        return $this->redirectToRoute("admin.property.index");
    }
}
