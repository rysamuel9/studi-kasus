<?php

namespace App\Controllers;

// namespace Firebase\JWT;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        // Instance model
        $model = new UserModel();
        $user = $model->where('username', $this->request->getVar('username'))->first();

        if (!$user) return $this->failNotFound('Username Not Found');

        $verifyPass = password_verify($this->request->getVar('password'), $user['password']);

        if (!$verifyPass) {
            return $this->fail('Invalid Password');
        }

        $key = getenv('SECRET_TOKEN');
        $payload = array(
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "uid" => $user['id'],
            "username" => $user['username']
        );

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond($token);
    }
}
