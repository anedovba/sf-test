<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

class ArticleController extends Controller
{
   
    /**
     * article list page
     * 
     * @Route("/articles", name="article_list")
     * @Template()
     */
     public function indexAction(Request $request)
    {
        // return new Response('<html><body>arcticles list</body></html>');
        // return $this->render("articles/index.html.twig");
        
        $repo=$this->get('doctrine')->getRepository("AppBundle:Article");
        dump($repo->findBySomething(5));
        $articles=$repo->findAll();
        return compact('articles');
        
    }
    
    /**
     * single article page - by id
     * 
     * @Route("/articles/{id}{sl}", name="article_page", defaults = {"sl":""}, requirements={"id": "[1-9][0-9]*", "sl":"/?"})
     * @Template()
     */
     public function showAction(Request $request, $id)
    {
        // $id=$request->get($id);
        //$id={$id}
        // return new Response("<html><body>arcticle : {$id} </body></html>");
        
        //  return $this->render("articles/show.html.twig", ["id_twig"=>$id]);
        // return ["id_twig"=>$id];
        
        $article=$this->get('doctrine')->getRepository("AppBundle:Article")->find($id);
        
        if(!$article){
            throw $this->createNotFoundException("Article not found");
        }
        
        $exporter=$this->get('text_exporter');
        $exporter->export($article);
        dump($exporter->export($article));
        
        return ['article'=>$article];
        
        
    }
    
    /**
    * articles test page
    * 
    * @Route("/articles/edit/{id}", name="article_edit", requirements={"id" : "[1-9][0-9]*"})
    * @Template()
    */
     public function editAction(Request $request)
    {
    //     // $article = new Article();
    //     // $article->setTitle("Symfony start")->setContent("Some <b>text</b> about symfony");
    //     // $em=$this->get('doctrine')->getManager();
    //     // $em->persist($article);
    //     // $em->flush();
        
    //     // dump($em);
        
    //     //  return $this->render("articles/test.html.twig", ["article"=>$article]);
        $id=$request->get('id');
        $doctrine=$this->get('doctrine');
        $article=$doctrine->getRepository("AppBundle:Article")->find($id);
        if(!$article){
            throw $this->createNotFoundException("Article not found");
        }
        $form = $this->createForm(ArticleType::class, $article);
        //save data in oject from edited form
        $form->handleRequest($request);
        
        //saving form
         if($form->isSubmitted() && $form->isValid()){
             $entityManager= $doctrine->getManager();
             $entityManager->persist($article);
             $entityManager->flush();
             
             //flash mess
             $this-> addFlash('success', "Saved");
             // redirect with parametr
            //  return $this->redirectToRoute('article_edit', ['id'=>$id]);
             return $this->redirectToRoute('article_list');
             
         }
        return ["article"=>$article, 'form' => $form->createView()];
    }
    
    /**
    * articles add page
    * 
    * @Route("/articles/add", name="article_add")
    * @Template()
    */
    public function addAction(Request $request)
    {
 
        $doctrine=$this->get('doctrine');
        $article=new Article();
        if(!$article){
            throw $this->createNotFoundException("Article not found");
        }
        $form = $this->createForm(ArticleType::class, $article);
        //save data in oject from edited form
        $form->handleRequest($request);
        
        //saving form
         if($form->isSubmitted() && $form->isValid()){
             $entityManager= $doctrine->getManager();
             $entityManager->persist($article);
             $entityManager->flush();
             
             //flash mess
             $this-> addFlash('success', "Saved");
             // redirect with parametr
            //  return $this->redirectToRoute('article_edit', ['id'=>$id]);
             return $this->redirectToRoute('article_list');
             
         }
        return ["article"=>$article, 'form' => $form->createView()];
    }
}
