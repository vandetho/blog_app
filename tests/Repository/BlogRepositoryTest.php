<?php
declare(strict_types=1);

namespace App\Tests\Repository;

use App\DTO\Blog;
use App\Repository\BlogRepository;
use App\Workflow\State\BlogState;
use Doctrine\ORM\NonUniqueResultException;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogRepositoryTest extends KernelTestCase
{
    private BlogRepository $blogRepository;

    protected function setUp(): void
    {
        $this->blogRepository = self::getContainer()->get(BlogRepository::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function testCreateBlog(): int
    {
        $faker = Factory::create();
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $blog = $this->blogRepository->create();
        $blog->setTitle($title);
        $blog->setContent($content);
        $blog->setState(BlogState::NEW_BLOG);
        $this->blogRepository->save($blog);

        $dto = $this->blogRepository->findByIdAsDTO($blog->getId());
        $this->assertNotNull($dto);
        $this->assertSame(get_class($dto), Blog::class);
        return $dto->id;
    }
}
