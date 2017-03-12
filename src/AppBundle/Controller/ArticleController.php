<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
   
    /**
     * article list page
     * 
     * @Route("/articles{sl}", name="article_list", requirements={"sl":"/?"})
     */
     public function indexAction(Request $request)
    {
        // return new Response('<html><body>arcticles list</body></html>');
        return $this->render("articles/index.html.twig");
        
    }
    
    /**
     * single article page - by id
     * 
     * @Route("/articles/{id}{sl}", name="article_page", requirements={"id": "[1-9][0-9]*", "sl":"/?"})
     */
     public function showAction(Request $request, $id)
    {
        // $id=$request->get($id);
        //$id={$id}
        // return new Response("<html><body>arcticle : {$id} </body></html>");
        
         return $this->render("articles/show.html.twig", ["id_twig"=>$id]);
        
    }
}
