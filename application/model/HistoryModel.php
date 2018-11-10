<?php

/**
 * This essentially a log of all actions happening on the site.
 */
class HistoryModel
{
    public static function getAllHistory()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM history ORDER BY action_on DESC";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();    
    }
    
    public static function getFiveHistory()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM history ORDER BY action_on DESC LIMIT 5";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();    
    }
    
    public static function getHistoryOfUser($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM history WHERE action_by = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    
    public static function getCountOfUserHistory($user_id)
    {
       $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM history WHERE action_by = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->rowCount();
    }

    public static function getHistoryOfUrl($url)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM history WHERE url = :url";
        $query = $database->prepare($sql);
        $query->execute(array(':url' => $url));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }


    public static function createHistory($url,$action,$id=null)
    {
        if (!$action || strlen($action) == 0) {
            Session::add('feedback_negative', "create history failed");
            return false;
        }
        $user = $id != null  ? $id : Session::get('user_id');

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO history (url,action,action_by) VALUES (:url,:action,:action_by)";
        $query = $database->prepare($sql);
        $query->execute(array(':url' => $url, ':action' => $action, ':action_by' => $user));

        if ($query->rowCount() == 1) {
            return true;
        }

        // default return
        Session::add('feedback_negative', "create history failed");
        return false;
    }
}
