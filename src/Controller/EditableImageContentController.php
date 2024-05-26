<?php

namespace App\Controller;

use App\Entity\EditableImageContent;
use App\Repository\EditableImageContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditableImageContentController extends AbstractController
{
    #[Route('/api/update-image-content', name: 'update_image_content', methods: ['POST'])]
    public function updateImageContent(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $item) {
            $imageContent = $em->getRepository(EditableImageContent::class)->findOneBy([
                'tag' => $item['tag'],
                'page' => $item['page']
            ]) ?? new EditableImageContent();

            $imageContent->setTag($item['tag']);
            $imageContent->setPage($item['page']);
            $imageContent->setSrcContent($item['srcContent']);

            $em->persist($imageContent);
        }

        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

    #[Route('/api/get-image-content', name: 'get_image_content', methods: ['GET'])]
    public function getImageContent(EditableImageContentRepository $repository): JsonResponse
    {
        $imageContents = $repository->findAll();
        $data = array_map(function (EditableImageContent $content) {
            return [
                'tag' => $content->getTag(),
                'page' => $content->getPage(),
                'srcContent' => $content->getSrcContent(),
            ];
        }, $imageContents);

        return new JsonResponse($data);
    }
}
