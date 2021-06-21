<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormBusinessType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription2", name="app_register_buisness")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $formUser = $this->createForm(RegistrationFormType::class, $user);
        $formUser->handleRequest($request);

        $formBusiness = $this->createForm(RegistrationFormBusinessType::class, $user);
        $formBusiness->handleRequest($request);

        if ($formBusiness->isSubmitted() && $formBusiness->isValid()) {
            // encode the plain password
            $user->setRoles(['ROLE_BUSINESS']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $formBusiness->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $formUser->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $formUser->createView(),
            'businessForm' => $formBusiness->createView(),
        ]);
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function registerBusiness(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormBusinessType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setRoles(['ROLE_BUSINESS']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/business_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
