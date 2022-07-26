<?php 
class APP_INTI_FUNC{
    public static function addDays(string $oldDate, string $days){
        if($oldDate == 'today'){
            $oldDate   = date("Y-m-d");
        }
        return date("Y-m-d", strtotime($oldDate.'+ '.$days.' days'));
    }
    // echo APP_INTI_FUNC::addDays('today','2');
    // echo APP_INTI_FUNC::addDays('2022-01-01','2');

    public static function dateDiffer($date1, $date2) 
    {
        if($date1 == 'today'){
            $date1   = date("d-m-Y");
        }
        if($date2 == 'today'){
            $date2   = date("d-m-Y");
        }
        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
    
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return round($diff / 86400);
    }
    // echo APP_INTI_FUNC::dateDiffer('today','01-02-2022');
    // echo APP_INTI_FUNC::dateDiffer('01-02-2022','today');

    public static function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        // Declare an empty array
        $array = array();
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
        // Return the array elements
        return $array;
    }
    // $Date = APP_INTI_FUNC::getDatesFromRange('2010-10-01', '2010-11-05');
    // foreach($Date as $key){
    //     echo $key . '<br/>';
    // }

    public static function get_meta_web($query,$url){
        $metas = get_meta_tags($url);
        return $metas[$query];
    }
    //echo get_meta_web('description',"https://www.w3schools.com/");
    //description, keywords, rating

    public static function getTitle($url) {
        $page = file_get_contents($url);
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
        return $title;
    }
    // echo 'Title: ' . getTitle("https://www.w3schools.com/");

}
?>