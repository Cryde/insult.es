<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Insult;
use AppBundle\Repository\InsultRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("insult/{id}",
     *     options = { "expose" = true },
     *     name="single_insult"
     * )
     * @Method({"GET"})
     *
     * @param InsultRepository $insultRepository
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getInsultAction(InsultRepository $insultRepository, $id)
    {
        $insult = $insultRepository->find($id);

        return $this->render('@App/web/insult.html.twig', [
            'insult' => [
                'id'             => $insult->getId(),
                'value'          => $insult->getInsult(),
                'displayHashtag' => false
            ]
        ]);
    }

    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     *
     * @param InsultRepository $insultRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(InsultRepository $insultRepository)
    {
        /** @var Insult $randomInsult */
        $randomInsult = $insultRepository->getRandom();

        return $this->render('@App/web/insult.html.twig', [
            'insult' => [
                'id'             => $randomInsult->getId(),
                'value'          => $randomInsult->getInsult(),
                'displayHashtag' => true
            ]
        ]);
    }
}
