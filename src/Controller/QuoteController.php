<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends Controller
{
    public function create()
    {
        $em = $this->getDoctrine()->getManager();
        $quote1 = new Quote();
        $quote1->setContent("Sire, Sire !!! On en a gros !");
        $quote1->setMeta("Perceval, Livre II, Les Exploit\u00e9s");

        $quote2 = new Quote();
        $quote2->setContent("[Dame S\u00e9li : Les tartes, la p\u00eache, tout \u00e7a c'est du patrimoine] (Arthur, montrant la tarte) C'est du patrimoine \u00e7a ?\n");
        $quote2->setMeta("Arthur, Livre I, La tarte aux myrtilles");

        $em->persist($quote1);
        $em->persist($quote2);
        $em->flush();
    }

    /**
     * @Route("/quotes/", name="list_quotes")
     */
    public function index(Request $rq)
    {
        $quote = new Quote();
        $em = $this->getDoctrine()->getManager();
        //$quoteReposit = new QuoteRepository("../var/quotes.json");
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $quotes = $quoteReposit->findAll();
        $formAdd = $this->createForm(QuoteType::class, $quote);
        $search = $rq->query->get('search');

        //recherche
        if ($search != "") {
            /*$tab = [];
            foreach ($quotes as $q) {
            if (strpos($q->getQuote(), $search) !== false) {
            array_push($tab, $q);
            }
            }
            $quotes = $tab;*/

            $query = $quoteReposit->createQueryBuilder('q')
                ->where('q.content like :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('q.content', 'ASC')
                ->getQuery();

            $quotes = $query->getResult();

            // $quotes = $quoteReposit->findByContent($search);
        }
        //ajout
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $quote = $formAdd->getData();
            $em->persist($quote);
            $em->flush();
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
        //$quoteReposit = new QuoteRepository("../var/quotes.json");
        //$quoteReposit->delete($q);
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);
        $em->remove($q);
        $em->flush();
        return $this->redirectToRoute('list_quotes');

    }

    /**
     * @Route("/modify/{id}", name="modify_quotes")
     */
    public function modify(Request $rq, $id)
    {
        //$quoteReposit = new QuoteRepository("../var/quotes.json");
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);

        $formAdd = $this->createForm(QuoteType::class, $q);
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $q = $formAdd->getData();
            $em->persist($q);
            $em->flush();
            //$quotes = $quoteReposit->findAll();
            return $this->redirectToRoute('list_quotes');
        }
        return $this->render('modify.html.twig', ['id' => $id, 'q' => $q, 'formAdd' => $formAdd->createView()]);
    }
}
