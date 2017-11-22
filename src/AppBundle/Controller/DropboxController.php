<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\DiscoController;
use Symfony\Component\HttpFoundation\Request;


class DropboxController extends DiscoController
{
    /**
     * @Route("/dropbox", name="dropbox")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Une connexion est nécessaire.');
        return $this->render('dropbox/index.html.twig');
    }

    /**
     * @Route("/dropbox/uploader", name="dropbox_uploader")
     */
    public function uploaderAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Une connexion est nécessaire.');
        $upload_name = preg_replace('/[^A-Za-z0-9\-_ ]/', '', $request->request->get('upload_name'));
        return $this->render('dropbox/uploader.html.twig', array(
            'upload_name' => $upload_name,
        ));
    }
}
