<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\UserSteps;
use App\Form\StepType;
use App\Form\UserStepsType;
use App\Repository\UserStepsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/user/steps')]
class UserStepsController extends AbstractController
{
    #[Route('/', name: 'app_user_steps_index', methods: ['GET'])]
    public function index(UserStepsRepository $userStepsRepository): Response
    {
        $current_user_id = $this->getUser()->getId();
        return $this->render('user_steps/index.html.twig', [
            'user_steps' => $userStepsRepository->findByUser($current_user_id),
        ]);
    }

    #[Route('/new', name: 'app_user_steps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserStepsRepository $userStepsRepository, ManagerRegistry $doctrine, EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Step::class);
        $articles = $repository->findAll();

        $userStep = new UserSteps();
        $userStep->setUser($this->getUser());
        $form = $this->createForm(UserStepsType::class, $userStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userStepsRepository->add($userStep);
            return $this->redirectToRoute('app_user_steps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_steps/new.html.twig', [
            'user_step' => $userStep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_steps_show', methods: ['GET'])]
    public function show(UserSteps $userStep): Response
    {
        return $this->render('user_steps/show.html.twig', [
            'user_step' => $userStep,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_steps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserSteps $userStep, UserStepsRepository $userStepsRepository): Response
    {
        $form = $this->createForm(UserStepsType::class, $userStep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userStepsRepository->add($userStep);
            return $this->redirectToRoute('app_user_steps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_steps/edit.html.twig', [
            'user_step' => $userStep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_steps_delete', methods: ['POST'])]
    public function delete(Request $request, UserSteps $userStep, UserStepsRepository $userStepsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userStep->getId(), $request->request->get('_token'))) {
            $userStepsRepository->remove($userStep);
        }

        return $this->redirectToRoute('app_user_steps_index', [], Response::HTTP_SEE_OTHER);
    }
}
