<?php
class Messages extends Model
{
    public function add($uId, $idGroup, $msg, $mType = "text")
    {
        $sql = $this->db->prepare("INSERT INTO messages(id_user, id_group, date_msg, msg, msg_type) VALUES(:u, :g, NOW(), :msg, :mType)");
        $sql->bindValue(":u", $uId);
        $sql->bindValue(":g", $idGroup);
        $sql->bindValue(":msg", $msg);
        $sql->bindValue(":mType", $mType);
        $sql->execute();
    }

    public function get($lastTime, $groups)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT username FROM users WHERE users.Id = messages.id_user) as username FROM messages WHERE date_msg > :lT AND id_group IN(" . implode(",", $groups) . ")");
        $sql->bindValue(":lT", $lastTime);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

}
