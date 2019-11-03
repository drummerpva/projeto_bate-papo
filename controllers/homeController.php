<?php
class homeController extends controller
{
    private $user;
    public function __construct()
    {
        $this->user = new Users();
        if (!$this->user->verifyLogin()) {
            header("Location: " . BASE_URL . "login");
            exit;
        }
    }

    public function index()
    {
        $dados = [
            'name' => $this->user->getName(),
            'currentGroups' => $this->user->getCurrentGroups(),
        ];



        $this->loadTemplate('home', $dados);
    }

}
