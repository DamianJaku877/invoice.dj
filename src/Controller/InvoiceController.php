<?php


namespace App\Controller;


use App\Entity\Invoice;
use App\Entity\InvoiceDetails;
use App\Form\InvoiceType;
use App\Repository\InvoiceDetailsRepository;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/", name="invoice_list")
     */
    public function indexAction()
    {
        $invoiceList = $this->getDoctrine()->getManager()->getRepository("App:Invoice")->findAll();

        return $this->render('Invoice/invoiceList.html.twig', [
            'invoice_list' => $invoiceList
        ]);
    }

    /**
     * @Route("/{id}", name="details_invoice")
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @param Invoice $invoice
     * @return ResponseAlias
     */
    public function detailsAction($id, EntityManagerInterface $entityManager, Invoice $invoice)
    {

        $detailsInvoice = $this->getDoctrine()->getManager()->getRepository('App:InvoiceDetails')->findBy(['InvoiceId' => $id]);
        $sumNettoPrice = $entityManager->getRepository(InvoiceDetails::class)->getTotalPrice($id);
        $sumBruttoPrice = ($sumNettoPrice * 0.23) + $sumNettoPrice;
        $taxValue = $sumNettoPrice * 0.23;

        $invoice->setSumNetto($sumNettoPrice);
        $invoice->setSumBrutto($sumBruttoPrice);
        $invoice->setTaxValue($taxValue);

        $entityManager->persist($invoice);
        $entityManager->flush();

        return $this->render('Invoice/details.html.twig', [
            "detailsInvoices" => $detailsInvoice,
            "invoiceId" => $entityManager->getRepository(Invoice::class)->find($id),
            "sumNettoPrice" => $sumNettoPrice,
            "sumBruttoPrice" => $sumBruttoPrice
        ]);
    }

    /**
     * @Route ("/invoice/{id}/pdf", name="invoice_pdf")
     * @param Invoice $invoice
     * @param InvoiceDetailsRepository $invoiceDetailsRepository
     * @param InvoiceRepository $invoiceRepository
     * @return \App\Controller\Response
     */
    public function printPdf(Invoice  $invoice, InvoiceDetailsRepository $invoiceDetailsRepository, InvoiceRepository $invoiceRepository){


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $invoicePdfId = $invoice->getId();
        $invoicePdf = $invoiceRepository->findBy(['id' => $invoicePdfId]);
        $invoiceDetailsPdf = $invoiceDetailsRepository->findBy(['InvoiceId' => $invoicePdfId] );

//        dump($invoicePdf,$invoiceDetailsPdf);exit;
        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('Invoice/pdf.html.twig', [
            'invoicepdf' =>$invoicePdf,
            'invoiceDetailsPdf' => $invoiceDetailsPdf
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream('mypdf.pdf', [
            'Attachment' => true
        ]);

    }
    /**
     * @Route("/invoice/add", name="invoice_add")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return ResponseAlias
     */
    public function addAction(Request $request, EntityManagerInterface $entityManager)
    {

        $dateToDay = new \DateTime();
        $dateToDay = $dateToDay->format('Y-m-d');
        $dateToDaySplit = explode('-', '2020-12-24');
        $implementationDate = date('Y-m-d', strtotime($dateToDay . " + 14 day"));
        $maxId = $entityManager->getRepository('App:Invoice')->findMaxValueId();
        $maxId = $maxId['idMax'] + 1;

        $invoice = new Invoice();

        $formInvoice = $this->createForm(InvoiceType::class, $invoice);

        if ($request->isMethod("post")) {

            $formInvoice->handleRequest($request);
            $invoice->setNumberInvoice("FV/" . $maxId . "/" . $dateToDaySplit[0] . "/" . $dateToDaySplit[1] . "/" . $dateToDaySplit[2]);
            $invoice->setOrderAt(new \DateTime($dateToDay));
            $invoice->setImplementationAt(new \DateTime($implementationDate));
            $invoice->setDeleted(0);
            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('invoice_list');
        }

        return $this->render('Invoice/add.html.twig', [
            'formInvoice' => $formInvoice->createView()
        ]);
    }

    /**
     * @Route("/invoice/edit/{id}", name="invoice_edit")
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return ResponseAlias
     */
    public function editAction(Request $request, $id, Invoice $invoice, EntityManagerInterface $entityManager)
    {

        $id = $entityManager->getRepository(Invoice::class)->findBy(['id' => $id]);
        $formEditInvoice = $this->createForm(InvoiceType::class, $id[0]);

        if ($request->isMethod('post')) {
            $formEditInvoice->handleRequest($request);
            $entityManager->persist($invoice);
            $entityManager->flush();

            $this->addFlash("message", "Edit Success!!");

        }

        return $this->render('Invoice/edit.html.twig', ["formEditInvoice" => $formEditInvoice->createView()]);
    }

    /**
     * @Route("/invoice/{id}", name="invoice_delete")
     * @param Invoice $invoice
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Invoice $invoice, EntityManagerInterface $entityManager)
    {

        $invoice->setDeleted(1);
        $entityManager->persist($invoice);
        $entityManager->flush();

        return $this->redirectToRoute('invoice_list');
    }

}