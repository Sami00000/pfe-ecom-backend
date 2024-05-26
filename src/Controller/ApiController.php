<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;
class ApiController extends AbstractController
{
    #[Route('/api/question/add', name: 'api_question_add', methods: ['POST'])]
    public function addQuestion(Request $request, EntityManagerInterface $em): Response
    {
        // Retrieve parameters from the request body
        $data = json_decode($request->getContent(), true);
        $questionText = $data['question'] ?? null;
        $senderEmail = $data['senderemail'] ?? null;
        $senderFirstname = $data['senderfirstname'] ?? null;
        $senderLastname = $data['senderlastname'] ?? null;

        // Validate parameters
        if (empty($questionText) || empty($senderEmail) || empty($senderFirstname) || empty($senderLastname)) {
            return new Response('Missing required parameters', Response::HTTP_BAD_REQUEST);
        }

        // Create a new Question entity
        $question = new Question();
        $question->setQuestionText($questionText);
        $question->setSenderEmail($senderEmail);
        $question->setSenderFirstname($senderFirstname);
        $question->setSenderLastname($senderLastname);
        $question->setDate(new \DateTime());
        $question->setIsAnswered(false);

        // Persist the entity
        $em->persist($question);
        $em->flush();

        // Return a response indicating success
        return new Response('Question was created', Response::HTTP_CREATED);
    }
}
