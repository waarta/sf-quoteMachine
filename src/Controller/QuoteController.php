<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends Controller
{
    /**
     * @Route("/quotes/", name="list_quotes")
     */
    public function index(Request $rq)
    {
        $search = $rq->query->get('search');
        $quotes = json_decode(file_get_contents("../var/quotes.json"), true);

        if ($search != "") {
            $tab = [];
            foreach ($quotes as $q) {
                if (strpos($q['quote'], $search) !== false) {
                    array_push($tab, $q);
                }
            }
            $quotes = $tab;
        }
        return $this->render('quote.html.twig', ['quotes' => $quotes]);
    }
}
