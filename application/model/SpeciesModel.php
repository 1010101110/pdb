<?php

/**
 * SpeciesModel
 * database access for species table.
 */
class SpeciesModel
{
    public static function getAllSpecies()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM species ORDER BY name asc";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    
    public static function getAllSpeciesNames()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT ID, name FROM species ORDER BY name asc";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    
    
    public static function getSpecies($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM species WHERE ID = :ID LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':ID' => $id));

        // fetch() is the PDO method that gets a single result
        return $query->fetch();
    }
    
    public static function getSpeciesID($name){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT ID FROM species WHERE name = :name LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':name' => $name));

        // fetch() is the PDO method that gets a single result
        return $query->fetchColumn();   
    }
    
    public static function updateSpecies($id,$name,$attr,$desc)
    {
        if(self::doesNameAlreadyExist($name,$id))
        {
            Session::add('feedback_negative', "Another Species with that name already exists");
            return false; 
        }
        
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("UPDATE species SET name = :name, attribute = :attr, description = :desc WHERE ID = :sid LIMIT 1");
        $query->execute(array(':sid' => $id, ':name' => $name, ':attr' => $attr, ':desc' => $desc));
        $count = $query->rowCount();
        if ($count == 1) {
            HistoryModel::createHistory('species/showSpecies/'.$id,'updated ' . $name);
            Session::add('feedback_positive', "Species Updated");
            return true;
        }
        return false;
    }
    
    public static function addSpecies($name,$attr,$desc)
    {
        if(self::doesNameAlreadyExist($name))
        {
           Session::add('feedback_negative', "Another Species with that name already exists, edit it");
           return false; 
        }
        
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("INSERT INTO species SET name = :name, attribute = :attr, description = :desc;");
        $query->execute(array(':name' => $name, ':attr' => $attr, ':desc' => $desc));
        $count = $query->rowCount();
        if ($count == 1) {
            $id = $database->lastInsertId();
            HistoryModel::createHistory('species/showSpecies/'.$id,'added '.$name);
            Session::add('feedback_positive', "Species Added");
            return $id;
        }
        else
        {
            //Session::add('feedback_negative', "failed saving species");
            return false;
        }
    }
    
    public static function doesNameAlreadyExist($name,$sid=null)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        if($sid == null){
            $query = $database->prepare("SELECT name FROM species WHERE name = :name LIMIT 1");
            $query->execute(array(':name' => $name));
            if ($query->rowCount() == 0) {
            return false;
        }
        return true;
        }
        else{
            $query = $database->prepare("SELECT name FROM species WHERE name = :name AND id != :sid LIMIT 1");
            $query->execute(array(':name' => $name,':sid' => $sid));
            if ($query->rowCount() == 0) {
            return false;
        }
        return true;
        }
    }
}