<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     */
    public function addAction()
    {
        return $this->json(['success' => 'ok']);
    }
}
