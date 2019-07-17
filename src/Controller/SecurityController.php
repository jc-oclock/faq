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
    public function registration(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->encodePassword(
                 $user, #detecte le type d'encodage
                 $user->getPassword() #le mot de passse a encoder
            );
            //j'ecrase le mot de passe en clair par celui que je vient d'encoder
            $user->setPassword($encodedPassword);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/signin.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
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
     * @Route("/admin/login", name="app_admin")
     */
    public function admin()
    {
        return $this->render('security/admin.html.twig');
        
    }

     
}
