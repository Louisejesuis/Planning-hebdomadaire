<?php

namespace App\Controller;

use App\Entity\StepCategory;
use App\Form\StepCategoryType;
use App\Repository\StepCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/step/category')]
class StepCategoryController extends AbstractController
{
    #[Route('/', name: 'app_step_category_index', methods: ['GET'])]
    public function index(StepCategoryRepository $stepCategoryRepository): Response
    {
        return $this->render('step_category/index.html.twig', [
            'step_categories' => $stepCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_step_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StepCategoryRepository $stepCategoryRepository): Response
    {
        $stepCategory = new StepCategory();
        $form = $this->createForm(StepCategoryType::class, $stepCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stepCategoryRepository->add($stepCategory);
            return $this->redirectToRoute('app_step_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('step_category/new.html.twig', [
            'step_category' => $stepCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_step_category_show', methods: ['GET'])]
    public function show(StepCategory $stepCategory): Response
    {
        return $this->render('step_category/show.html.twig', [
            'step_category' => $stepCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_step_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StepCategory $stepCategory, StepCategoryRepository $stepCategoryRepository): Response
    {
        $form = $this->createForm(StepCategoryType::class, $stepCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stepCategoryRepository->add($stepCategory);
            return $this->redirectToRoute('app_step_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('step_category/edit.html.twig', [
            'step_category' => $stepCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_step_category_delete', methods: ['POST'])]
    public function delete(Request $request, StepCategory $stepCategory, StepCategoryRepository $stepCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stepCategory->getId(), $request->request->get('_token'))) {
            $stepCategoryRepository->remove($stepCategory);
        }

        return $this->redirectToRoute('app_step_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
