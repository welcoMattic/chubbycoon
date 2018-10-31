<?php

namespace App\Controller;

use App\Entity\Article;
use App\Enum\ArticleStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findBy([
            'status' => ArticleStatus::PUBLISHED,
        ], null, 3);

        return $this->render('home.html.twig', [
            'articles' => $articles
        ]);
    }
}
