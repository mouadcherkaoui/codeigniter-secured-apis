<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\IncomingRequest;
use Firebase\JWT\JWT;
use Exception;

class Authorization implements FilterInterface
{
    private $request;
    private $response;

    public function __construct()
    {
        $this->request = service('request');
        $this->response = service('response');
    }
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
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        //
        // $auth = $this->request->getHeader('Authorization');
        $key = getenv('JWT_AUTH_SECRET_KEY');
        $authHeader = $this->request->getHeaderLine("Authorization");
        $authHeader = str_replace("Bearer ", "", $authHeader);
        $token = $authHeader;

        try {
            $decoded = JWT::decode($token, $key, array("HS256"));

            if ($decoded) {
                return;
            }
        } catch (Exception $ex) {
          
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Access denied',
                'data' => []
            ];
        }
        if($authHeader == null){
    
            $response = service('response');
            $this->response->setStatusCode(401);
            $this->response->setHeader("WWW-Authenticate", "Bearer Token");
            $this->response->setBody("{\"error\": \"unauthorized\"}");
    
            return $response;
    
        }
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
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
