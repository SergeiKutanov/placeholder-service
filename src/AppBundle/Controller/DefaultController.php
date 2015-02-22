<?php

namespace AppBundle\Controller;

use AppBundle\Form\PlaceholderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }

    /**
     * @Route("/placeholder/{format}", name="get-placeholder", defaults={"format": "browser"}, requirements={"format" = "(browser|file)"})
     * @Method("GET")
     */
    public function getPlaceholderImageAction(Request $request, $format)
    {
        $text = urldecode($request->get('text'));
        $height = $request->get('height');
        $width = $request->get('width');
        $color = $request->get('color');
        $fontColor = $request->get('font-color');
        $fontSize = $request->get('font-size');

        /* @var $placeHolderService \AppBundle\Service\PlaceholderService */
        $placeHolderService = $this->get('placeholder_service');
        $image = $placeHolderService->generatePlaceholderImage(
            $text,
            $height,
            $width,
            $color,
            $fontColor,
            $fontSize
        );

        $response = new Response();

        $response->headers->set(
            'Content-Type',
            'image/png'
        );
        if ($format == 'file') {
            $response->headers->set(
                'Content-Disposition',
                'attachment; filename="placeholder.png";'
            );
        }
        $response->sendHeaders();

        imagepng($image);
        imagedestroy($image);

        return $response;

    }

    /**
     * @Route("/build-online", name="build-online")
     * @Method("GET")
     */
    public function generateOnlineAction()
    {

        $form = $this->createForm(
            new PlaceholderType(),
            null,
            array(
                'method'    => 'GET',
                'action'    => $this->generateUrl('build-online'),
                'attr'      => array(
                    'class' => 'form-horizontal'
                )
            )
        );

        return $this->render(
            'AppBundle::build-online.html.twig',
            array(
                'form'  => $form->createView()
            )
        );
    }
}
