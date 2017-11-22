<?php
namespace AppBundle;

use Oneup\UploaderBundle\Event\PostPersistEvent;

class DropboxEventListener
{
    public function onUpload(PostPersistEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        $upload_name = $request->get('upload_name');
        $response['upload_name'] = $upload_name;
        $response['requestall'] = $request->request->all();
        $original_name = $request->files->get('files')[0]->getClientOriginalName();
        
        $file = $event->getFile();

        // move $file to $upload_name / $original_name ?
        // then what's logged by DropboxNamer ?

        // option 2 : log here.

        $response['success'] = true;
        return $response;
    }
}
