<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Insult
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Repository\InsultVoteRepository")
 */
class InsultVote
{
    const VOTE_UP   = 'up';
    const VOTE_DOWN = 'down';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var Insult
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Insult")
     */
    private $insult;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $creationDatetime;
    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $vote;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $voterHash;

    /**
     * InsultVote constructor.
     */
    public function __construct()
    {
        $this->creationDatetime = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return InsultVote
     */
    public function setId(int $id): InsultVote
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Insult
     */
    public function getInsult(): Insult
    {
        return $this->insult;
    }

    /**
     * @param Insult $insult
     *
     * @return InsultVote
     */
    public function setInsult(Insult $insult): InsultVote
    {
        $this->insult = $insult;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDatetime(): \DateTime
    {
        return $this->creationDatetime;
    }

    /**
     * @param \DateTime $creationDatetime
     *
     * @return InsultVote
     */
    public function setCreationDatetime(\DateTime $creationDatetime): InsultVote
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }

    /**
     * @return int
     */
    public function getVote(): int
    {
        return $this->vote;
    }

    /**
     * @param int $vote
     *
     * @return InsultVote
     */
    public function setVote(int $vote): InsultVote
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * @return string
     */
    public function getVoterHash(): string
    {
        return $this->voterHash;
    }

    /**
     * @param string $voterHash
     *
     * @return InsultVote
     */
    public function setVoterHash(string $voterHash): InsultVote
    {
        $this->voterHash = $voterHash;

        return $this;
    }
}
