<?php

namespace App\Controller;


use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhotoController extends AbstractController
{
    #[Route('/', name: 'photos')]
    public function index(PhotoRepository $repository): Response
    {
        $photo = new Photo();
        $formulaire = $this->createForm(PhotoType::class, $photo);

        return $this->renderForm('photo/index.html.twig', [
            'formulaire'=>$formulaire,
            'photos'=>$repository->findAll()
        ]);
    }

    #[Route('/new', name: 'new_photos')]
    public function new(Request $request, EntityManagerInterface $manager){

        $photo = new Photo();
        $formulaire = $this->createForm(PhotoType::class, $photo);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()){

            $manager->persist($photo);
            $manager->flush();


        }

        return $this->redirectToRoute('photos');
    }
}
