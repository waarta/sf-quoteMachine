<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Quote;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category/", name="list_catg")
     */
    public function index(Request $rq)
    {
        $catg = new Category();
        $em = $this->getDoctrine()->getManager();
        $catgReposit = $this->getDoctrine()->getRepository(Category::class);
        $categories = $catgReposit->findAll();
        $formAdd = $this->createForm(CategoryType::class, $catg);

        //ajout
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $catg = $formAdd->getData();
            $em->persist($catg);
            $em->flush();
            return $this->redirectToRoute('list_catg');
        }
        return $this->render('category.html.twig',
            ['categories' => $categories,
                'formAdd' => $formAdd->createView()]);
    }

    /**
     * @Route("/deleteCategory/{id}", name="delete_catg")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $catgReposit = $this->getDoctrine()->getRepository(Category::class);
        $catg = $catgReposit->find($id);

        foreach ($catg->getQuotes() as $q) {
            $q->setCategory(null);
            $em->persist($q);
            $em->flush();
        }

        $em->remove($catg);
        $em->flush();
        return $this->redirectToRoute('list_catg');
    }

    /**
     * @Route("/modifyCategory/{slug}", name="modify_catg")
     * @IsGranted("ROLE_ADMIN")
     */
    public function modify(Request $rq, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $catgReposit = $this->getDoctrine()->getRepository(Category::class);
        $catg = $catgReposit->findOneBy(['slug' => $slug]);

        $formAdd = $this->createForm(CategoryType::class, $catg);
        $formAdd->handleRequest($rq);
        if ($formAdd->isSubmitted() && $formAdd->isValid()) {
            $catg = $formAdd->getData();
            $em->persist($catg);
            $em->flush();
            return $this->redirectToRoute('list_catg');
        }
        return $this->render('modify_catg.html.twig', ['slug' => $slug, 'c' => $catg, 'formAdd' => $formAdd->createView()]);
    }

    /**
     * @Route("/showQuotes/{slug}", name="showQuotes_catg")
     */
    public function showQuotes(Request $rq, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $catgReposit = $this->getDoctrine()->getRepository(Category::class);
        $quoteReposit = $this->getDoctrine()->getRepository(Quote::class);
        $catg = $catgReposit->findOneBy(['slug' => $slug]);
        $id = $catg->getId();

        $quotes = $catg->getQuotes();

        //recherche
        $search = $rq->query->get('search');

        if ($search != "") {
            $query = $quoteReposit->createQueryBuilder('q')
                ->where('q.content like :search')
                ->andWhere('q.category = :id')
                ->setParameter('search', '%' . $search . '%')
                ->setParameter('id', $id)
                ->orderBy('q.content', 'ASC')
                ->getQuery();
            $quotes = $query->getResult();
        }

        return $this->render('quote.html.twig',
            ['quotes' => $quotes]);

    }
}
