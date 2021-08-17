<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class RootController extends BaseController
{
    private $entityManager;

    public function __construct(TranslatorInterface $translator,EntityManagerInterface $entityManager)
    {
        parent::__construct($translator,$entityManager);
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->redirectToRoute('detailsCart');
    }
}
