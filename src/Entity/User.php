<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/*
 Pour obtenir de l'aide sur les option supplementaires que peuvent prendre certaines commandes utiliser l'option --help
 ex: console make:entity --help
 Pour regenerer  /completer les getter / setter de mon entité si il en manque :
 php bin/console make:entity --regenerate
 */
/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=254)
     */
    private $email;
   
   
   
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
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
        $roles = [];
        if(!is_null($this->role)){
            $roles[] = $this->role->getCode(); // ici on stockera le code associé dans la BDD dans le genre ROLE_USER, ROLE_ADMIN, ROLE_MEMBER etc ...
        } else {
            $roles[] = 'ROLE_USER'; // par defaut si notre utilisateur a été stocké dans role on retournera role_user pour que symfony ne plante pas
        }
        return $roles;
    }
    //ici nous retrouvons les vrai getter /setter de notre propriété ici 1,1 vers 1,N
    public function getRole(): ?Role
    {
        return $this->role;
    }
    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }
    public function eraseCredentials()
    {
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