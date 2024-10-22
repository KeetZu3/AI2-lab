<?php

namespace App\Controller;

use App\Entity\Miejscowosc;
use App\Form\MiejscowoscType;
use App\Repository\MiejscowoscRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/miejscowosc')]
class MiejscowoscController extends AbstractController
{
    #[Route('/', name: 'app_miejscowosc_index', methods: ['GET'])]
    public function index(MiejscowoscRepository $miejscowoscRepository): Response
    {
        return $this->render('miejscowosc/index.html.twig', [
            'miejscowoscs' => $miejscowoscRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_miejscowosc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $miejscowosc = new Miejscowosc();
        $form = $this->createForm(MiejscowoscType::class, $miejscowosc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($miejscowosc);
            $entityManager->flush();

            return $this->redirectToRoute('app_miejscowosc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('miejscowosc/new.html.twig', [
            'miejscowosc' => $miejscowosc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_miejscowosc_show', methods: ['GET'])]
    public function show(Miejscowosc $miejscowosc): Response
    {
        return $this->render('miejscowosc/show.html.twig', [
            'miejscowosc' => $miejscowosc,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_miejscowosc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Miejscowosc $miejscowosc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MiejscowoscType::class, $miejscowosc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_miejscowosc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('miejscowosc/edit.html.twig', [
            'miejscowosc' => $miejscowosc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_miejscowosc_delete', methods: ['POST'])]
    public function delete(Request $request, Miejscowosc $miejscowosc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$miejscowosc->getId(), $request->request->get('_token'))) {
            $entityManager->remove($miejscowosc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_miejscowosc_index', [], Response::HTTP_SEE_OTHER);
    }
}
