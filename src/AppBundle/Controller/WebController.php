<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Insult;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        /** @var Insult $randomInsult */
        $randomInsult = $this->getDoctrine()->getRepository(Insult::class)->getRandom();

        return $this->render('@App/web/insult.html.twig', [
            'insult' => [
                'id'    => $randomInsult->getId(),
                'value' => $randomInsult->getInsult()
            ]
        ]);
    }
}
