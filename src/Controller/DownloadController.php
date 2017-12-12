<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    /**
     * @Route("/download{path}", name="download_show", options={ "i18n"=false }, requirements={"path"=".+"})
     */
    public function showAction(string $path): Response
    {
        $mediaManagerRoot = getenv('MEDIA_PATH');

        try {
            return new BinaryFileResponse($mediaManagerRoot . $path);
        } catch (FileNotFoundException $exception) {
            throw $this->createNotFoundException('File not found.', $exception);
        }
    }
}
