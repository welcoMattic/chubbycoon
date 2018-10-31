<?php

namespace App\Controller;

use App\Traits\UploadTrait;
use Knp\DoctrineBehaviors\Model\Sluggable\Transliterator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/admin/media")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class MediaController extends Controller
{
    use UploadTrait;

    protected $kernelProjectDir;

    public function __construct(string $kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    /**
     * @Route("/explore{path}", name="admin_media_explorer", requirements={"path"=".+"})
     */
    public function exploreAction(Request $request, string $path = '')
    {
        $mediaManagerRoot = getenv('MEDIA_PATH');

        $finder = (new Finder())->depth('== 0')->in($mediaManagerRoot . $path);

        /* File upload form */
        $formUpload = $this->createUploadForm();
        if ($formUpload->handleRequest($request)->isSubmitted() && $formUpload->isValid()) {
            $file = $formUpload->getData()['file'];
            try {
                $this->uploadFile($file, ltrim($path, '/'));
                $this->addFlash('success', 'Fichier envoyé avec succès.');
            } catch (FileException $e) {
                $this->addFlash('error', 'Impossible de sauver le fichier, contactez un administrateur.');
            }

            return $this->redirectToRoute('admin_media_explorer', ['path' => $path]);
        }

        /* Directory creation form */
        $formFolder = $this->createCreateFolderForm();
        if ($formFolder->handleRequest($request)->isSubmitted() && $formFolder->isValid()) {
            $folderName = $formFolder->getData()['folderName'];
            $folderName = (new Transliterator())->transliterate($folderName);
            try {
                (new Filesystem())->mkdir($mediaManagerRoot . $path . DIRECTORY_SEPARATOR . $folderName);
                $this->addFlash('success', 'Dossier créé avec succès.');
            } catch (IOExceptionInterface $e) {
                $this->addFlash('error', 'Impossible de créer le dossier, contactez un administrateur.');
            }

            return $this->redirectToRoute('admin_media_explorer', ['path' => $path]);
        }

        return $this->render('admin/media_explorer.html.twig', [
            'ckeditor' => $request->query->has('CKEditor'),
            'directories' => $finder->directories()->getIterator(),
            'medias' => $finder->files()->getIterator(),
            'currentPath' => $path,
            'formUpload' => $formUpload->createView(),
            'formFolder' => $formFolder->createView(),
            'breadcrumb' => $this->generateBreadcrumb($path, 'admin_media_explorer'),
        ]);
    }

    private function generateBreadcrumb(string $path, string $routeName): array
    {
        $router = $this->get('router');
        $breadcrumb = [];
        $folderName = substr($path, 1);
        $previousPath = '';
        $breadcrumb[] = [
            'url' => $router->generate($routeName),
            'name' => 'Media Explorer',
        ];
        foreach (explode('/', $folderName) as $part) {
            if (empty($part)) {
                continue;
            }
            $breadcrumb[] = [
                'url' => $router->generate($routeName, ['path' => $previousPath . '/' . $part]),
                'name' => $part,
            ];
            $previousPath .= sprintf('/%s', $part);
        }

        return $breadcrumb;
    }

    private function createCreateFolderForm(): Form
    {
        $factory = $this->container->get('form.factory');

        return $factory
            ->createNamedBuilder('folder', FormType::class)
            ->add('folderName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->getForm()
        ;
    }

    private function createUploadForm(): Form
    {
        $factory = $this->container->get('form.factory');

        return $factory
            ->createNamedBuilder('upload', FormType::class)
            ->add('file', FileType::class, [
                'constraints' => [
                    new FileConstraint([
                        'maxSize' => '10M',
                    ]),
                ],
            ])
            ->getForm()
        ;
    }
}
