<?

namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenUserProvider implements UserProviderInterface
{
    /** @var EntityManager */
    protected $entityManager;

    protected $class = User::class;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username = null)
    {
        return $this->loadUserByAttribute('username', $username);
    }

    /**
     * Loads the user for the given token.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $token The token
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByToken($token = null)
    {
        return $this->loadUserByAttribute('token', $token);
    }

    /**
     * @param $name
     * @param null $value
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    protected function loadUserByAttribute($name, $value = null)
    {
        /** @var User|null $user */
        $user = null;
        $repository = $this->entityManager->getRepository($this->class);
        if (null !== $value) {
            $user = $repository->findOneBy([
                $name => $value,
            ]);
        }
        if (!($user instanceof $this->class)) {
            throw new UsernameNotFoundException(
                sprintf('Unable to load user by %s "%s"', $name, $value)
            );
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->class;
    }
}
