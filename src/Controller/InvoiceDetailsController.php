<?php


namespace App\Controller;

use App\Entity\Invoice;
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
     * @Route("{id}/add-product/", name="product_invoice_add")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PriceCounterService $priceNettoCounter
     * @return ResponseAlias
     */
    public function addAction(Request $request, Invoice $invoice, EntityManagerInterface $entityManager, PriceCounterService $priceNettoCounter){

        $invoiceId = $request->get('id');
        $invoiceDetails = new InvoiceDetails($invoiceId);
        $productForm = $this->createForm(AddProductType::class, $invoiceDetails);

        if ($request->isMethod("post")){
            $productForm->handleRequest($request);
            $productFormDetails = $request->get('add_product');
            $productFormQuantity = $productFormDetails['quantity'];
            $productFormUnitPrice = $productFormDetails['unitPrice'];

            $nettoInvoiceDetailsPrice = $priceNettoCounter->sumInvoiceDetailsNettoPrice($productFormQuantity, $productFormUnitPrice);
            $bruttoInvoiceDetailsPrice = $priceNettoCounter->sumInvoiceDetailsBruttoPrice($productFormQuantity, $productFormUnitPrice);

            $invoiceDetails->setInvoiceId($invoiceId);
            $invoiceDetails->setPriceNetto($nettoInvoiceDetailsPrice);
            $invoiceDetails->setPriceBrutto($bruttoInvoiceDetailsPrice);
            $invoiceDetails->setVat(23);

            $entityManager->persist($invoiceDetails);
            $entityManager->flush();

            return $this->redirectToRoute('details_invoice', ['id'=>$invoiceId]);
        }

        return $this->render('invoiceDetails/product_invoice_add.html.twig',[
            "productForm" => $productForm->createView(),
        ]);
    }
}