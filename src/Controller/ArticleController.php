<?php

namespace App\Controller;

use App\Entity\Article;
use App\Enum\ArticleStatus;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * @Route("/realisations", name="article_list")
     */
    public function list(ArticleRepository $articleRepository): Response
    {
        /** @var Article[] $articles */
        $articles = $articleRepository->findBy([
            'status' => ArticleStatus::PUBLISHED,
        ]);

        return $this->render('article/list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article, ArticleRepository $articleRepository): Response
    {
        $relatedArticles = $articleRepository->findRelatedArticles($article->getCategory());

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
