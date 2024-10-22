<?php

namespace App\Controller;

use App\Entity\DaneMeteorologiczne;
use App\Form\DaneMeteorologiczneType;
use App\Repository\DaneMeteorologiczneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dane/meteorologiczne')]
class DaneMeteorologiczneController extends AbstractController
{
    #[Route('/', name: 'app_dane_meteorologiczne_index', methods: ['GET'])]
    public function index(DaneMeteorologiczneRepository $daneMeteorologiczneRepository): Response
    {
        return $this->render('dane_meteorologiczne/index.html.twig', [
            'dane_meteorologicznes' => $daneMeteorologiczneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dane_meteorologiczne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $daneMeteorologiczne = new DaneMeteorologiczne();
        $form = $this->createForm(DaneMeteorologiczneType::class, $daneMeteorologiczne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($daneMeteorologiczne);
            $entityManager->flush();

            return $this->redirectToRoute('app_dane_meteorologiczne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dane_meteorologiczne/new.html.twig', [
            'dane_meteorologiczne' => $daneMeteorologiczne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dane_meteorologiczne_show', methods: ['GET'])]
    public function show(DaneMeteorologiczne $daneMeteorologiczne): Response
    {
        return $this->render('dane_meteorologiczne/show.html.twig', [
            'dane_meteorologiczne' => $daneMeteorologiczne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dane_meteorologiczne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DaneMeteorologiczne $daneMeteorologiczne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DaneMeteorologiczneType::class, $daneMeteorologiczne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dane_meteorologiczne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dane_meteorologiczne/edit.html.twig', [
            'dane_meteorologiczne' => $daneMeteorologiczne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dane_meteorologiczne_delete', methods: ['POST'])]
    public function delete(Request $request, DaneMeteorologiczne $daneMeteorologiczne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$daneMeteorologiczne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($daneMeteorologiczne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dane_meteorologiczne_index', [], Response::HTTP_SEE_OTHER);
    }
}
