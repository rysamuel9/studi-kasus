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
        // helper(['form']);
        // $rules = [
        //     'username' => 'required',
        //     'password' => 'required|min_length[6]',
        // ];

        // if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        // instance model
        $model = new UserModel();

        $login = $this->request->getPost('login');

        if ($login) {

            // $user = $this->request->getPost('user');
            $user = $model->where('username', $this->request->getPost('user'))->first();

            if (!$user) return $this->failNotFound('Username Not Found');

            $verifyPass = password_verify($this->request->getPost('userpass'), $user['password']);

            if (!$verifyPass) {
                return $this->fail('Invalid Password');
            }
        }
        $key = getenv('SECRET_TOKEN');
        $payload = array(
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "uid" => $user['id'],
            "username" => $user['username']
        );
        $token = JWT::encode($payload, $key, 'HS256');
        // JWT::encode($payload, $key, 'HS256');

        return $this->respond($token);

        // return view('home');
        // return redirect()->to('home');
        // return view('home');


    }
}
