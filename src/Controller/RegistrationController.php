<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\GeoPluginAPI;
use App\Form\RegistrationFormType;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, GeoPluginAPI $geoPluginAPI, MailerService $mailer): Response
    {
        //A better option would be to put "$request->getClientIp()" but it gives 127.0.0.1 IP in dev environement
        $geolocation = $geoPluginAPI->geolocate(file_get_contents('https://api.ipify.org/'));

        $user = new User();
        //Set the country of the user and act as an autocomplete of its location
        $user->setCountry($geolocation['geoplugin_countryCode']);

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $mailer->sendEmail($user);
            $mailer->sendEmailToAdmin($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
