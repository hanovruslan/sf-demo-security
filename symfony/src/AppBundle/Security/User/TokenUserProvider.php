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
        //for compatibility
    }

    public function loadUserByToken($token = null)
    {
        $repository = $this->entityManager->getRepository($this->class);
        $user = $repository->findOneBy([
            'token' => $token,
        ]);
        if ($user instanceof $this->class) {
            return $user;
        }

        throw new UsernameNotFoundException(
            sprintf('Unable to load user by token "%s"', $token)
        );
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
