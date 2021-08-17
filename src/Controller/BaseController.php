<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;


abstract class BaseController extends AbstractController
{
    private $translator;
    private $entityManager;

    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager)
    {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
    }

    protected function trans($id, array $parameters = [], $domain = null, $locale = null): ?string
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }

}