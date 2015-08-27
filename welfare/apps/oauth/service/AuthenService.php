<?php

namespace apps\oauth\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\collection\CJView;
use th\co\bpg\cde\collection\CJViewType;
use th\co\bpg\cde\data\CDataContext;
use apps\oauth\interfaces\IAuthenService;
use Firebase\JWT\JWT;

class AuthenService extends CServiceBase implements IAuthenService {

    public $datacontext;
    public $logger;
    public $md = "apps\\common\\model";
    public $ent = "apps\\common\\entity";

    function __construct() {
        $this->logger = \Logger::getLogger("root");
        $this->datacontext = new CDataContext(null);
    }

    public function authorization() {
        $code = $this->getRequest()->code;
        if ($this->getRequest()->username && $this->getRequest()->password) {
            $username = $this->getRequest()->username;
            $password = $this->getRequest()->password;
            $check = new \apps\user\entity\User();
            $check->userName = $username;
            $check->password = md5($password);
            $user = $this->datacontext->getObject($check);

            if (count($user) > 0) {
                
                $data = base64_decode($code);
                
                $datas = explode("|", $data);
                $cc = (array) JWT::decode($datas[1], "123456", array('HS256'));
                $pp = array(
                    "uid" => $user[0]->userId
                );
                
                $uid = JWT::encode($pp, "123456");
                $euid = base64_encode($uid);

                $authUrl = $cc['OAUTH2_CALLBACK_URL'] . "?code=" . $euid;
                header('Location: ' . $authUrl);
                exit;
            } else {
                $view = new CJView("signin", CJViewType::HTML_VIEW_ENGINE);
                $view->code = $code;
                $view->username = $username;
                $view->password = $password;
                return $view;
                // return "xxxx";
            }
        } else {
            $view = new CJView("signin", CJViewType::HTML_VIEW_ENGINE);
            $view->code = $code;
            return $view;
        }
    }

    public function authenticate() {
        $this->logger->info("authenticate.....");
        $euid = $this->getRequest()->code;
        $uid = base64_decode($euid);

        $uidd = (array) JWT::decode($uid, "123456", array('HS256'));

        $check = new \apps\user\entity\User();
        $check->userId = $uidd['uid'];
        $user = $this->datacontext->getObject($check);
        if (count($user) > 0) {

            // $role = new \apps\common\entity\Register();
            // $role->code = $user[0]->registerId;
            //$xrole = $this->datacontext->getObject($role);


            $xinfo = new \apps\member\entity\Member();
            $xinfo->memberId = $user[0]->memberId;

            $info = $this->datacontext->getObject($xinfo);

            $acc = new \th\co\bpg\cde\collection\CJAccount();
            $acc->code = $info[0]->memberId;
            $acc->name = $info[0]->fname." ".$info[0]->lname;
            $acc->userTypeId = $user[0]->userTypeId;
            $acc->domain = $user[0]->userTypeId;
            $acc->resources = array();

            //$acc->facultyId=$user[0]->registerId;

            $acc->attribute = array();
            $acc->attribute["departmentId"] = $info[0]->departmentId;
            $acc->attribute["facultyId"] = $info[0]->facultyId;
            $acc->attribute["memberId"] = $user[0]->memberId;
            //print $acc;
            //$acc->departmentId=$user[0]->departmentId;

            if ($user[0]->userTypeId == 1) {
                $acc->resources[] = "1000";
            } else {
                $acc->resources[] = "0100";
            }

            $uinfo = JWT::encode($acc, "123456");
            $uinfo = base64_encode($uinfo);
            //return $uinfo;
            print $uinfo;
            exit();
        }
    }

}
