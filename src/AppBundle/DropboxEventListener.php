<?php
namespace AppBundle;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DropboxEventListener
{
    private $tokenStorage;
    private $discoLogger;
    
    public function __construct(TokenStorage $tokenStorage, $discoLogger){
        $this->tokenStorage = $tokenStorage;
        $this->discoLogger = $discoLogger;
    }
    
    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();

        $username = $this->tokenStorage->getToken()->getUser()->getUsername();
        $dropbox_folder = $username.'-'.$request->get('upload_name');

        $file = $event->getFile();
        $dropbox_basedir = dirname($file->getRealPath());
        $original_name = $request->files->get('files')[0]->getClientOriginalName();
        $file->move($dropbox_basedir.DIRECTORY_SEPARATOR.$dropbox_folder, $original_name);

        $this->discoLogger->info($username." uploaded ".$dropbox_folder.'/'.$original_name);

        $response = $event->getResponse();
        $response['success'] = true;
        return $response;
    }
}
