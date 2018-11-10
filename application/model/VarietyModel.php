<?php

/**
 * SpeciesModel
 * database access for species table.
 */
class VarietyModel
{
    public static function getAllVarieties()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM varieties ORDER BY name asc";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }
    
    public static function getVarietiesBySpecies($specid)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM varieties where species = :specid ORDER BY name asc";
        $query = $database->prepare($sql);
        $query->execute(array(':specid' => $specid));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }    
    
    public static function getVariety($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        if(is_numeric($id))
        {
            $sql = "SELECT * FROM varieties WHERE ID = :ID LIMIT 1";
        }
        else {
            //try to get the name..
            $id = self::seoUrl($id);
            $sql = "SELECT * FROM varieties WHERE name = :ID LIMIT 1";
        }
        
        $query = $database->prepare($sql);
        $query->execute(array(':ID' => $id));

        // fetch() is the PDO method that gets a single result
        if($query->rowCount() > 0)
            return $query->fetch();
        else
            return null;
    }
    
    public static function getVarietyName($id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT name FROM varieties WHERE ID = :ID LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':ID' => $id));

        // fetch() is the PDO method that gets a single result
        if($query->rowCount() > 0) {
            $result = $query->fetch();
            return $result->name;
        }
        else
            return null;
    }    
    
    public static function updateVariety($id,$name,$Species,$Heat,$PodSize,$PodColor,$PlantColor,$Maturity,$Origin,$Accession,$desc)
    {
        //add all fields
        if(self::doesNameAlreadyExist($name,$id))
        {
            Session::add('feedback_negative', "Another Species with that name already exists");
            return false; 
        }
        
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("UPDATE varieties SET name = :name, species = :species, heat = :heat, podsize = :pods, podcolor = :podc,plantcolor = :plantc, maturity = :mat, origin = :origin,accession = :acc, description = :desc  WHERE ID = :vid LIMIT 1");
        $query->execute(array(':vid' => $id,':name'=>$name,':species'=>$Species,':heat'=>$Heat,':pods'=>$PodSize,':podc'=>$PodColor,':plantc'=>$PlantColor,':mat'=>$Maturity,':origin'=>$Origin,':acc'=>$Accession,':desc' => $desc));
        $count = $query->rowCount();
        if ($count == 1) {
            HistoryModel::createHistory('variety/showVariety/'.$id,'updated ' . $name);
            Session::add('feedback_positive', "Variety Updated");
            return true;
        }
        return false;
    }
    
    public static function addVariety($name,$Species,$Heat,$PodSize,$PodColor,$PlantColor,$Maturity,$Origin,$Accession,$desc)
    {
        //Session::add('feedback_negative', "values" . $name . $Species . $Heat);
        
        if(self::doesNameAlreadyExist($name))
        {
           Session::add('feedback_negative', "Another Variety with that name already exists, edit it");
           return false; 
        }
        
        $database = DatabaseFactory::getFactory()->getConnection();
        $query = $database->prepare("INSERT INTO varieties SET name = :name, species = :species, heat = :heat, podsize = :pods, podcolor = :podc,plantcolor = :plantc, maturity = :mat, origin = :origin,accession = :acc, description = :desc");
        $query->execute(array(':name'=>$name,':species'=>$Species,':heat'=>$Heat,':pods'=>$PodSize,':podc'=>$PodColor,':plantc'=>$PlantColor,':mat'=>$Maturity,':origin'=>$Origin,':acc'=>$Accession,':desc' => $desc));
        $count = $query->rowCount();
        if ($count == 1) {
            $id = $database->lastInsertId();
            HistoryModel::createHistory('variety/showVariety/'.$id,'added '.$name);
            Session::add('feedback_positive', "Variety Added");
            return $id;
        }
        else
        {
            //Session::add('feedback_negative', "failed saving variety");
            return false;
        }
    }
    
    public static function doesNameAlreadyExist($name,$sid=null)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
        if($sid == null){
            $query = $database->prepare("SELECT name FROM varieties WHERE name = :name LIMIT 1");
            $query->execute(array(':name' => $name));
            if ($query->rowCount() == 0) {
            return false;
        }
        return true;
        }
        else{
            $query = $database->prepare("SELECT name FROM varieties WHERE name = :name AND id != :sid LIMIT 1");
            $query->execute(array(':name' => $name,':sid' => $sid));
            if ($query->rowCount() == 0) {
            return false;
        }
        return true;
        }
    }
    
    public static function seoUrl($string) {
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[-]/", " ", $string);
        return $string;
    }

    public static function search($param) {
	$database = DatabaseFactory::getFactory()->getConnection();
        if($param!= null){
            $query = $database->prepare("SELECT name FROM varieties WHERE (name LIKE :param ) OR (heat LIKE :param )");
            $query->execute(array(':param' => '%'.$param.'%'));
            return $query->fetchAll();
        }else{
            return false;
        }        
    }
}
