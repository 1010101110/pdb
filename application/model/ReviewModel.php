<?php

/**
 * This essentially a log of all actions happening on the site.
 */
class ReviewModel
{
    public static function getAllReview()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM reviews";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();    
    }
    
    public static function getFiveReview()
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM reviews ORDER BY created_on DESC LIMIT 5";
        $query = $database->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();    
    }
    
    public static function getReviewOfUser($user_id)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM reviews WHERE created_by = :user_id";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => $user_id));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }

    public static function getReviewsOfVariety($varid)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT * FROM reviews WHERE variety = :varid";
        $query = $database->prepare($sql);
        $query->execute(array(':varid' => $varid));

        // fetchAll() is the PDO method that gets all result rows
        return $query->fetchAll();
    }


    public static function createReview($vid,$taste,$heat,$growth,$desc,$composite)
    {
        if (!isset($vid)) {
            Session::add('feedback_negative', "create Review failed $vid,$taste,$heat,$growth,$desc");
            return false;
        }

	//let guests create reviews
	$user = Session::get('user_id') == null ? 2 : Session::get('user_id');

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO reviews (variety,created_by,taste,heat,growth,description) VALUES (:variety,:by,:taste,:heat,:growth,:desc)";
        $query = $database->prepare($sql);
        $query->execute(array(':variety' => $vid, ':by' => $user,':taste' => $taste,':heat'=>$heat,':growth'=>$growth,':desc'=>$desc));

        if ($query->rowCount() == 1) {
            $id = $database->lastInsertId();
            HistoryModel::createHistory(Config::get('URL').'variety/showVariety/' . $vid,'Review added',$user);
            Session::add('feedback_positive', "created review");
            return $id;
        }

        // default return
        Session::add('feedback_negative', "create Review failed $vid,$taste,$heat,$growth,$desc");
        return false;
    }
    
    public static function deleteReview($rid)
    {
        if (!isset($rid)) {
            Session::add('feedback_negative', "delete Review failed $rid");
            return false;
        }

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "DELETE FROM reviews WHERE ID = :rid";
        $query = $database->prepare($sql);
        $query->execute(array(':rid' => $rid));

        if ($query->rowCount() == 1) {
            HistoryModel::createHistory('','Review deleted');
            Session::add('feedback_positive', "deleted review");
            return true;
        }

        // default return
        Session::add('feedback_negative', "delete Review failed $rid");
        return false;
    }
}
