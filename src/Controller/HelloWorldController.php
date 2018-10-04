<?php

namespace App\Controller;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller
{
    /**
     * @Route("/hello/{name}", name="hello_name", requirements={"name": "[a-zA-Z]+"})
     */
    public function index($name = "World !")
    {

        //return new Response('<html><body>Hello ' . $name . '</body></html>');
        return $this->render('helloWorld.html.twig', ['name' => $name]);
    }
}
