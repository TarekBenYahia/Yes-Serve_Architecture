<?php

namespace YSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use YSBundle\Entity\Mail;
use YSBundle\Form\MailType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@YS/Default/index.html.twig');
    }
    public function contactAction(Request $request)
    {
        $mail= new Mail();



        $form = $this->createForm(MailType::class,$mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $subject= $mail->getSujet();
            $email=$mail->getEmail();
            $object=$mail->getMessage();
            $nom=$mail->getName();




            $username='huntkingdom216@gmail.com';
            $message= \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($username)
                ->setTo($email)

            ->setBody(
            $this->renderView(
            // app/Resources/views/Emails/registration.html.twig
                'email/contact_process.html.twig',
                ['name' => $nom,'object'=> $object]
            ),
            'text/html'
        );
            $this->get('mailer')->send($message);
            $this->addFlash(
                'in',
                'Envoyé Avec Succès'
            );


            return $this->redirectToRoute('ys_contact');

        }
        return $this->render('@YS/Default/contact.html.twig',array('f'=>$form->createView()));
    }
    public function partenairesAction()
    {
        return $this->render('@YS/Default/partenaires.html.twig');
    }
    public function missionAction()
    {
        return $this->render('@YS/Default/missions.html.twig');
    }
    public function projetsAction()
    {
        return $this->render('@YS/Default/projets.html.twig');
    }

}
