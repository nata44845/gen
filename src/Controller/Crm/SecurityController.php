<?php

namespace App\Controller\Crm;

use App\Form\Type\LoginType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function login(Request $request, AuthenticationUtils $authUtils)
    {
//        $authUtils = $this->get('security.authentication_utils');
        // last username entered by the user
        $lastEmail = $authUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);
        $form->setData(['email' => $lastEmail]);
        $form->handleRequest($request);

        $register = $request->get('register');
        if (!$register) {
            $register = false;
        }

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        return $this->render('Security/login.html.twig', [
            'last_username' => $lastEmail,
            'error' => $error,
            'flagRegister' => $register,
            'form' => $form->createView()
        ]);
    }


}
