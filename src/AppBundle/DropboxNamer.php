<?php

namespace AppBundle;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DropboxNamer implements NamerInterface
{
    private $tokenStorage;
    private $discoLogger;
    
    public function __construct(TokenStorage $tokenStorage, $discoLogger){
        $this->tokenStorage = $tokenStorage;
        $this->discoLogger = $discoLogger;
    }
    
    /**
     * Creates a user directory name for the file being uploaded.
     *
     * @param FileInterface $file
     * @return string The directory name.
     */
    public function name(FileInterface $file)
    {
        $filename = sprintf('%s.%s',
            $file->getBasename(),
            $file->getExtension()
        );

        $username = $this->tokenStorage->getToken()->getUser()->getUsername();
        $this->discoLogger->info($username." uploaded via the dropbox: ".$filename);

        return $filename;
    }
}
