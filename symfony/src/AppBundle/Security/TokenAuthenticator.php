<?

namespace AppBundle\Security;

use AppBundle\Security\User\TokenUserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    const VALUE_TOKEN = 'X-AUTH-TOKEN';
    const KEY_TOKEN = 'token';

    protected $useHourFilter = false;

    public function __construct($useHourFilter = false)
    {
        $this->useHourFilter = $useHourFilter;
    }

    /**
     * Called on every request. Return whatever credentials you want,
     * or null to stop authentication.
     * @param Request $request
     * @return array|null
     */
    public function getCredentials(Request $request)
    {
        return ($value = $request->headers->get(self::VALUE_TOKEN))
            ? [self::KEY_TOKEN => $value]
            : null;
    }

    /**
     * if null, authentication will fail
     * if a User object, checkCredentials() is called
     * @param mixed $credentials
     * @param UserProviderInterface | TokenUserProvider $userProvider
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByToken($credentials[self::KEY_TOKEN]);
    }

    /**
     * check credentials - e.g. make sure the password is valid
     * no credential check is needed in this case
     * return true to cause authentication success
     *
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->useHourFilter
            ? !(date('H') % 2)
            : true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * to translate this message
     * $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
     *
     * @param Request $request
     * @param AuthenticationException|null $exception
     *
     * @throws UnauthorizedHttpException
     * @return void
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
     * Called when authentication is needed, but it's not sent
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @throws AccessDeniedHttpException
     * @return void
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
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
