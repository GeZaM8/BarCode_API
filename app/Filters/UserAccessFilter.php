<?php

namespace App\Filters;

use App\Models\User;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserAccessFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $userSession = session()->get("auth_login");
        if ($userSession && is_array($userSession)) {
            if (isset($userSession['id']) || isset($userSession['email'])) {
                $user = new User();
                $userLogged = $user->where("users.id_user", $userSession['id'])->first();

                switch ($userLogged->id_role) {
                    case 1:
                        session()->remove("auth_login");
                        return redirect()->to("/web")->with("error", ["Sorry, Student can only login using mobile app"]);
                        break;
                    case 2:
                        return redirect()->to("/web/teacher");
                        break;
                    case 3:
                        return redirect()->to("/web/admin");
                        break;
                }
            }
        }

        session()->remove("auth_login");
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
