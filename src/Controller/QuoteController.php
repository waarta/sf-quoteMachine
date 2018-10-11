<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use App\Repository\QuoteRepository;
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
        $quote = new Quote();
        $quoteReposit = new QuoteRepository("../var/quotes.json");
        $formAdd = $this->createForm(QuoteType::class, $quote);
        $quotes = $quoteReposit->findAll();
        $search = $rq->query->get('search');

        //recherche
        if ($search != "") {
            $tab = [];
            foreach ($quotes as $q) {
                if (strpos($q->getQuote(), $search) !== false) {
                    array_push($tab, $q);
                }
            }
            $quotes = $tab;
        }
        //ajout
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $quote = $formAdd->getData();
            $quoteReposit->persist($quote);
            $quotes = $quoteReposit->findAll();
            return $this->redirectToRoute('list_quotes');
        }
        return $this->render('quote.html.twig',
            ['quotes' => $quotes,
                'formAdd' => $formAdd->createView()]);
    }

    /**
     * @Route("/delete/{id}", name="delete_quotes")
     */
    public function delete($id)
    {
        $quoteReposit = new QuoteRepository("../var/quotes.json");

        $q = $quoteReposit->find($id);
        $quoteReposit->delete($q);
        return $this->redirectToRoute('list_quotes');
    }

    /**
     * @Route("/modify/{id}", name="modify_quotes")
     */
    public function modify($id)
    {
        $quoteReposit = new QuoteRepository("../var/quotes.json");
        $q = $quoteReposit->find($id);
        return $this->render('modify.html.twig', ['id' => $id, 'q' => $q]);
    }
}
