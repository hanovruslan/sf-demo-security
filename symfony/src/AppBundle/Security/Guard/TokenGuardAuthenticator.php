<?

namespace AppBundle\Security\Guard;

use AppBundle\Security\User\TokenUserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenGuardAuthenticator extends AbstractGuardAuthenticator
{
    const HEADER = 'X-AUTH-TOKEN';
    const CREDENTIAL_KEY = 'token';

    /** @var bool */
    protected $useHourFilter = false;

    /**
     * @param bool $useHourFilter
     */
    public function __construct($useHourFilter = false)
    {
        $this->useHourFilter = $useHourFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        return ($value = $request->headers->get(self::HEADER))
            ? [self::CREDENTIAL_KEY => $value]
            : null;
    }

    /**
     * if null, authentication will fail
     * if a User object, checkCredentials() is called
     *
     * @param mixed $credentials
     * @param UserProviderInterface|TokenUserProvider $userProvider
     *
     * @return UserInterface
     * @throws UsernameNotFoundException if the user is not found
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByToken($credentials[self::CREDENTIAL_KEY]);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->useHourFilter
            ? !(date('H') % 2)
            : true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
//        return new JsonResponse(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        throw new AccessDeniedHttpException(
            Response::$statusTexts[Response::HTTP_FORBIDDEN],
            $exception,
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
//        return new JsonResponse(['message' => 'Authentication Required'], Response::HTTP_UNAUTHORIZED);
        throw new UnauthorizedHttpException(
            'Bearer',
            Response::$statusTexts[Response::HTTP_UNAUTHORIZED],
            $authException,
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
