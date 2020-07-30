<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $numberInvoice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $nip;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $orderAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $implementationAt;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, length=20, nullable=true)
     */
    private $sumNetto;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2, length=20, nullable=true)
     */
    private $sumBrutto;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    private $deleted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\InvoiceDetails", inversedBy="invoices")
     * @ORM\JoinColumn(name="invoices_dettails_id", referencedColumnName="id")
     */
    private $InvoiceDetailsId;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumberInvoice()
    {
        return $this->numberInvoice;
    }

    /**
     * @param mixed $numberInvoice
     */
    public function setNumberInvoice($numberInvoice): void
    {
        $this->numberInvoice = $numberInvoice;
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurName()
    {
        return $this->surName;
    }

    /**
     * @param mixed $surName
     */
    public function setSurName($surName): void
    {
        $this->surName = $surName;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName): void
    {
        $this->companyName = $companyName;
    }


    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * @param mixed $nip
     */
    public function setNip($nip): void
    {
        $this->nip = $nip;
    }

    public function getOrderAt(): ?\DateTimeInterface
    {
        return $this->orderAt;
    }

    public function setOrderAt(\DateTimeInterface $orderAt): self
    {
        $this->orderAt = $orderAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImplementationAt()
    {
        return $this->implementationAt;
    }

    /**
     * @param mixed $implementationAt
     */
    public function setImplementationAt($implementationAt): void
    {
        $this->implementationAt = $implementationAt;
    }



    public function getSumNetto(): ?float
    {
        return $this->sumNetto;
    }

    public function setSumNetto(float $sumNetto): self
    {
        $this->sumNetto = $sumNetto;

        return $this;
    }

    public function getSumBrutto(): ?float
    {
        return $this->sumBrutto;
    }

    public function setSumBrutto(float $sumBrutto): self
    {
        $this->sumBrutto = $sumBrutto;

        return $this;
    }

    public function getTaxValue(): ?float
    {
        return $this->taxValue;
    }

    public function setTaxValue(float $taxValue): self
    {
        $this->taxValue = $taxValue;

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

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getInvoiceDetailsId()
    {
        return $this->InvoiceDetailsId;
    }

    /**
     * @param mixed $InvoiceDetailsId
     */
    public function setInvoiceDetailsId($InvoiceDetailsId): void
    {
        $this->InvoiceDetailsId = $InvoiceDetailsId;
    }

}
