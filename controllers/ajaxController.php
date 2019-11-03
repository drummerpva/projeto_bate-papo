<?php
class ajaxController extends controller
{
    private $user;
    public function __construct()
    {
        $this->user = new Users();
        if (!$this->user->verifyLogin()) {
            $array = [
                'status' => '0',
            ];
            echo json_encode($array);
            exit;
        }
    }

    public function index()
    {}
    public function getGroups()
    {
        $array = ['status' => '1'];

        $g = new Groups();
        $array['list'] = $g->getList();

        echo json_encode($array);
        exit;
    }
    public function addGroup()
    {
        $array = ['error' => '0'];
        $g = new Groups();
        if (!empty($_POST['name'])) {
            $name = addslashes($_POST['name']);
            $g->add($name);
            $array['status'] = '1';
        } else {
            $array['error'] = '1';
            $array['errorMsg'] = 'Não foi enviado o nome do Grupo';
        }

        echo json_encode($array);
        exit;
    }
    public function addMessage()
    {
        $array = ['status' => '1', 'error' => '0'];
        $m = new Messages();
        if (!empty($_POST['msg']) && !empty($_POST['idGroup'])) {
            $msg = addslashes($_POST['msg']);
            $idGroup = addslashes($_POST['idGroup']);
            $uId = $this->user->getId();
            $m->add($uId, $idGroup, $msg);
        } else {
            $array['error'] = '1';
            $array['errorMsg'] = 'Mensagem ou Grupo Não informado';
        }

        echo json_encode($array);
        exit;
    }
    public function addPhoto()
    {
        $array = ['status' => '1', 'error' => '0'];
        $m = new Messages();
        if (!empty($_POST["idGroup"])) {
            $idGroup = addslashes($_POST['idGroup']);
            $uId = $this->user->getId();
            $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!empty($_FILES['img']['tmp_name'])) {
                if (in_array($_FILES['img']['type'], $allowed)) {
                    $newName = md5(time() . rand(0, 9999));
                    if ($_FILES['img']['type'] == 'image/png') {
                        $newName .= ".png";
                    } else {
                        $newName .= ".jpg";
                    }
                    move_uploaded_file($_FILES['img']['tmp_name'], "./media/images/" . $newName);

                    $m->add($uId, $idGroup, $newName, 'img');
                } else {
                    $array['error'] = '1';
                    $array['errorMsg'] = 'Arquivo inválido!';
                }
            } else {
                $array['error'] = '1';
                $array['errorMsg'] = 'Sem arquivo!';
            }

        } else {
            $array['error'] = '1';
            $array['errorMsg'] = 'Grupo inválido';
        }

        echo json_encode($array);
        exit;
    }

    public function getUserList()
    {
        $array = ['status' => '1', 'users' => []];
        $groups = [];
        if (!empty($_GET['groups']) && is_array($_GET['groups'])) {
            $groups = $_GET['groups'];
        }
        foreach ($groups as $group) {
            $array['users'][$group] = $this->user->getUsersInGroup($group);
        }

        echo json_encode($array);
        exit;
    }

    public function getMessages()
    {
        set_time_limit(60);
        $array = ['status' => '1', 'msgs' => [], 'lastTime' => date_default_timezone_set('America/Sao_Paulo')];
        $m = new Messages();

        $ultMsg = date('Y-m-d H:i:s');
        if (!empty($_GET['lastTime'])) {
            $ultMsg = $_GET['lastTime'];
        }
        $groups = [];
        if (!empty($_GET['groups']) && is_array($_GET['groups'])) {
            $groups = $_GET['groups'];
        }
        $this->user->updateGroups($groups);
        $this->user->clearGroups();

        while (true) {
            session_write_close();
            $msgs = $m->get($ultMsg, $groups);
            if (count($msgs) > 0) {
                $array['msgs'] = $msgs;
                $array['lastTime'] = date('Y-m-d H:i:s');

                break;
            } else {
                sleep(2);
                continue;
            }
        }

        echo json_encode($array);
        exit;
    }

}
