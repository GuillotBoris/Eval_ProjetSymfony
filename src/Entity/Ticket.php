<?php
// Note pour Eval 
// ===============================
// 1. Complement de getter et setter avec
//  déclaration des variables correspondant au champs du formulaire 
//  Form\TicketType.php
//
// 2. Ajout des champs complementaires pour l'enregistrement 
// 3. Ajout de contriante pour la sasie
namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
// Ajout de contrainte 
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 250)]
    private ?string $email = null;

    #[ORM\Column(type: 'text')]
    #[Assert\Length(min: 20, max: 250)]
    #[Assert\NotBlank]  
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $categorie = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateOuverture;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dateCloture = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'string', length: 250)]
    private ?string $responsable = null;

    public function __construct()
    {
        //Dans ce constructeur on initailise la date à maintenant et elle ne sera jamais modifie
        $this->dateOuverture = new \DateTime(); 
        //Valeur par default 
        $this->statut = 'Nouveau';
        $this->responsable = 'Non assigné';
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(\DateTimeInterface $dateOuverture): self
    {
        $this->dateOuverture = $dateOuverture;
        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(?\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        $this->gererDateCloture(); // On verifie si on doit mettre a jour la date de cloture 
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
    // Permet d'appeler automatiquement gererDateCloture on l'appel a chaque changement de status
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function gererDateCloture(): void
    {
        // Si le ticket passe au statut "Fermé" et n'a pas encore de date de clôture 
        if ($this->statut === 'Fermé' && $this->dateCloture === null) {
            $this->dateCloture = new \DateTime();
        }

        // Si le ticket est réouvert (statut ≠ "Fermé"), on retire la date de clôture
        if ($this->statut !== 'Fermé' ) {
            $this->dateCloture = null;
        }
    }
}