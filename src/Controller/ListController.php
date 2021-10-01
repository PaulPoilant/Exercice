<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(): Response
    {

        $json = file_get_contents('https://jsonplaceholder.typicode.com/users/');
        $obj = json_decode($json);

        return $this->render('list/index.html.twig', [
            'name' => $obj,
        ]);
    }
}
