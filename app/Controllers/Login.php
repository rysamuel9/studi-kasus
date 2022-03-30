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
        $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

        // form data

        $secret = env('RECAPTCHAV2_SITEKEY');

        $credential = array(
            'secret' => $secret,
            'response' => $recaptchaResponse
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);

        $status = json_decode($response, true);

        $session = session();
        $model = new UserModel();

        if ($status['success']) {

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
        } else {

            $session->setFlashdata('msg', 'Please check your inputs');
        }

        // instance model


        // return view('home');
        // return redirect()->to('home');
        // return view('home');


    }
}
