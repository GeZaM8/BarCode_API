<?php

namespace App\Filters;

use App\Models\User;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardFilter implements FilterInterface
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
     * @param array|null       $roles
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $roles = null)
    {
        $userSession = session()->get("auth_login");
        if (!$userSession or !is_array($userSession)) {
            session()->remove("auth_login");
            return redirect()->to("/web");
        }

        if (!isset($userSession['id']) || !isset($userSession['email'])) {
            session()->remove("auth_login");
            return redirect()->to("/web");
        }

        $user = new User();
        $userLogged = $user->getUserJoin()->where("users.id_user", $userSession['id'])->first();

        $accessRoleCheck = false;
        if ($roles) {
            foreach ($roles as $r) {
                if ($userLogged->id_role == $r) $accessRoleCheck = true;
            }
        }

        if (!$accessRoleCheck) return redirect()->to("/web");
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
