<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Article;

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
        return ["id_twig"=>$id];
        
    }
    
    /**
     * article test page
     * 
     * @Route("/articles-test", name="article_test")
     * @Template()
     */
     public function testAction()
    {
        $article = new Article();
        $article->setTitle("Symfony start")->setContent("Some <b>text</b> about symfony");
        $em=$this->get('doctrine')->getManager();
        $em->persist($article);
        $em->flush();
        
        dump($em);
        
        //  return $this->render("articles/test.html.twig", ["article"=>$article]);
        return ["article"=>$article];
    }
}
