<?php

namespace App\Controller\Backend;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("backend/answer", name="backend_")
 */
class AnswerController extends AbstractController
{    
    
    /**
    * @Route("/question/{id}", name="answer_index", methods={"GET"})
    */

   public function index(Question $question): Response
   {
       
       return $this->render('backend/answer/new.html.twig', [
           'question' => $question,
       ]);

    
   }
   
    /**
     * @Route("/new/question/{id}", name="answer_new", methods={"GET","POST"})
     */
    public function new(Request $request, Question $question): Response
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $answer->setQuestion($question);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Enregistrement effectué'
            );
            //attention , ici cette a changé car elle prend l'id en parametre , je l'ajoute aussi a la redirection
            return $this->redirectToRoute('backend_answer_index', ['id' => $question->getId()]);
        }
        return $this->render('backend/answer/new.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
            'question' => $question
        ]);
    }
    /**
     * @Route("/{id}", name="answer_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Answer $answer): Response
    {
        return $this->render('backend/answer/show.html.twig', [
            'answer' => $answer,
        ]);
    }
    
}