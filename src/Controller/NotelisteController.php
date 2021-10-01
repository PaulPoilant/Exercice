<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\Note1Type;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/noteliste")
 */
class NotelisteController extends AbstractController
{
    /**
     * @Route("/{id}", name="noteliste_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository, String $id): Response
    {
        return $this->render('noteliste/index.html.twig', [
            'notes' => $noteRepository->findBy(["id_user"=>$id]),
        ]);
    }

    /**
     * @Route("/new", name="noteliste_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(Note1Type::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('noteliste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noteliste/new.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="noteliste_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('noteliste/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="noteliste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(Note1Type::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noteliste/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="noteliste_delete", methods={"POST"})
     */
    public function delete(Request $request, Note $note): Response
    {
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
    }
}
