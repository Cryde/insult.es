<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Insult;
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
     *     name = "api_add_insult",
     *     condition="request.isXmlHttpRequest()"
     * )
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $insult = $request->get('insult', '');
        $canonicalinsult = $this->get('slugify')->slugify($insult);

        $insultEntity = new Insult();
        $insultEntity->setInsult($insult);
        $insultEntity->setInsultCanonical($canonicalinsult);
        $insultEntity->setDatePost(new \DateTime());

        $validator = $this->get('validator');
        $errors = $validator->validate($insultEntity);

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
}
