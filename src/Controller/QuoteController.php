<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends Controller
{
    /**
     * @Route("/quotes/", name="list_quotes")
     */
    public function index()
    {
        $quotes = json_decode(file_get_contents("../var/quotes.json"));
        return $this->render('quote.html.twig', ['quotes' => $quotes]);
    }
}
