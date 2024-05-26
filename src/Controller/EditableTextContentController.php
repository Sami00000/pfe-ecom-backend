<?php

namespace App\Controller;

use App\Entity\EditableTextContent;
use App\Repository\EditableTextContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditableTextContentController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, EditableTextContentRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    #[Route('/api/update-text-content', name: 'update_text_content', methods: ['POST'])]
    public function updateTextContent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $item) {
            $tag = $item['tag'];
            $page = $item['page'];

            $textContent = $this->repository->findOneBy(['tag' => $tag, 'page' => $page]);

            if (!$textContent) {
                $textContent = new EditableTextContent();
                $textContent->setTag($tag);
                $textContent->setPage($page);
                $textContent->setTextContent(''); // Set an initial empty value or default content if necessary
                $this->entityManager->persist($textContent);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success'], 200);
    }

    #[Route('/api/get-text-content', name: 'get_text_content', methods: ['GET'])]
    public function getTextContent(): JsonResponse
    {
        $textContents = $this->repository->findAll();
        $data = [];

        foreach ($textContents as $textContent) {
            $data[] = [
                'tag' => $textContent->getTag(),
                'page' => $textContent->getPage(),
                'textContent' => $textContent->getTextContent()
            ];
        }

        return new JsonResponse($data, 200);
    }
}
