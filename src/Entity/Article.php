<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     */
    private $usersWhoLikeIt;

    public $isLiked;


    public function __construct()
    {
        $this->usersWhoLikeIt = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersWhoLikeIt(): Collection
    {
        return $this->usersWhoLikeIt;
    }

    public function addUsersWhoLikeIt(User $usersWhoLikeIt): self
    {
        if (!$this->usersWhoLikeIt->contains($usersWhoLikeIt)) {
            $this->usersWhoLikeIt[] = $usersWhoLikeIt;
        }

        return $this;
    }

    public function removeUsersWhoLikeIt(User $usersWhoLikeIt): self
    {
        if ($this->usersWhoLikeIt->contains($usersWhoLikeIt)) {
            $this->usersWhoLikeIt->removeElement($usersWhoLikeIt);
        }

        return $this;
    }
}
