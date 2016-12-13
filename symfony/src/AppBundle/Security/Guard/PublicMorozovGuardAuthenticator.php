<?php

namespace AppBundle\Security\Guard;

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

class PublicMorozovGuardAuthenticator extends AbstractGuardAuthenticator
{
    const HEADER = 'X-AUTH-USERNAME';
    const CREDENTIAL_KEY = 'username';

    /**
     * Called on every request. Return whatever credentials you want,
     * or null to stop authentication.
     * @param Request $request
     * @return array|null
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
     * @param mixed $credentials
     * @param UserProviderInterface|TokenUserProvider $userProvider
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials[self::CREDENTIAL_KEY]);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
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
        throw new AccessDeniedHttpException(
            Response::$statusTexts[$code = Response::HTTP_FORBIDDEN],
            $exception,
            $code
        );
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new UnauthorizedHttpException(
            'Bearer',
            Response::$statusTexts[$code = Response::HTTP_UNAUTHORIZED],
            $authException,
            $code
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