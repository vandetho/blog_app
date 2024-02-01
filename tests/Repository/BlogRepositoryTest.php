<?php
declare(strict_types=1);

namespace App\Tests\Repository;

use App\DTO\Blog;
use App\DTO\User as UserDTO;
use App\Entity\User;
use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use App\Workflow\State\BlogState;
use Doctrine\ORM\NonUniqueResultException;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogRepositoryTest extends KernelTestCase
{
    private BlogRepository $blogRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->blogRepository = self::getContainer()->get(BlogRepository::class);
        $this->userRepository = self::getContainer()->get(UserRepository::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function testCreateBlog(): int
    {

        $faker = Factory::create();
        $user = new User();
        $user->setUsername($faker->userName());
        $this->userRepository->save($user);

        $title = $faker->sentence();
        $content = $faker->paragraph();
        $blog = $this->blogRepository->create();
        $blog->setTitle($title);
        $blog->setContent($content);
        $blog->setState(BlogState::NEW_BLOG);
        $blog->setUser($user);
        $this->blogRepository->save($blog);

        $dto = $this->blogRepository->findByIdAsDTO($blog->getId());
        $this->assertNotNull($dto);
        $this->assertSame(get_class($dto), Blog::class);
        $this->assertSame(get_class($dto->user), UserDTO::class);
        $this->assertSame($dto->user->username, $user->getUsername());
        return $dto->id;
    }
}
