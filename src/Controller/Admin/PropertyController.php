<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {

        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index()
    {

        $properties = $this->propertyRepository->findAll();

        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties,
            'controller_name' => 'PropertyController',

        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     */
    public function edit(Property $property)
    {
        $form = $this->createForm(PropertyType::class, $property);
        return $this->render('admin/property/edit.html.twig',[
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }
}
