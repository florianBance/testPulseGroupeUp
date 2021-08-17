<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Form\Model\ContactFormModel;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 */
class ContactController extends BaseController
{
    /**
     * @Route( "contact/new", name="contact_new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ContactFormType $contact */
            $contact = $form->getData();


            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', $this->trans("contact_created"));

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/new.html.twig', [
            'contactForm' => $form->createView(),
        ]);

    }



    /**
     * @Route("/contact", name="contact_list")
     */
    public function list(ContactRepository $contactRepo)
    {

        $contacts = $contactRepo->findAll();

        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @route("/contact/{id}/edit",name="contact_edit")
     */
    public function contactEdit(Contact $contact, EntityManagerInterface $em,Request $request)
    {
        $form = $this->createForm(ContactFormType::class, $contact);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

                /** @var ContactFormType $contactType */
                $contactType = $form->getData();

                $em->persist($contactType);
                $em->flush();

            $this->addFlash('success', $this->trans("contact_updated_success_message"));

            return $this->redirectToRoute('contact_list');

            }

            return $this->render('contact/edit.html.twig',[
                'contactForm' => $form->createView(),
                'contact'=>$contact
            ]);
    }

    /**
     * @route("/contact/{id}/delete",name="contact_delete")
     */
    public function contactDelete(Contact $contact, EntityManagerInterface $em)
    {

        $em->remove($contact);
        $em->flush();

        $this->addFlash('success', $this->trans("success_message_contact_deleted"));

        return $this->redirectToRoute('contact_list');
    }
}