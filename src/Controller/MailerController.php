<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerController extends AbstractController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    #[Route('/email')]
    public function sendEmail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from('lemonTeam@lemon.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Merci pour votre inscription ' . $user->getFirstname() . ' ' . $user->getLastname() . '.')
            ->htmlTemplate('mailer/userTemplate.html.twig')
            ->context(['user' => $user]);

        $this->mailer->send($email);

        // ...
    }

    public function sendEmailToAdmin(User $user)
    {
        $email = (new TemplatedEmail())
            ->from('lemonTeam@lemon.com')
            ->to('admin@mail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Nouvelle inscription !')
            ->htmlTemplate('mailer/adminTemplate.html.twig')
            ->context(['user' => $user]);

        $this->mailer->send($email);

        // ...
    }
}
