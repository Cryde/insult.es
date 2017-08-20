<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Insult;
use AppBundle\Repository\InsultRepository;
use Cocur\Slugify\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request, Slugify $slugify)
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
            $strErrors = [];
            foreach ($errors as $error) {
                $strErrors[] = $error->getMessage();
            }

            return $this->json(['success' => false, 'message' => $strErrors]);
        }

        $em->persist($insultEntity);
        $em->flush();

        return $this->json([
            'success' => true,
            'insult'  => ['id' => $insultEntity->getId(), 'value' => $insultEntity->getInsult()]
        ], Response::HTTP_CREATED);
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
                'value' => '#' . $insult->getInsult()
            ]
        ];
    }
}
