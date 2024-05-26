<?php

namespace App\Test\Controller;

use App\Entity\EditableImageContent;
use App\Repository\EditableImageContentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditableImageContentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EditableImageContentRepository $repository;
    private string $path = '/editable/image/content/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(EditableImageContent::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EditableImageContent index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'editable_image_content[srcContent]' => 'Testing',
            'editable_image_content[tag]' => 'Testing',
            'editable_image_content[page]' => 'Testing',
            'editable_image_content[createdAt]' => 'Testing',
            'editable_image_content[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/editable/image/content/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EditableImageContent();
        $fixture->setSrcContent('My Title');
        $fixture->setTag('My Title');
        $fixture->setPage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EditableImageContent');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EditableImageContent();
        $fixture->setSrcContent('My Title');
        $fixture->setTag('My Title');
        $fixture->setPage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'editable_image_content[srcContent]' => 'Something New',
            'editable_image_content[tag]' => 'Something New',
            'editable_image_content[page]' => 'Something New',
            'editable_image_content[createdAt]' => 'Something New',
            'editable_image_content[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/editable/image/content/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSrcContent());
        self::assertSame('Something New', $fixture[0]->getTag());
        self::assertSame('Something New', $fixture[0]->getPage());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EditableImageContent();
        $fixture->setSrcContent('My Title');
        $fixture->setTag('My Title');
        $fixture->setPage('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/editable/image/content/');
    }
}
