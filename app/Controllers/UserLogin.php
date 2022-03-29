<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\HTTP\RequestTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserLogin extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use RequestTrait;
    public function index()
    {
        $key = getenv('SECRET_TOKEN');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Token Required');
        $token = explode(' ', $header)[1];

        try {
            $decoded = $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $res = [
                'id' => $decoded->uid,
                'username' => $decoded->username
            ];

            // Send res to user
            return $this->respond($res);
        } catch (\Throwable $th) {
            return $this->fail('Invalid Token');
        }
    }
}
