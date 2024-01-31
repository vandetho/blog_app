<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Article
 *
 * @package App\Entity
 * @author Vandeth THO <thovandeth@gmail.com>
 */
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $title = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    /**
     * @var array
     */
    #[ORM\Column(length: 255)]
    private array $marking = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Article
    {
        $this->content = $content;
        return $this;
    }

    public function getMarking(): array
    {
        return $this->marking;
    }

    public function setMarking(array $marking): Article
    {
        $this->marking = $marking;
        return $this;
    }
}
