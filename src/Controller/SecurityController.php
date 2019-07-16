<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\RegistrationTypeAdmin;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
   
   /**
     * @Route("/signin", name="app_signin")
     */
    public function registration(Request $request, ObjectManager $manager)
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

           // $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword();

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }
       
        return $this->render('security/signin.html.twig', ['form' => $form->createView()
        ]);
    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
 
    }

     /**
     * @Route("/admin", name="app_admin")
     */
    public function admin(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();
        $form = $this->createForm(RegistrationTypeAdmin::class, $user);
 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('faq_index');
        }
       
        return $this->render('security/admin.html.twig', ['form' => $form->createView()
        ]);
    }

     
}
