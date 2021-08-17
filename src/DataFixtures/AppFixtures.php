<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\CartDetails;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $contactRepo=$manager->getRepository(Contact::class);
        // $product = new Product();
        // $manager->persist($product);
        $csv = fopen(dirname(__FILE__).'/ressources/resultats_users.csv', 'r');

        $i = 0;

        while (($line = fgetcsv($csv,1000,";")) !== FALSE) {
            $i++;
            var_dump($line);
            //exit;
            if(!($contactRepo->find($line[0]))){
                $contact=new Contact();
                $contact->setId((int)$line[0]);
                $contact->setFirstName("Contact".$i);
                $contact->setLastName("Contact".$i);
                $contact->setEmail("Contact".$i."@gmail.fr");

                $manager->persist($contact);
            }

            $contact=$contactRepo->find($line[0]);

            $cart=new Cart();
            $cart->setId($i);
            $cart->setContactId($contact);
            $cart->setDate(\DateTime::CreateFromFormat("d/m/Y", $line[5]));

            $manager->persist($cart);

            for($j=1;$j<5;$j++){
                if($line[$j]!==0){
                    $cartDetails=new CartDetails();
                    $cartDetails->setIdCart($cart);
                    $cartDetails->setProduct($j);
                    $cartDetails->setQuantity($line[$j]);
                }
                $manager->persist($cartDetails);
            }


        }

        $manager->flush();
    }
}
