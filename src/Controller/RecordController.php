<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Label;
use App\Entity\Record;
use App\Entity\Note;
use App\Form\NoteFormType;
use App\Repository\ArtistRepository;
use App\Repository\NoteRepository;
use App\Repository\RecordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RecordController extends AbstractController
{
    /**
     * Liste des artistes
     * @Route("/artist", name="artist_list")
     */
    public function index(ArtistRepository $repository)
    {
        return $this->render('record/artist_list.html.twig', [
            'artist_list' => $repository->findAll(),
        ]);
    }

    /**
     * Page d'un artiste
     * @Route("/artist/{id}", name="artist_page")
     */
    public function artistPage(Artist $artist)
    {
        return $this->render('record/artist_page.html.twig', [
            'artist' => $artist
        ]);
    }

    /**
     * Page d'un album
     * @Route("/record/{id}", name="record_page")
     * @IsGranted("ROLE_USER")
     */
    public function recordPage(Request $request, Record $record, EntityManagerInterface $em, Security $security, NoteRepository $noteRepository)
    {
        $note = (new Note())
                ->setRecord($record)
                ->setUser($this->getUser())
            ;

        $noteForm = $this->createForm(NoteFormType::class, $note);
        $noteForm->handleRequest($request);

        if ($noteForm->isSubmitted() && $noteForm->isValid()) {
            $note = $noteForm->getData();

            $em->persist($note);
            $em->flush();

            $this->addFlash('success', 'Note enregistrée !');
        }

        return $this->render('record/record_page.html.twig', [
        'record' => $record,
        'note_form' => $noteForm->createView()
        ]);
    
    }

    /**
     * Nouveaux albums
     * @Route("/news", name="record_news")
     * //@IsGranted("ROLE_ADMIN")
     */
    public function recordNews(RecordRepository $repository)
    {
        return $this->render('record/record_news.html.twig', [
            'record_news' => $repository->findNews(),
        ]);
    }

    /**
     * Nouveaux albums
     * @Route("/label/{id}", name="label_page")
     */
    public function labelPage(Label $label)
    {
        return $this->render('record/label_page.html.twig', [
            'label' => $label,
        ]);
    }
}