<?php 
class APP_CUSTOM_CITE{
    public static function APA_author($full_name){
        $exp = explode(" ",$full_name);
        $name = '';
        foreach($exp as $key){
            $name .= substr(ucfirst($key),0,1).'.';
        }
        return $name.",";
    }
    public static function MLA_author($full_name){
        return $full_name.",";
    }
    public static function citation_format($format,
            $author,
            $publish_date,
            $title,
            $journal_type,
            $doi_url,
            $volume = null,
            $volume_issue = null,
            $library_name = null,
            $edition = null,
            $publication_place = null,
            $publisher = null,
            $page_num = null
        ){
            $publication = '';
            if($edition != null){$edition = " ".$edition.'.';}
            if($doi_url != null){$doi_url = ".".$doi_url;}
            if($publication_place != null){$publication = " ".$publication_place.':'.$publisher;}

        $name_exp = explode(",",$author);
        $authors = '';
        //AUTHORS FORMAT
        $i = 0;
        $a_count = count($name_exp);
        if($format == 'APA'){
            foreach($name_exp as $key){
                $a_exp = explode("-",$key);
                $fname = self::APA_author($a_exp[0]);
                $lname = $a_exp[1];
                $i += 1;
                if($i == 1){
                    $authors .= $lname.", ".$fname;
                }else{
                    $authors .= " ".$lname.", ".$fname;
                }
            }
        }
        if($format == 'MLA'){
            foreach($name_exp as $key){
                $a_exp = explode("-",$key);
                $fname = $a_exp[0];
                $lname = $a_exp[1];
                $i += 1;
                if($i == $a_count){
                    $authors .= "and ".$fname." ".$lname.". ";
                }else if($i == 1){
                    $authors .= $fname." ".$lname.", ";
                }else{
                    $authors .= " ".$fname." ".$lname.",";
                }
                
            }
        }
        if($format == 'Chicago'){
            foreach($name_exp as $key){
                $a_exp = explode("-",$key);
                $fname = $a_exp[0];
                $lname = $a_exp[1];
                $i += 1;
                if($i == $a_count){
                    $authors .= " and ".$lname.", ".$fname.". ";
                }else if($i == 1){
                    $authors .= $lname.", ".$fname;
                }else{
                    $authors .= " ".$lname.", ".$fname;
                }
            }
        }
        if($format == 'Harvard'){
            foreach($name_exp as $key){
                $a_exp = explode("-",$key);
                $fname = $a_exp[0];
                $lname = $a_exp[1];
                $i += 1;
                if($i == $a_count){
                    $authors .= " and ".$fname.". ";
                }else if($i == 1){
                    $authors .= $fname.", ";
                }else{
                    $authors .= " ".$fname.", ";
                }
            }
        }

        if($volume != null) {$volume = $volume.', ';}
        if($volume_issue != null) {$volume_issue = $volume_issue.', ';}
        if($library_name != null) {$library_name = $library_name.', ';}
        $page_num_s = '';
        if($page_num != null) {$page_num_s = $page_num;}

        if($format == 'APA'){
            //$return = $authors.'('.$publish_date.').'.$title.'.<i>'.$journal_type.'</i>.'.$doi_url;

            $return = self::cite_format_apa($_POST['cite_for']);
        }
        if($format == 'MLA'){
            $return = $authors.'“'.$title.'” <i>'.$journal_type.'</i>, '.$volume.$volume_issue.$publish_date.', '.$library_name.$doi_url;
        }
        if($format == 'Chicago'){
            $return = $authors.'<i>'.$title.':'.$journal_type.'</i>.'.$edition.$publication.','.$publish_date.$doi_url;
        }
        if($format == 'Harvard'){
            //Mitchell, J.A. ‘How citation changed the research world’, The Mendeley, 62(9), p70-81.
            $return = $authors."'".$title."', <i>".$journal_type.'</i>,'.$volume.$page_num;
        }
        return $return;
    }
    //APP_CUSTOM_CITE::citation_format($_POST['format'],$_POST['author'],$_POST['publish_date'],$_POST['title'],$_POST['journal_type'],$_POST['doi_url']);
    // APA FORMAT
    public static function cite_format_apa($cite_for){
        $return = '';
        if($cite_for == 'journal'){
            $return = $authors.'('.$publish_date.').'.$title.'.<i>'.$journal_type.'</i>.'.$doi_url;
        }
        if($cite_for == 'website'){
            $return = $authors.'('.$publish_date.').'.$title.'.<i>'.$journal_type.'</i>.'.$doi_url;
        }
        if($cite_for == 'book'){
            $return = $authors.'('.$publish_date.').'.$title.'.<i>'.$journal_type.'</i>.'.$doi_url;
        }
        echo $return;
    }
}
?>