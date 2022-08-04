<?php

namespace App\Entity;

use App\Repository\TodoEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoEntityRepository::class)]
class TodoEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $Content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DueDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->DueDate;
    }

    public function setDueDate(\DateTimeInterface $DueDate): self
    {
        $this->DueDate = $DueDate;

        return $this;
    }
}
