<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Insult
 *
 * @ORM\Table(name="insult")
 * @ORM\Entity(repositoryClass="App\Repository\InsultRepository")
 * @UniqueEntity(fields="insultCanonical", message="Cette insulte a déjà été postée.")
 */
class Insult
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="insult", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 250,
     *      minMessage = "Ton insulte doit au moins faire {{ limit }} caractères",
     *      maxMessage = "Pas plus de {{ limit }} caractères STP"
     * )
     */
    private $insult;
    /**
     * @var string
     *
     * @ORM\Column(name="insult_canonical", type="string", length=255, unique=true)
     */
    private $insultCanonical;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_post", type="datetime")
     */
    private $datePost;
    /**
     * @var int
     *
     * @ORM\Column(type="integer",options={"unsigned":true, "default":"0"})
     */
    private $totalVoteUp;
    /**
     * @var int
     *
     * @ORM\Column(type="integer",options={"unsigned":true, "default":"0"})
     */
    private $totalVoteDown;

    /**
     * Insult constructor.
     */
    public function __construct()
    {
        $this->datePost      = new \DateTime();
        $this->totalVoteUp   = 0;
        $this->totalVoteDown = 0;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get insult
     *
     * @return string
     */
    public function getInsult(): string
    {
        return $this->insult;
    }

    /**
     * Set insult
     *
     * @param string $insult
     *
     * @return Insult
     */
    public function setInsult(string $insult)
    {
        $this->insult = $insult;

        return $this;
    }

    /**
     * Get insultCanonical
     *
     * @return string
     */
    public function getInsultCanonical(): string
    {
        return $this->insultCanonical;
    }

    /**
     * Set insultCanonical
     *
     * @param string $insultCanonical
     *
     * @return Insult
     */
    public function setInsultCanonical(string $insultCanonical)
    {
        $this->insultCanonical = $insultCanonical;

        return $this;
    }

    /**
     * Get datePost
     *
     * @return \DateTime
     */
    public function getDatePost(): \DateTime
    {
        return $this->datePost;
    }

    /**
     * Set datePost
     *
     * @param \DateTime $datePost
     *
     * @return Insult
     */
    public function setDatePost(\DateTime $datePost)
    {
        $this->datePost = $datePost;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalVoteUp(): int
    {
        return $this->totalVoteUp;
    }

    /**
     * @param int $totalVoteUp
     *
     * @return Insult
     */
    public function setTotalVoteUp(int $totalVoteUp): Insult
    {
        $this->totalVoteUp = $totalVoteUp;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalVoteDown(): int
    {
        return $this->totalVoteDown;
    }

    /**
     * @param int $totalVoteDown
     *
     * @return Insult
     */
    public function setTotalVoteDown(int $totalVoteDown): Insult
    {
        $this->totalVoteDown = $totalVoteDown;

        return $this;
    }
}
