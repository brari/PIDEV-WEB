<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 04/02/2017
 * Time: 01:31
 */

namespace AnnuaireBundle\Security;



    use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
    use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Bundle\FrameworkBundle\Routing\Router;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{

    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request)
    {
        // redirect the user to where they were before the login process begun.
        $response = new RedirectResponse($this->router->generate('fos_user_security_login'));
        return $response;
    }

}