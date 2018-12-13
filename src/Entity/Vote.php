<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vote;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quote", inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idQuote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVote(): ?int
    {
        return $this->vote;
    }

    public function setVote(int $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdQuote(): ?Quote
    {
        return $this->idQuote;
    }

    public function setIdQuote(?Quote $idQuote): self
    {
        $this->idQuote = $idQuote;

        return $this;
    }
}
