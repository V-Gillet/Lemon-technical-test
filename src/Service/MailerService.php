<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerService extends AbstractController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(User $user): void
    {
        $email = (new TemplatedEmail())
            ->to($user->getEmail())
            ->subject('Merci pour votre inscription ' . $user->getFirstname() . ' ' . $user->getLastname() . '.')
            ->htmlTemplate('mailer/userTemplate.html.twig')
            ->context(['user' => $user]);

        $this->mailer->send($email);
    }

    public function sendEmailToAdmin(User $user): void
    {
        $email = (new TemplatedEmail())
            //If it was possible to have multiple admins, an other system should be used
            ->to('admin@mail.com')
            ->subject('Nouvelle inscription !')
            ->htmlTemplate('mailer/adminTemplate.html.twig')
            ->context(['user' => $user]);

        $this->mailer->send($email);
    }
}
