<?php
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;

class HistoryController extends BaseController {


	public function getHistory()
	{
    if(Auth::check()){
      $query = new ParseQuery("Trip");
      $parseUser1 = ParseUser::getCurrentUser();
      var_dump($parseUser1);
      $query->equalTo("user", $parseUser1 );
      $results = $query->find();
      echo "Successfully retrieved " . count($results) . " scores.";
      // Do something with the returned ParseObject values
      for ($i = 0; $i < count($results); $i++) {
        $object = $results[$i];
        echo $object->getObjectId() . ' - ' . $object->get('playerName');
      }

    }
	}


}
