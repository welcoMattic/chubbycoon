<?php

namespace App\Controller;

use App\Entity\Article;
use App\Enum\ArticleStatus;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findBy([
            'status' => ArticleStatus::PUBLISHED,
        ]);

        return $this->render('home.html.twig', [
            'articles' => $articles
        ]);
    }
}
