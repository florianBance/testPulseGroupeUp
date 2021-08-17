<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=CartDetails::class, mappedBy="idCart", orphanRemoval=true)
     */
    private $cartDetails;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="carts")
     */
    private $contactId;

    public function __construct()
    {
        $this->cartDetails = new ArrayCollection();
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|CartDetails[]
     */
    public function getCartDetails(): Collection
    {
        return $this->cartDetails;
    }

    public function addCartDetail(CartDetails $cartDetail): self
    {
        if (!$this->cartDetails->contains($cartDetail)) {
            $this->cartDetails[] = $cartDetail;
            $cartDetail->setIdCart($this);
        }

        return $this;
    }

    public function removeCartDetail(CartDetails $cartDetail): self
    {
        if ($this->cartDetails->removeElement($cartDetail)) {
            // set the owning side to null (unless already changed)
            if ($cartDetail->getIdCart() === $this) {
                $cartDetail->setIdCart(null);
            }
        }

        return $this;
    }

    public function getContactId(): ?Contact
    {
        return $this->contactId;
    }

    public function setContactId(?Contact $contactId): self
    {
        $this->contactId = $contactId;

        return $this;
    }
}
