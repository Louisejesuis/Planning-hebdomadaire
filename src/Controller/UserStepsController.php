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
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/user/steps')]
class UserStepsController extends AbstractController
{
    /**
     * Format list of UserSteps Entity by day of the current week and by current user
     * @return $stepsByDays = [
     *      [
     *          'date' = string of the day,
     *          'steps' = array of Steps Entity,
     *          'total_duration' => total duration of all the steps of the day
     *      ]
     * ]
     */
    public function FormatStepsByDays(UserStepsRepository $userStepsRepository): array
    {

        $stepsByDays = [];


        $firstDayOfCurrentWeek = new DateTime();
        $firstDayOfCurrentWeek->setISODate(date('Y'), date('W'));

        // Loop on each day of the current week
        for ($i = 0; $i < 7; $i++) {

            $stepsByDays[$i]['date'] = $firstDayOfCurrentWeek
                ->modify('+' . $i . ' day')
                ->format('Y-m-d');

            $stepsByDays[$i]['steps'] = $userStepsRepository
                ->findByDateAndUser(
                    $this->getUser()->getId(),
                    $stepsByDays[$i]['date']
                );


            $minutes = 0;
            foreach ($stepsByDays[$i]['steps'] as $step) {
                $time = $step
                    ->getDuration()
                    ->format('H:i');
                list($hour, $minute) = explode(':', $time);
                $minutes += $hour * 60;
                $minutes += $minute;
            }
            $hours = floor($minutes / 60);
            $minutes -= $hours * 60;
            $stepsByDays[$i]['total_duration'] = sprintf('%02d:%02d', $hours, $minutes);
        };
        return $stepsByDays;
    }

    #[Route('/', name: 'app_user_steps_index', methods: ['GET'])]
    public function index(UserStepsRepository $userStepsRepository): Response
    {
        //var_dump($this->FormatStepsByDays($userStepsRepository));
        return $this->render('user_steps/index.html.twig', [
            'stepsByDays' => $this->FormatStepsByDays($userStepsRepository),
        ]);
    }

    #[Route('/new', name: 'app_user_steps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserStepsRepository $userStepsRepository, ManagerRegistry $doctrine, EntityManagerInterface $em): Response
    {

        $selectedDate = new DateTime($request->get('selected_date'));

        $userStep = new UserSteps();
        $userStep->setUser($this->getUser());
        $form = $this->createForm(UserStepsType::class, $userStep, ['selected_date' => $selectedDate]);
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
