<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Insult
 *
 * @ORM\Table(name="insult")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InsultRepository")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set insult
     *
     * @param string $insult
     *
     * @return Insult
     */
    public function setInsult($insult)
    {
        $this->insult = $insult;

        return $this;
    }

    /**
     * Get insult
     *
     * @return string
     */
    public function getInsult()
    {
        return $this->insult;
    }

    /**
     * Set insultCanonical
     *
     * @param string $insultCanonical
     *
     * @return Insult
     */
    public function setInsultCanonical($insultCanonical)
    {
        $this->insultCanonical = $insultCanonical;

        return $this;
    }

    /**
     * Get insultCanonical
     *
     * @return string
     */
    public function getInsultCanonical()
    {
        return $this->insultCanonical;
    }

    /**
     * Set datePost
     *
     * @param \DateTime $datePost
     *
     * @return Insult
     */
    public function setDatePost($datePost)
    {
        $this->datePost = $datePost;

        return $this;
    }

    /**
     * Get datePost
     *
     * @return \DateTime
     */
    public function getDatePost()
    {
        return $this->datePost;
    }
}

