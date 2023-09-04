<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use think\response\Json;
use think\response\View;

class AuthController extends BaseController
{
    public function registerPage(): View
    {
        return env('enable_register') ?
            view('/auth/register') :
            view('/error', [
                'msg' => '注册功能已关闭'
            ]);
    }

    public function register(): Json
    {
        if (!env("ENABLE_REGISTER")) {
            return json(['ret' => 0, 'msg' => '注册功能已关闭']);
        }
        $username = $this->request->param('username');
        if (empty($username)) {
            return json(['ret' => 0, 'msg' => '用户名不能为空']);
        }
        $password = $this->request->param('password');
        if (empty($password)) {
            return json(['ret' => 0, 'msg' => '密码不能为空']);
        }
        $result = $this->app->authService->userRegister($username, $password);
        if ($result) {
            return json(['ret' => 1, 'msg' => '注册成功']);
        } else {
            return json(['ret' => 0, 'msg' => '注册失败']);
        }
    }

    public function login(): Json
    {
        $username = $this->request->param('username');
        if (empty($username)) {
            return json(['ret' => 0, 'msg' => '用户名不能为空']);
        }
        $password = $this->request->param('password');
        if (empty($password)) {
            return json(['ret' => 0, 'msg' => '密码不能为空']);
        }
        $result = $this->app->authService->userLogin($username, $password);
        if ($result) {
            return json(['ret' => 1, 'msg' => '登录成功']);
        } else {
            return json(['ret' => 0, 'msg' => '登录失败，用户名或密码错误']);
        }
    }
}
