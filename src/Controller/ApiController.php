<?php

namespace App\Controller;

use App\Entity\Insult;
use App\Repository\InsultRepository;
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
     * @param Request $request
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
