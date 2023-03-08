<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', 'Un autre utilisateur utilise déjà cette adresse email')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotBlank(message: "L'ID de l'utilisateur est obligatoire")]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "L'adresse email de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "L'adresse email de l'utilisateur doit être compris entre 10 et 180 caractères")]
    #[Assert\Length(max: 180,maxMessage: "L'adresse email de l'utilisateur être compris entre 10 et 180 caractères")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Le mot de passe de l'utilisateur est obligatoire")]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Le pseudo de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "Le pseudo de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "Le pseudo de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "Le prénom de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "Le prénom de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "Le nom de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "Le nom de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 10,minMessage: "La description de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "La description de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "L'adresse de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "L'adresse de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $address = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le code postal de l'utilisateur est obligatoire")]
    private ?string $postal_code = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(message: "La ville de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "La ville de l'utilisateur doit être compris entre 10 et 60 caractères")]
    #[Assert\Length(max: 60,maxMessage: "La ville de l'utilisateur être compris entre 10 et 60 caractères")]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le numéro de téléphone de l'utilisateur est obligatoire")]
    private ?string $phone_number = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La date d'anniversaire de l'utilisateur est obligatoire")]
    private ?\DateTime $birthday = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La date de création de l'utilisateur est obligatoire")]
    private ?\DateTime $created_at = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'état de validation de l'utilisateur est obligatoire")]
    private ?bool $state_validated = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'état de suspend de l'utilisateur est obligatoire")]
    private ?bool $state_suspended = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "L'emplacement de la carte d'identité de l'utilisateur est obligatoire")]
    #[Assert\Length(min: 10,minMessage: "L'emplacement de la carte d'identité de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "L'emplacement de la carte d'identité de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $identity_card_location = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'état de la validation d'identité de l'utilisateur est obligatoire")]
    private ?bool $identity_card_validated = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 10,minMessage: "La photo de profil de l'utilisateur doit être compris entre 10 et 255 caractères")]
    #[Assert\Length(max: 255,maxMessage: "La photo de profil de l'utilisateur être compris entre 10 et 255 caractères")]
    private ?string $profile_picture = null;

    // Relations

    #[ORM\OneToMany(mappedBy: 'created_by', targetEntity: Publication::class, orphanRemoval: true)]
    private Collection $publications;

    // To do

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: UserManageEvent::class, orphanRemoval: true)]
    private Collection $userManageEvents;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserEditComment::class, orphanRemoval: true)]
    private Collection $userEditComments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCreateFilter::class, orphanRemoval: true)]
    private Collection $userCreateFilters;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserBelongGroup::class, orphanRemoval: true)]
    private Collection $userBelongGroups;

    #[ORM\OneToMany(mappedBy: 'userSendMessage', targetEntity: UserCommunicateGroup::class, orphanRemoval: true)]
    private Collection $userCommunicateGroups;

    #[ORM\OneToMany(mappedBy: 'userSender', targetEntity: UserRelationship::class, orphanRemoval: true)]
    private Collection $userRelationships;

    #[ORM\OneToMany(mappedBy: 'userSender', targetEntity: CommunicateUser::class, orphanRemoval: true)]
    private Collection $communicateUsers;

    public function __construct()
    {
        $this->userManageEvents = new ArrayCollection();
        $this->userEditComments = new ArrayCollection();
        $this->userCreateFilters = new ArrayCollection();
        $this->userBelongGroups = new ArrayCollection();
        $this->userCommunicateGroups = new ArrayCollection();
        $this->userRelationships = new ArrayCollection();
        $this->communicateUsers = new ArrayCollection();
        $this->publications = new ArrayCollection();
    }

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isStateValidated(): ?bool
    {
        return $this->state_validated;
    }

    public function setStateValidated(bool $state_validated): self
    {
        $this->state_validated = $state_validated;

        return $this;
    }

    public function isStateSuspended(): ?bool
    {
        return $this->state_suspended;
    }

    public function setStateSuspended(bool $state_suspended): self
    {
        $this->state_suspended = $state_suspended;

        return $this;
    }

    public function getIdentityCardLocation(): ?string
    {
        return $this->identity_card_location;
    }

    public function setIdentityCardLocation(?string $identity_card_location): self
    {
        $this->identity_card_location = $identity_card_location;

        return $this;
    }

    public function isIdentityCardValidated(): ?bool
    {
        return $this->identity_card_validated;
    }

    public function setIdentityCardValidated(bool $identity_card_validated): self
    {
        $this->identity_card_validated = $identity_card_validated;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    public function setProfilePicture(string $profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    /**
     * @return Collection<int, UserManageEvent>
     */
    public function getUserManageEvents(): Collection
    {
        return $this->userManageEvents;
    }

    public function addUserManageEvent(UserManageEvent $userManageEvent): self
    {
        if (!$this->userManageEvents->contains($userManageEvent)) {
            $this->userManageEvents->add($userManageEvent);
            $userManageEvent->setUser($this);
        }

        return $this;
    }

    public function removeUserManageEvent(UserManageEvent $userManageEvent): self
    {
        if ($this->userManageEvents->removeElement($userManageEvent)) {
            // set the owning side to null (unless already changed)
            if ($userManageEvent->getUser() === $this) {
                $userManageEvent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserEditComment>
     */
    public function getUserEditComments(): Collection
    {
        return $this->userEditComments;
    }

    public function addUserEditComment(UserEditComment $userEditComment): self
    {
        if (!$this->userEditComments->contains($userEditComment)) {
            $this->userEditComments->add($userEditComment);
            $userEditComment->setUser($this);
        }

        return $this;
    }

    public function removeUserEditComment(UserEditComment $userEditComment): self
    {
        if ($this->userEditComments->removeElement($userEditComment)) {
            // set the owning side to null (unless already changed)
            if ($userEditComment->getUser() === $this) {
                $userEditComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCreateFilter>
     */
    public function getUserCreateFilters(): Collection
    {
        return $this->userCreateFilters;
    }

    public function addUserCreateFilter(UserCreateFilter $userCreateFilter): self
    {
        if (!$this->userCreateFilters->contains($userCreateFilter)) {
            $this->userCreateFilters->add($userCreateFilter);
            $userCreateFilter->setUser($this);
        }

        return $this;
    }

    public function removeUserCreateFilter(UserCreateFilter $userCreateFilter): self
    {
        if ($this->userCreateFilters->removeElement($userCreateFilter)) {
            // set the owning side to null (unless already changed)
            if ($userCreateFilter->getUser() === $this) {
                $userCreateFilter->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserBelongGroup>
     */
    public function getUserBelongGroups(): Collection
    {
        return $this->userBelongGroups;
    }

    public function addUserBelongGroup(UserBelongGroup $userBelongGroup): self
    {
        if (!$this->userBelongGroups->contains($userBelongGroup)) {
            $this->userBelongGroups->add($userBelongGroup);
            $userBelongGroup->setUser($this);
        }

        return $this;
    }

    public function removeUserBelongGroup(UserBelongGroup $userBelongGroup): self
    {
        if ($this->userBelongGroups->removeElement($userBelongGroup)) {
            // set the owning side to null (unless already changed)
            if ($userBelongGroup->getUser() === $this) {
                $userBelongGroup->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCommunicateGroup>
     */
    public function getUserCommunicateGroups(): Collection
    {
        return $this->userCommunicateGroups;
    }

    public function addUserCommunicateGroup(UserCommunicateGroup $userCommunicateGroup): self
    {
        if (!$this->userCommunicateGroups->contains($userCommunicateGroup)) {
            $this->userCommunicateGroups->add($userCommunicateGroup);
            $userCommunicateGroup->setUserSendMessage($this);
        }

        return $this;
    }

    public function removeUserCommunicateGroup(UserCommunicateGroup $userCommunicateGroup): self
    {
        if ($this->userCommunicateGroups->removeElement($userCommunicateGroup)) {
            // set the owning side to null (unless already changed)
            if ($userCommunicateGroup->getUserSendMessage() === $this) {
                $userCommunicateGroup->setUserSendMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserRelationship>
     */
    public function getUserRelationships(): Collection
    {
        return $this->userRelationships;
    }

    public function addUserRelationship(UserRelationship $userRelationship): self
    {
        if (!$this->userRelationships->contains($userRelationship)) {
            $this->userRelationships->add($userRelationship);
            $userRelationship->setUserSender($this);
        }

        return $this;
    }

    public function removeUserRelationship(UserRelationship $userRelationship): self
    {
        if ($this->userRelationships->removeElement($userRelationship)) {
            // set the owning side to null (unless already changed)
            if ($userRelationship->getUserSender() === $this) {
                $userRelationship->setUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommunicateUser>
     */
    public function getCommunicateUsers(): Collection
    {
        return $this->communicateUsers;
    }

    public function addCommunicateUser(CommunicateUser $communicateUser): self
    {
        if (!$this->communicateUsers->contains($communicateUser)) {
            $this->communicateUsers->add($communicateUser);
            $communicateUser->setUserSender($this);
        }

        return $this;
    }

    public function removeCommunicateUser(CommunicateUser $communicateUser): self
    {
        if ($this->communicateUsers->removeElement($communicateUser)) {
            // set the owning side to null (unless already changed)
            if ($communicateUser->getUserSender() === $this) {
                $communicateUser->setUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setCreatedBy($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getCreatedBy() === $this) {
                $publication->setCreatedBy(null);
            }
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
