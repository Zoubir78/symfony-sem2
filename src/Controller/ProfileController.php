<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile_")
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
    * @Route("/", name="edit")
    */
    public function index(Request $request, EntityManagerInterface $em)
    {
        // Reécupération de l'utilisateur connecté
        $user = $this->getUser();
        
        // Passage de l'utilisateur au formulaire
        $profileForm = $this->createForm(UserProfileFormType::class, $user);
        $profileForm->handleRequest($request);

        // Vérification de la validité
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            // Récupération des données de formulaire
            $user = $profileForm->getData();

            // Mise à jour de l'entité en BDD
            $em->persist($user);
            $em->flush();

            // Message flash
            $this->addFlash('success', 'Votre profil a été mis à jour.');
        }  

        return $this->render('profile/index.html.twig', [
            'profile_form' => $profileForm->createView(),
        ]);
    }
}
