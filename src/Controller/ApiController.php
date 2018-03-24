<?php

namespace App\Controller;

use App\Entity\Insult;
use App\Entity\InsultVote;
use App\Repository\InsultRepository;
use App\Repository\InsultVoteRepository;
use App\Services\VoterHasher;
use Cocur\Slugify\SlugifyInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/add",
     *     options = { "expose" = true },
     *     name = "api_add_insult"
     * )
     * @Method({"POST"})
     *
     * @param Request          $request
     * @param SlugifyInterface $slugify
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request, SlugifyInterface $slugify)
    {
        $em              = $this->getDoctrine()->getManager();
        $insult          = $request->get('insult', '');
        $canonicalInsult = $slugify->slugify($insult);

        $insultEntity = new Insult();
        $insultEntity->setInsult($insult);
        $insultEntity->setInsultCanonical($canonicalInsult);
        $insultEntity->setDatePost(new \DateTime());

        $validator = $this->get('validator');
        $errors    = $validator->validate($insultEntity);

        if (count($errors) > 0) {
            return $this->json(['success' => false, 'message' => $this->getErrorsArray($errors)]);
        }

        $em->persist($insultEntity);
        $em->flush();

        return $this->json(
            array_merge(
                ['success' => true],
                $this->formatInsult($insultEntity)
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/random",
     *     options = { "expose" = true },
     *     name = "api_get_random_insult"
     * )
     * @Method({"GET"})
     *
     * @param InsultRepository $insultRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRandomInsultAction(InsultRepository $insultRepository)
    {
        /** @var Insult $randomInsult */
        $randomInsult = $insultRepository->getRandom();

        return $this->json($this->formatInsult($randomInsult));
    }

    /**
     * @Route("/vote/{id}/{voteType}",
     *     options = { "expose" = true },
     *     name = "api_vote_insult"
     * )
     * @Method({"GET"})
     *
     * @param Insult               $insult
     * @param string               $voteType
     * @param VoterHasher          $voterHasher
     * @param InsultVoteRepository $insultVoteRepository
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function voteAction(
        Insult $insult,
        string $voteType,
        VoterHasher $voterHasher,
        InsultVoteRepository $insultVoteRepository
    ) {
        if (!in_array($voteType, [InsultVote::VOTE_UP, InsultVote::VOTE_DOWN])) {
            throw $this->createNotFoundException('Ce type de vote n\'est pas supportééééééééééééééé !');
        }

        $voterHash  = $voterHasher->hash();
        $insultVote = $insultVoteRepository->findOneBy(['insult' => $insult, 'voterHash' => $voterHash]);

        if (!$insultVote) {
            $newInsultVote = (new InsultVote())
                ->setInsult($insult)
                ->setVote($voteType === InsultVote::VOTE_UP ? 1 : -1)
                ->setVoterHash($voterHash);

            $this->getDoctrine()->getManager()->persist($newInsultVote);
        } else {
            $insultVote->setVote($voteType === InsultVote::VOTE_UP ? 1 : -1);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->json(['data' => ['vote' => InsultVote::VOTE_UP === $voteType ? 1 : -1]]);
    }

    /**
     * @Route("/insult/{id}",
     *     options = { "expose" = true },
     *     name = "api_get_insult"
     * )
     * @Method({"GET"})
     *
     * @param Insult $insult
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getInsultAction(Insult $insult)
    {
        return $this->json($this->formatInsult($insult));
    }

    /**
     * @param Insult $insult
     *
     * @return array
     */
    private function formatInsult(Insult $insult): array
    {
        return [
            'insult' => [
                'id'    => $insult->getId(),
                'value' => '#' . $insult->getInsult(),
                'url'   => $this->generateUrl('api_get_insult', ['id' => $insult->getId()])
            ]
        ];
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
