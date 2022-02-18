<?php

namespace App\Controller;

use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use App\Entity\AnnonceCat;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(): Response
    {
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        ]);
    }
    /**
     * @Route ("/back/afficheAnnonce", name="afficheAnnonce")
     */
    public function afficheAnnonce(AnnonceRepository $repo)
    {
        $annonce=$repo->findAll();
        return $this->render('back_office/afficheAnnonce.html.twig',[
            'annonce'=>$annonce
        ]);
    }
    /**
     * @Route ("back/delete{id}", name="delete")
     */
    public function deleteAnnonce(AnnonceRepository $repo,$id)
    {
        $annonce=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('afficheAnnonce');
    }
    /**
     * @Route ("annonce/processeur", name="add" )
     */
    public function addAnnonce(Request $request, FileUploader $fileUploader)
    {
        $annonce=new Annonce();
        $form=$this->createForm(AnnonceType::class,$annonce);
        $form->add('Post',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $file = $form->get('image')->getData();
            if ($file) {
                $fileName = $fileUploader->upload($file);
                $annonce->setImage($fileName);
            }
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('afficheAnnonce');
        }
        return $this->render('annonce/processeur.html.twig',[
            'form'=>$form->createView()
        ]);

    }
}
