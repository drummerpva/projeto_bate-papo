<?php
class loginController extends controller
{
    private $user;
    public function __construct()
    {
        $this->user = new Users();
        if ($this->user->verifyLogin()) {
            header("Location: " . BASE_URL);
        }
    }

    public function index()
    {
        $dados = ['msg' => ''];
        if (!empty($_GET['error'])) {
            if ($_GET['error'] == 1) {
                $dados['msg'] = "Usuário e/ou senha inválidos!";
            }
        }

        $this->loadView('login', $dados);
    }
    public function signin()
    {
        $dados = [];
        if (!empty($_POST['username'])) {
            $username = strtolower($_POST['username']);
            $pass = strtolower($_POST['pass']);

            $u = new Users();
            if ($u->validateUser($username, $pass)) {
                header("Location: " . BASE_URL);
                exit;
            } else {
                header("Location: " . BASE_URL . "login?error=1");
                exit;
            }

        } else {
            header("Location: " . BASE_URL . "login");
            exit;
        }

    }
    public function signup()
    {
        $dados = ['msg' => ''];
        if (!empty($_POST['username'])) {
            $username = strtolower($_POST['username']);
            $pass = $_POST['pass'];
            $u = new Users();
            if ($u->validateUsername($username)) {
                if (!$u->userExists($username)) {
                    $u->registerUser($username, $pass);
                    header("Location: " . BASE_URL);
                } else {
                    $dados['msg'] = "Usuário já cadastrado!";
                }
            } else {
                $dados['msg'] = "Usuário inválido!";
            }

        }

        $this->loadView('signup', $dados);
    }
    public function logOut()
    {
        $u = new Users();
        $u->clearLoginHash();
        header("Location: " . BASE_URL);
    }

}
