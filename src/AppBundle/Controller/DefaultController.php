<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/placeholder", name="get-placeholder")
     * @Method("GET")
     */
    public function getPlaceholderImageAction(Request $request)
    {
        $text = $request->get('text');
        $height = $request->get('height');
        $width = $request->get('width');
        $color = $request->get('color');

        /* @var $placeHolderService \AppBundle\Service\PlaceholderService */
        $placeHolderService = $this->get('placeholder_service');
        $image = $placeHolderService->generatePlaceholderImage(
            $text,
            $height,
            $width,
            $color
        );

        var_dump(
            $text,
            $height,
            $width,
            $color
        );

        die();
    }
}
