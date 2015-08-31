<?php

namespace apps\root\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use apps\root\interfaces\IViewService;

class ViewService extends CServiceBase implements IViewService {

    public function index() {

        $view = new CJView("index", CJViewType::HTML_VIEW_ENGINE);
        return $view;
    }

    public function logout() {
        unset($_COOKIE['token']);
        unset($_COOKIE['userinfo']);
        unset($_COOKIE['usertype']);
        setcookie('token', null, -1, '/');
        setcookie('userinfo', null, -1, '/');
        setcookie('usertype', null, -1, '/');
        return $this->index();
    }

}
