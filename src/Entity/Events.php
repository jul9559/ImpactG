<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 * @UniqueEntity(
 * fields={"name"},
 *     errorPath="name",
 *     message="Ce nom est déjà utilisé !"
 * )
 */
class Events
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      max = 100,
     *      minMessage = "Le nom de l'évènement doit contenir {{ limit }} minimum !",
     *      maxMessage = "Le nom de l'évènement ne peut dépasser {{ limit }} charactères !")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteLink;

    /**
     * @ORM\Column(type="datetime")
     */
    private $launchDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $stopDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 10,
     *      max = 250,
     *      minMessage = "La description courte doit contenir {{ limit }} minimum !",
     *      maxMessage = "La description courte ne peut dépasser {{ limit }} charactères !")
     */
    private $shortDesc;


    /**
     * @ORM\Column(type="text")
     */
    private $longDesc;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=AvailableGames::class, inversedBy="events")
     */
    private $availableGames;

    /**
     * @ORM\OneToMany(targetEntity=EventReviews::class, mappedBy="events")
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity=EventCategory::class, inversedBy="events")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ticketNumber;

    /**
     * @ORM\OneToMany(targetEntity=SocialLinks::class, mappedBy="event", cascade="remove")
     */
    private $socialLinks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cp;
    
    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $cashprize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="events")
     */
    private $department;

    /**
     * @ORM\ManyToMany(targetEntity=Platform::class, inversedBy="events")
     */
    private $support;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $organizer;

    public function __construct()
    {
        $this->availableGames = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->socialLinks = new ArrayCollection();
        $this->support = new ArrayCollection();
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

    public function getWebsiteLink(): ?string
    {
        return $this->websiteLink;
    }

    public function setWebsiteLink(string $websiteLink): self
    {
        $this->websiteLink = $websiteLink;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(\DateTimeInterface $launchDate): self
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getStopDate(): ?\DateTimeInterface
    {
        return $this->stopDate;
    }

    public function setStopDate(\DateTimeInterface $stopDate): self
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->shortDesc;
    }

    public function setShortDesc(string $shortDesc): self
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    public function getLongDesc(): ?string
    {
        return $this->longDesc;
    }

    public function setLongDesc(string $longDesc): self
    {
        $this->longDesc = $longDesc;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|AvailableGames[]
     */
    public function getAvailableGames(): Collection
    {
        return $this->availableGames;
    }

    public function addAvailableGame(AvailableGames $availableGame): self
    {
        if (!$this->availableGames->contains($availableGame)) {
            $this->availableGames[] = $availableGame;
        }

        return $this;
    }

    public function removeAvailableGame(AvailableGames $availableGame): self
    {
        if ($this->availableGames->contains($availableGame)) {
            $this->availableGames->removeElement($availableGame);
        }

        return $this;
    }

    /**
     * @return Collection|EventReviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(EventReviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setEvents($this);
        }

        return $this;
    }

    public function removeReview(EventReviews $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getEvents() === $this) {
                $review->setEvents(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTicketNumber(): ?int
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(int $ticketNumber): self
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    /**
     * @return Collection|SocialLinks[]
     */
    public function getSocialLinks(): Collection
    {
        return $this->socialLinks;
    }

    public function addSocialLink(SocialLinks $socialLink): self
    {
        if (!$this->socialLinks->contains($socialLink)) {
            $this->socialLinks[] = $socialLink;
            $socialLink->setEvent($this);
        }

        return $this;
    }

    public function removeSocialLink(SocialLinks $socialLink): self
    {
        if ($this->socialLinks->contains($socialLink)) {
            $this->socialLinks->removeElement($socialLink);
            // set the owning side to null (unless already changed)
            if ($socialLink->getEvent() === $this) {
                $socialLink->setEvent(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCashprize(): ?int
    {
        return $this->cashprize;
    }

    public function setCashprize(?int $cashprize): self
    {
        $this->cashprize = $cashprize;

        return $this;
    }

    public function getBanner()
    {
        return $this->banner;
    }

    public function setBanner($banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Platform[]
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Platform $support): self
    {
        if (!$this->support->contains($support)) {
            $this->support[] = $support;
        }

        return $this;
    }

    public function removeSupport(Platform $support): self
    {
        if ($this->support->contains($support)) {
            $this->support->removeElement($support);
        }

        return $this;
    }

    public function getOrganizer(): ?string
    {
        return $this->organizer;
    }

    public function setOrganizer(string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function slugify($string, $delimiter = '-') {
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}
