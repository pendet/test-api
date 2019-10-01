<?php

class Api {
    private $_curl;
    public $method;
    public $url;
    public $data;
    public $resultData;

    public function __construct ()
    {
        $this->_curl = curl_init();
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUr()
    {
        return $this->url;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getResultData()
    {
        return $this->resultData;
    }

    public function getCurl()
    {
        switch ($this->method) {
            case "POST":
                curl_setopt($this->_curl, CURLOPT_CUSTOMREQUEST, 'POST');
                if ($this->data) {
                    curl_setopt($this->_curl, CURLOPT_POSTFIELDS, http_build_query($this->data));
                }
                break;
            default:
                if ($this->data) {
                    $this->url = sprintf("%s?%s", $this->url, http_build_query($this->data));
                }
        }

        curl_setopt($this->_curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($this->_curl, CURLOPT_URL, $this->url);
        curl_setopt($this->_curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_curl, CURLOPT_USERPWD, AUTHKEY . ':' . '');
        curl_setopt($this->_curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->_curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($this->_curl);
        $err = curl_error($this->_curl);
        if (!$result) {
            die($err);
        }
        curl_close($this->_curl);
        $this->resultData = json_decode($result);
        return $this->resultData;
    }

}
?>