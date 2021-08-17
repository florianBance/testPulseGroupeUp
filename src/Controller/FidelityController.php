<?php


namespace App\Controller;


use App\Entity\CartDetails;
use App\Entity\Contact;
use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Repository\ContactRepository;
use Symfony\Component\Routing\Annotation\Route;

class FidelityController extends BaseController
{
    const PERIOD=[
        1=>["start"=>"01/01/2021","end"=>"30/04/2021"],
        2=>["start"=>"01/05/2021","end"=>"31/08/2021"],
        3=>["start"=>"01/10/2021","end"=>"31/12/2021"]
    ];
    const POINTVALUE=0.001;
    const POINTFORPRODUCT1=5;
    const POINTFORPRODUCT2=5;
    const POINTFORPRODUCT3=15;
    const POINTFORPRODUCT4=35;

    /**
     * @Route( "/detailsCart", name="detailsCart")
     */
    function getContactDetails(ContactRepository $contactRepository){
        //récupération du contact 123456789
        $contacts=$contactRepository->findBy(['id'=>123456789]);
        //récupération de tout les contacts
        //$contacts=$contactRepository->findAll();
        dump($contacts);
        $detailsContact=[];
        if($contacts){
            foreach ($contacts as $contact){
                //pour chaque contact je recherche les carts pour chaques période
                $detailsContact[$contact->getId()]= self::getCartsForPeriod($contact);
            }
        }
        return $this->render('details/details.html.twig', [
            'detailsContacts' => $detailsContact,
        ]);
    }

    function getCartsForPeriod(Contact $contact){
        $cartRepository=$this->getDoctrine()->getRepository(Cart::class);
        foreach(self::PERIOD as $key=>$item){
            //recherche des carts pour le contact et les dates données.
            $carts=$cartRepository->findCartForGivenDateAndContact($contact,$item['start'],$item['end']);
            if($carts){
                //attribution des carts par rapport aux période.
                $cartPerPeriod[$key]=$carts;
            }
        }
        //Calcul des points par cart et par période
        $totPointPerPeriod=self::getTotPointsPerPeriod($cartPerPeriod);
        return $totPointPerPeriod;
    }

    function getTotPointsPerPeriod(array $cartPerPeriod){
        $cartDetailsRepository=$this->getDoctrine()->getRepository(CartDetails::class);
        foreach ($cartPerPeriod as $keyPeriod => $period){
            $totPeriod=0;
            foreach ($period as $cart){
                $totCart=0;
                //récuperation des articles de chaque cart.
                $cartDetails=$cartDetailsRepository->findBy(['idCart'=>$cart]);
                foreach ($cartDetails as $cartDetail){
                    $points=0;
                    //calcul selon l'article.
                    switch ($cartDetail->getProduct()){
                        case 1 :
                            $points=self::getPointForProduct1($cartDetail);
                            break;
                        case 2 :
                            $points=self::getPointForProduct2($cartDetails,$cartDetail);
                            break;
                        case 3 :
                            $points=self::getPointForProduct3($cartDetail);
                            break;
                        case 4 :
                            $points=self::getPointForProduct4($cartDetail);
                            break;
                    }
                    $totCart=$totCart+$points;
                }
                $totPeriod=$totPeriod+$totCart;
            }
            $totPeriodArray[$keyPeriod]=$totPeriod;
        }
        return $totPeriodArray;
    }

    private function getPointForProduct1(CartDetails $cartDetail){
        $points=0;
        $points=$cartDetail->getQuantity()*self::POINTFORPRODUCT1;
        return $points;
    }

    private function getPointForProduct2(array $cartDetails,CartDetails $cartDetail){
        $points=0;
        /*$cartDetailsRepository=$this->getDoctrine()->getRepository(CartDetails::class);
        $product1Present=$cartDetailsRepository->findOneBy(['idCart'=>$cartDetail->getIdCart(),'product'=>1]);*/
        /*if($product1Present && $product1Present->getQuantity()>=1){

        }*/
        //recherche dans les autres produits et test si le produit 1 est présent et supérieur à 1.
        foreach ($cartDetails as $cartDetailForProduct2){
            if($cartDetailForProduct2->getProduct()==1 && $cartDetailForProduct2->getQuantity()>=1){
                $points=$cartDetail->getQuantity()*self::POINTFORPRODUCT2;
            }
        }

        return $points;
    }

    private function getPointForProduct3(CartDetails $cartDetail){
        $points=0;
        if($cartDetail->getQuantity()>2){
            $points=ceil($cartDetail->getQuantity()/2)*self::POINTFORPRODUCT3;
        }
        return $points;
    }

    private function getPointForProduct4(CartDetails $cartDetail){
        $points=0;
        $points=$cartDetail->getQuantity()*self::POINTFORPRODUCT4;
        return $points;
    }

}