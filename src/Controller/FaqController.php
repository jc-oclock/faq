<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Answer;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class FaqController extends AbstractController
{   
    
    /**
     * @Route("/", name="faq_index", methods={"GET","POST"})
     */
    
    
     public function index(Request $request)
    {   

       
         $repository = $this->getDoctrine()->getRepository(Question::class);
         
         /*
          Note: recuperer un parametre en 
          POST : $request->request->get('moninput');
          GET : $request->query->get('title');
         */
         $searchTitle = $request->request->get('title'); //par defaut si n'existe pas renvoit du null
         if($searchTitle){
            $questions = $repository->findByTitle($searchTitle);
 
         } else {
             //Query builder
            $questions = $repository->findAllQueryBuilderOrderedByName();
         }
         $lastQuestions = $repository->lastRelease(10);
        return $this->render('faq/index.html.twig',[
            'questions' => $questions,
            'last_questions' => $lastQuestions,
            'searchTitle' => $searchTitle
        ]);
    }
    /**
     * @Route("/question/{id}", name="faq_show", methods={"GET"},  requirements={"id"="\d+"})
     * 
     * 
     * 
     */
    public function show(Question $question, Answer $answer)
    {   
        
        return $this->render('faq/show.html.twig',[
            'question' => $question,
            'answer' => $answer
            
        ]);
    }
}
