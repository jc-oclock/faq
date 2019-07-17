<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
    * @ORM\Column(type="json")
    */
    private $roles = [];
    
    
    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function getPassword()
    {
        return $this->password;
    }
    /*
     ATTENTION cette fonction n'est pas dédié à etre une getter /setter necessaires aux relations doctrine.
     Cette fonction être utilisé par symfony lui meme lorsque l'utilisateur s'authentifie, elle permet de retourner le ou / les roles associé a un utilisateur
     de ce fait meme si mon utilisateur n'a qu'un seul role je doit OBLIGATOIREMENT retourner un tableau de roles
     
     Note :cette fonction est appelée une seule fois lorsque mon utilisateur s'authentifie. en effet un new de cette entité sera fait puis stocké en session . si je souhaite changer une valeur de mon user je devrait donc me donnecter ou vider la session 
     */
    public function getRoles(): array // fonction necessaire pour security.yml => ceci n'est pas un getter en relation avec ma BDD
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
    
        return array_unique($roles);
    }
    
    
    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ]);
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    //actuellement ceci est un patch "= null" pour eviter le probleme avec notre formulaire
    public function setPassword(string $password = null): self
    {
        $this->password = $password;
        return $this;
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
    
    
   
    
}