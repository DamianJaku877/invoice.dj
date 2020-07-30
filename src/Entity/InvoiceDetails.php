<?php

namespace App\Entity;

use App\Repository\InvoiceDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceDetailsRepository::class)
 */
class InvoiceDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameProduct;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, length=20, nullable=true)
     */
    private $priceNetto;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, length=20, nullable=true)
     */
    private $priceBrutto;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, length=20, nullable=true)
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="invoice_details")
     *
     */
    private $InvoiceId;

//    /**
//     * InvoiceDetails constructor.
//     * @param $InvoiceId
//     */
//    public function __construct($InvoiceId)
//    {
//        $this->InvoiceId = new ArrayCollection();
//    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNameProduct()
    {
        return $this->nameProduct;
    }

    /**
     * @param mixed $nameProduct
     */
    public function setNameProduct($nameProduct): void
    {
        $this->nameProduct = $nameProduct;
    }



    public function getPriceNetto(): ?float
    {
        return $this->priceNetto;
    }

    public function setPriceNetto(float $priceNetto): self
    {
        $this->priceNetto = $priceNetto;

        return $this;
    }

    public function getPriceBrutto(): ?float
    {
        return $this->priceBrutto;
    }

    public function setPriceBrutto(float $priceBrutto): self
    {
        $this->priceBrutto = $priceBrutto;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->InvoiceId;
    }

    /**
     * @param mixed $InvoiceId
     */
    public function setInvoiceId($InvoiceId): void
    {
        $this->InvoiceId = $InvoiceId;
    }

//    /**
//     * @return ArrayCollection
//     */
//    public function getInvoiceId(): ArrayCollection
//    {
//        return $this->InvoiceId;
//    }
//
//    /**
//     * @param ArrayCollection $InvoiceId
//     */
//    public function setInvoiceId(ArrayCollection $InvoiceId): void
//    {
//        $this->InvoiceId = $InvoiceId;
//    }


}
