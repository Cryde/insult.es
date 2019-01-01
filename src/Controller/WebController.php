<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('web/insult.html.twig');
    }
}
