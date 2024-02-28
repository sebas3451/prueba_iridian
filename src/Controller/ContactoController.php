<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Importar la clase Request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; 

class ContactoController extends AbstractController
{
    private $entityManager; // Declara una propiedad privada para el EntityManager

    // Inyecta EntityManager a través del constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contacto', name: 'contacto')]
    public function contacto(Request $request): Response
    {
        // Crear y manejar el formulario
        $contacto = new Contacto();
        $form = $this->createForm(ContactoFormType::class, $contacto);
        $form->handleRequest($request);
    
         if ($form->isSubmitted() && $form->isValid()) {

            // Verificar si ya existe un mensaje con el mismo correo y la misma fecha
            $correo = $request->request->get('correo');
            $existeMensaje = $this->entityManager->getRepository(Contacto::class)
                ->findOneBy([
                    'correo' => $correo, // Obtener la fecha actual
                ]);
        // Si ya existe un mensaje con el mismo correo y la misma fecha, mostrar un mensaje de error
            if ($existeMensaje) {
                var_dump('nullll');
                $this->addFlash('error', 'Ya has enviado un mensaje hoy.');
                return $this->redirectToRoute('ruta_de_tu_pagina_de_contacto');
            }
            $contacto->setFecha(new \DateTime()); // Agregar la fecha actual al mensaje
            $entityManager = $this->entityManager;
            $entityManager->persist($contacto);
            $entityManager->flush();
    
            $this->addFlash('success', 'Mensaje enviado correctamente.');
            return $this->redirectToRoute('contacto');
        }
    
        return $this->render('contacto/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
