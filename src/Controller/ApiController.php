<?php

namespace App\Controller;

use App\Entity\Insult;
use App\Entity\InsultVote;
use App\Repository\InsultRepository;
use App\Services\InsultFormatter;
use App\Services\Vote\VoteHandler;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/add",
     *     options = { "expose" = true },
     *     name = "api_add_insult",
     *     methods={"POST"}
     * )
     *
     * @param Request            $request
     * @param SlugifyInterface   $slugify
     * @param InsultFormatter    $insultFormatter
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     */
    public function addAction(Request $request, SlugifyInterface $slugify, InsultFormatter $insultFormatter, ValidatorInterface $validator)
    {
        $em              = $this->getDoctrine()->getManager();
        $insult          = $request->get('insult', '');
        $canonicalInsult = $slugify->slugify($insult);

        $insultEntity = new Insult();
        $insultEntity->setInsult($insult);
        $insultEntity->setInsultCanonical($canonicalInsult);

        $errors = $validator->validate($insultEntity);

        if (count($errors) > 0) {
            return $this->json(['success' => false, 'message' => $this->getErrorsArray($errors)]);
        }

        $em->persist($insultEntity);
        $em->flush();

        return $this->json(
            array_merge(
                ['success' => true],
                $insultFormatter->format($insultEntity)
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/random",
     *     options = { "expose" = true },
     *     name = "api_get_random_insult",
     *     methods={"GET"}
     * )
     *
     * @param InsultRepository $insultRepository
     * @param InsultFormatter  $insultFormatter
     *
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getRandomInsultAction(InsultRepository $insultRepository, InsultFormatter $insultFormatter)
    {
        /** @var Insult $randomInsult */
        $randomInsult = $insultRepository->getRandom();

        return $this->json($insultFormatter->format($randomInsult));
    }

    /**
     * @Route("/vote/{id}/{voteType}",
     *     options = { "expose" = true },
     *     name = "api_vote_insult",
     *     methods={"GET"}
     * )
     *
     * @param Insult      $insult
     * @param string      $voteType
     * @param VoteHandler $voteHandler
     *
     * @return JsonResponse
     */
    public function voteAction(Insult $insult, string $voteType, VoteHandler $voteHandler)
    {
        if (!in_array($voteType, [InsultVote::VOTE_UP, InsultVote::VOTE_DOWN])) {
            throw $this->createNotFoundException('Ce type de vote n\'est pas supportééééééééééééééé !');
        }

        $vote = $voteType === InsultVote::VOTE_UP ? 1 : -1;
        $voteHandler->handleVote($insult, $vote);

        return $this->json(['data' => ['vote' => $vote]]);
    }

    /**
     * @Route("/insult/{id}",
     *     options = { "expose" = true },
     *     name = "api_get_insult",
     *     methods={"GET"}
     * )
     *
     * @param Insult          $insult
     * @param InsultFormatter $insultFormatter
     *
     * @return JsonResponse
     */
    public function getInsultAction(Insult $insult, InsultFormatter $insultFormatter)
    {
        return $this->json($insultFormatter->format($insult));
    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return array
     */
    private function getErrorsArray(ConstraintViolationListInterface $errors): array
    {
        $strErrors = [];
        foreach ($errors as $error) {
            $strErrors[] = $error->getMessage();
        }

        return $strErrors;
    }
}
