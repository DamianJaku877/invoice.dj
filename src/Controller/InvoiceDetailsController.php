<?php


namespace App\Controller;


use App\Entity\InvoiceDetails;
use App\Form\AddProductType;
use App\Service\PriceCounterService;
use App\Service\PriceNettoCounter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\Routing\Annotation\Route;


class InvoiceDetailsController extends AbstractController
{


    /**
     * @Route("/details/add-product/{id}", name="product_invoice_add")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return ResponseAlias
     */
    public function addAction(Request $request, EntityManagerInterface $entityManager, PriceCounterService $priceNettoCounter){

        $invoiceId = $request->get('id');
        $product = new InvoiceDetails($invoiceId);
        $productForm = $this->createForm(AddProductType::class, $product);


        if ($request->isMethod("post")){

            $productForm->handleRequest($request);
            $product->setInvoiceId($invoiceId);
            dump($request->get('add_product'));exit;
            $nettoPrice = $priceNettoCounter->countNettoPrice();
            dump($nettoPrice);exit;
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('invoice_list');
        }

        return $this->render('invoiceDetails/product_invoice_add.html.twig',[
            "productForm" => $productForm->createView()
        ]);
    }
}