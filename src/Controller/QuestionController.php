<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;
use App\Repository\QuestionRepository;
#[Route('/question', name: 'app_question.')]
class QuestionController extends AbstractController
{
    #[Route('/all', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Question::class);
        $questions = $repo->findAll();
        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
        