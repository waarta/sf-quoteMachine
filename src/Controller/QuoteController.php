<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $quotes = $quoteReposit->findAll();
        $formAdd = $this->createForm(QuoteType::class, $quote);
        $search = $rq->query->get('search');

        //recherche
        if ($search != "") {
            $query = $quoteReposit->createQueryBuilder('q')
                ->where('q.content like :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('q.content', 'ASC')
                ->getQuery();
            $quotes = $query->getResult();
        }
        //ajout
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $quote = $formAdd->getData();
            $quote->setOwner($this->getUser());
            $em->persist($quote);
            $em->flush();
            return $this->redirectToRoute('list_quotes');
        }
        return $this->render('quote.html.twig',
            ['quotes' => $quotes,
                'formAdd' => $formAdd->createView()]);
    }

    /**
     * @Route("/deleteQuote/{id}", name="delete_quotes")
     * @IsGranted("ROLE_USER")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);
        $em->remove($q);
        $em->flush();
        return $this->redirectToRoute('list_quotes');
    }

    /**
     * @Route("/modifyQuote/{id}", name="modify_quotes")
     * @IsGranted("ROLE_USER")
     */
    public function modify(Request $rq, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);

        $formAdd = $this->createForm(QuoteType::class, $q);
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $q = $formAdd->getData();
            $em->persist($q);
            $em->flush();
            return $this->redirectToRoute('list_quotes');
        }
        return $this->render('modify_quote.html.twig', ['id' => $id, 'q' => $q, 'formAdd' => $formAdd->createView()]);
    }
}
