<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Event\QuoteEvent;
use App\Form\QuoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends Controller
{

    /**
     * @Route("/quotes/", name="list_quotes")
     */
    public function index(Request $rq, EventDispatcherInterface $dispatcher)
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
            $event = new QuoteEvent($quote);
            $dispatcher->dispatch('quote.create', $event);
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
    public function delete($id, EventDispatcherInterface $dispatcher)
    {
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);
        $event = new QuoteEvent($q);
        $dispatcher->dispatch('quote.delete', $event);
        $em->remove($q);
        $em->flush();
        return $this->redirectToRoute('list_quotes');
    }

    /**
     * @Route("/modifyQuote/{id}", name="modify_quotes")
     * @IsGranted("ROLE_USER")
     */
    public function modify(Request $rq, $id, EventDispatcherInterface $dispatcher)
    {
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $q = $quoteReposit->find($id);

        $formAdd = $this->createForm(QuoteType::class, $q);
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $q = $formAdd->getData();
            //dispatch event
            $event = new QuoteEvent($q);
            $dispatcher->dispatch('quote.edit', $event);
            $em->persist($q);
            $em->flush();
            return $this->redirectToRoute('list_quotes');
        }
        return $this->render('modify_quote.html.twig', ['id' => $id, 'q' => $q, 'formAdd' => $formAdd->createView()]);
    }
}
