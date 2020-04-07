<?php

namespace WA\Request;

class HTTP_Request
{
    private $method;
    private $time;

    private $uri;
    private $query;
    private $path;
    private $params;
    private $body;

    public function __construct()
    {
        $this->setRequestAttributes();
        $this->setRequestBody();
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name))
            return $this->$name;

        return null;
    }
    
    private function setRequestAttributes()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->time = $_SERVER["REQUEST_TIME"];
        $this->uri = $_SERVER["REQUEST_URI"];
        $this->query = $_SERVER["QUERY_STRING"];
        $this->path = explode("?", $this->uri)[0];
        $this->params = (object) array(
            "_GET" => (object) $_GET,
            "_POST" => (object) $_POST,
        );
    }

    private function setRequestBody()
    {
        try {
            $request_body = file_get_contents("php://input");
            $this->body = json_decode($request_body, true);
        }
        catch (\Throwable $th) {
            $this->body = null;
        }

    }
}
