<?php

namespace apps\common;

use \th\co\bpg\cde\core\COAuthClient;
use Firebase\JWT\JWT;

class AuthClient extends COAuthClient {

    protected $token;
    protected $params;

    public function __construct($params) {
        $this->params = $params;
        if (isset($_COOKIE['token'])) {
            $this->token = $_COOKIE['token'];
        }
    }

    public function authenticate() {
        $key = $this->params["OAUTH2_ACCESS_KEY"];
        $code = null;
        if (!$code && isset($_GET[$key])) {
            $code = $_GET[$key];
        }
        if ($code) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->params['OAUTH2_TOKEN_URI']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->params["OAUTH2_ACCESS_KEY"] . "=" . $code);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            echo $this->params['OAUTH2_TOKEN_URI'];
            $server_output = curl_exec($ch);
            echo $server_output;
            $this->token = $server_output;
            curl_close($ch);

            if ($this->token) {
                setcookie("token", $this->token, 0, "/");
                return true;
            }
            return true;
        } else {
            $this->authorization();
            return false;
        }
    }

    public function authorization() {
        $p = array(
            "OAUTH2_CALLBACK_URL" => $this->params["OAUTH2_CALLBACK_URL"]
        );
        $data = JWT::encode($p, $this->params["OAUTH2_CLIENT_SECRET"]);
        $data = base64_encode($this->params["OAUTH2_CLIENT_ID"] . "|" . $data);
        $authUrl = $this->params["OAUTH2_AUTH_URL"] . "?" . $this->params["OAUTH2_ACCESS_KEY"] . "=" . $data;
        header('Location: ' . $authUrl);
        if ($this->params['WITH_AJAX_CALL']) {
            http_response_code("401");
        }
        exit();
    }

    public function getAccessToken() {
        return $this->token;
    }

    public function getUserInfo() {
        $data = base64_decode($this->token);
        $acc = JWT::decode($data, $this->params["OAUTH2_CLIENT_SECRET"], array('HS256'));
        //print_r($acc->resources);
        setcookie("userinfo", $acc->name, 0, "/");
        setcookie("userTypeId", $acc->userTypeId, 0, "/");
        return $acc;
    }

}
