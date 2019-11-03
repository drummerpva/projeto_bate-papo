<?php
class Users extends Model
{
    private $uId;

    public function verifyLogin()
    {
        if (!empty($_SESSION['chatHashLogin'])) {
            $s = $_SESSION['chatHashLogin'];
            $sql = $this->db->prepare("SELECT * FROM users WHERE loginhash = :hash");
            $sql->bindValue(":hash", $_SESSION['chatHashLogin']);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch();
                $this->uId = $sql['Id'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
    public function validateUsername($u)
    {
        if (preg_match('/^[a-z0-9]+$/', $u)) {
            return true;
        } else {
            return false;
        }
    }
    public function userExists($u)
    {
        $sql = $this->db->prepare("SELECT * FROM users WHERE username = :u ");
        $sql->bindValue(":u", $u);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function registerUser($u, $p)
    {
        $newPass = password_hash($p, PASSWORD_DEFAULT);
        $sql = $this->db->prepare("INSERT INTO users(username, pass) VALUES(:u, :p)");
        $sql->bindValue(":u", $u);
        $sql->bindValue(":p", $newPass);
        $sql->execute();

    }
    public function validateUser($u, $p)
    {
        $sql = $this->db->prepare("SELECT * FROM users WHERE username = :u");
        $sql->bindValue(":u", $u);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            if (password_verify($p, $sql['pass'])) {
                $lHash = md5(rand(0, 99999) . time() . $sql['Id'] . $sql['username']);

                $this->setLoginHash($sql['Id'], $lHash);
                $_SESSION['chatHashLogin'] = $lHash;

                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
    public function clearLoginHash()
    {
        unset($_SESSION['chatHashLogin']);
    }

    private function setLoginHash($id, $hash)
    {
        $sql = $this->db->prepare("UPDATE users SET loginhash = :h WHERE Id = :id");
        $sql->bindValue(":h", $hash);
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function getId()
    {
        return $this->uId;
    }
    public function getName()
    {
        $name = "";
        $sql = $this->db->prepare("SELECT username FROM users WHERE Id = :id");
        $sql->bindValue(":id", $this->getId());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $name = $sql['username'];
        }

        return $name;
    }
    public function updateGroups($groups)
    {
        $groupsString = '';
        if (count($groups) > 0) {
            $groupsString = "!" . implode("!", $groups) . "!";
        }
        $sql = $this->db->prepare("UPDATE users SET last_update = NOW(), groups = :g WHERE Id = :id");
        $sql->bindValue(":id", $this->getId());
        $sql->bindValue(":g", $groupsString);
        $sql->execute();
    }
    public function clearGroups()
    {
        $sql = $this->db->query("UPDATE users SET groups = '' WHERE last_update < DATE_ADD(NOW(), INTERVAL -2 MINUTE)");
    }

    public function getUsersInGroup($g)
    {
        $retorno = [];
        $sql = $this->db->prepare("SELECT username FROM users WHERE groups LIKE :g");
        $sql->bindValue(":g", "%!" . $g . "!%");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetchAll();
            foreach ($sql as $item) {
                $retorno[] = $item['username'];
            }
        }
        return $retorno;
    }

    public function getCurrentGroups()
    {
        $array = [];
        $sql = $this->db->prepare("SELECT groups FROM users WHERE Id = :id");
        $sql->bindValue(":id", $this->getId());
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $array = explode("!", $sql['groups']);

            if (count($array) > 0) {
                array_pop($array);
                array_shift($array);
                
                $g = new Groups();
                $array = $g->getNamesByArray($array);
            }

        }
        return $array;
    }

}
