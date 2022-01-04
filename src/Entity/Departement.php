<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("departement:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("departement:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("departement:read")
     */
    private $responsable;

//    /**
//     * @ORM\OneToMany(targetEntity=ContactRequest::class, mappedBy="departement")
//     */
//    private $contactRequests;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="departement")
     *
     */
    private $messages;

    public function __construct()
    {
        // $this->contactRequests = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

//    /**
//     * @return Collection|ContactRequest[]
//     */
//    public function getContactRequests(): Collection
//    {
//        return $this->contactRequests;
//    }
//
//    public function addContactRequest(ContactRequest $contactRequest): self
//    {
//        if (!$this->contactRequests->contains($contactRequest)) {
//            $this->contactRequests[] = $contactRequest;
//            $contactRequest->setDepartement($this);
//        }
//
//        return $this;
//    }
//
//    public function removeContactRequest(ContactRequest $contactRequest): self
//    {
//        if ($this->contactRequests->removeElement($contactRequest)) {
//            // set the owning side to null (unless already changed)
//            if ($contactRequest->getDepartement() === $this) {
//                $contactRequest->setDepartement(null);
//            }
//        }
//
//        return $this;
//    }


    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setDepartement($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDepartement() === $this) {
                $message->setDepartement(null);
            }
        }

        return $this;
    }
}
