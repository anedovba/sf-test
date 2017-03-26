<?php
namespace AppBundle\Service;
use AppBundle\Entity\Article;
use Psr\Log\LoggerInterface;

class TextExporter
{
    private $logger;
    private $exportDir;
    
    public function __construct(LoggerInterface $logger, $exportDir){
        $this->exportDir=$exportDir;
        $this->logger=$logger;
        //если каталога нет - создать его
        if(!file_exists($this->exportDir)){
            mkdir($this->exportDir, 0755);
        }
    }
    public function export(Article $article){
        file_put_contents($this->exportDir.'/'.$article->getTitle().'.txt', $article->getContent());
        $this->logger->info("Article exported");
    }
}