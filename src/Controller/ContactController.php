<?php

namespace App\Controller;

use App\Type\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = (new \Swift_Message($data['subject']))
                ->setFrom($data['email'])
                ->setTo('mathieu.santostefano@gmail.com')
                ->setSubject($data['subject'])
                ->setBody($data['message']);

            $mailer->send($message);
            $this->addFlash('success', 'Votre message a été envoyé !');

            return $this->render('contact/index.html.twig');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
