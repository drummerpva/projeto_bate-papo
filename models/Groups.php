<?php
class Groups extends Model
{
    public function getList()
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM groups ORDER BY name ASC");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }
    public function add($name)
    {
        $sql = $this->db->prepare("INSERT INTO groups(name) VALUES(:n)");
        $sql->bindValue(":n", $name);
        $sql->execute();
    }
    public function getNamesByArray($g)
    {
        $array = [];
        $sql = $this->db->query("SELECT Id, name FROM groups WHERE Id IN(" . implode(",", $g) . ")");
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }
}
