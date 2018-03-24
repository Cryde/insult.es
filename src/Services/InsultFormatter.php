<?php

namespace App\Services;

use App\Entity\Insult;

class InsultFormatter
{
    /**
     * @var VoteFinder
     */
    private $voteFinder;

    /**
     * InsultFormatter constructor.
     *
     * @param VoteFinder $voteFinder
     */
    public function __construct(VoteFinder $voteFinder)
    {
        $this->voteFinder = $voteFinder;
    }

    /**
     * @param Insult $insult
     *
     * @return array
     */
    public function format(Insult $insult): array
    {
        $insultVote = $this->voteFinder->findByInsult($insult);

        return [
            'insult' => [
                'id'           => $insult->getId(),
                'value'        => '#' . $insult->getInsult(),
                'current_vote' => $insultVote ? $insultVote->getVote() : null,
            ],
        ];
    }
}
