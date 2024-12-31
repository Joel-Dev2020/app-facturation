<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * @see https://symfony.com/doc/current/security/custom_authenticator.html
 */
class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const ADMIN_ROUTE = 'app_admin';

    public function __construct(
        private readonly SecurityUserProvider  $securityUserProvider,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RouterInterface       $router
    )
    {
    }

    public function authenticate(Request $request): Passport
    {
        $password = $request->getPayload()->get('password');
        $email = $request->getPayload()->getString('email');
        $csrfToken = $request->getPayload()->get('csrf_token');

        return new Passport(
            new UserBadge($email, $this->securityUserProvider->loadUserByIdentifier(...)),
            new PasswordCredentials($password),
            [new CsrfTokenBadge('login', $csrfToken), new RememberMeBadge()]
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        // Ajoutez un message d'erreur personnalisé
        $request->getSession()->getFlashBag()->add('danger', 'Identifiants incorrects. Veuillez réessayer.');
        // Redirection vers la page de connexion
        return new RedirectResponse($this->router->generate(self::LOGIN_ROUTE));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        $user = $token->getUser();
        if ($user) {
            return new RedirectResponse($this->router->generate(self::ADMIN_ROUTE));
        } else {
            return new RedirectResponse($this->router->generate(self::LOGIN_ROUTE));
        }
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
