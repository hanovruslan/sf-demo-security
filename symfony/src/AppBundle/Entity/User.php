<?

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(unique=true)
     */
    protected $token;

    public function getId()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return [
            'ROLE_CLIENT',
            'ROLE_MANAGER',
            'ROLE_ADMIN',
        ];
    }

    public function getPassword()
    {
        //for compatibility
    }
    public function getSalt()
    {
        //for compatibility
    }
    public function eraseCredentials()
    {
        //for compatibility
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $token
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
