<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('genera_calendar'))
{
    function genera_calendar($name, $class="")
    { 
        $return  = '';
        $return .= '<select name="'.$name.'[month]" class="form-control '.$class.'"><option>mm</option>';
        for ($i = 1; $i <= 12; $i++) {
        	$return .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $return .= '</select>';
        $return .= '<select name="'.$name.'[day]" class="form-control '.$class.'"><option>dd</option>';
        for ($i = 1; $i <= 31; $i++) {
        	$return .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $return .= '</select>';
        $return .= '<select name="'.$name.'[year]" class="form-control '.$class.'"><option>yyyy</option>';
        for ($i = intval(date("Y")); $i >= intval(date("Y")) - 80; $i--) {
        	$return .= '<option value="'.$i.'">'.$i.'</option>';
        }
        $return .= '</select>';
        
        return $return;
    }
}

if ( ! function_exists('slugify'))
{
    function slugify($text)
    { 
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
    }
}

if ( ! function_exists('publish_company'))
{
    function publish_company($id, $member_id, $name)
    { 
        if (empty($name)) {$name = 'designwall';}
        return base_url() . "manufacturer/{$member_id}/" . slugify($name) . ".html";
    }
}

if ( ! function_exists('is_member_advertise'))
{
    function is_member_advertise()
    { 
         $CI =& get_instance();
         $CI->load->model('Members_model');
         $is_login = $CI->session->userdata('is_login');
         if ($is_login){
             $user_info = $CI->session->userdata('user_info');
             $member=$CI->Members_model->getById($user_info["id"]);
             if($member['work_ph']!=""){
                return true;
             }else{
                return true;
             }
         }
         else{
            return true;
         }
    }
}


if ( ! function_exists('microsite_company'))
{
    function microsite_company($id, $member_id, $business_type, $name)
    {
        $business_type = strtolower($business_type); 
        if (empty($name)) {$name = 'designwall';}
        return base_url() . "microsite/{$member_id}/{$business_type}/" . slugify($name) . ".html";
    }
}

if ( ! function_exists('rename_file')){
    function rename_file($src,$folder,$name){
        $filePath     = $src;
        $fileObj      = new SplFileObject($filePath);
        $name_flie    = explode("/",$name);
        $RandomNum    = uniqid();
        $ImageName    = str_replace(' ', '-', strtolower($name_flie[(count($name_flie)-1)]));
        $ImageType    = explode(".",$name_flie[(count($name_flie)-1)]);
        $ImageType    = $ImageType[(count($ImageType)-1)];
        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt     = str_replace('.', '', $ImageExt);
        $ImageName    = str_replace("." . $ImageExt, "", $ImageName);
        $ImageName    = preg_replace("/.[[.s]{3,4}$/", "", $ImageName);
        $NewImageName = md5($ImageName).'_'.$RandomNum.'.'.$ImageExt;
        rename($filePath,FCPATH.$folder.$NewImageName);
        return $NewImageName;
    }
}
if ( ! function_exists('crop_image')){
    function crop_image($image,$type,$folder){
        $data=array("status"=>"error",'name'=>'');
        //$folder="/images/avatars/";
        if(isset($_POST['x']) && isset($_POST['y'])){
            $x=intval($_POST['x']);
            $y=intval($_POST['y']);
            $w=intval($_POST['w']);
            $h=intval($_POST['h']);
            $image_w=intval($_POST['image_w']);
            $image_h=intval($_POST['image_h']);
            if($w>0 && $h>0 && $image_w>0 && $image_h>0){
                    $src=".".$folder.$image;
                    $size = getimagesize($src);

                    $w_current = $size[0];
                    $h_current = $size[1];

                    $x *= ($w_current/$image_w);
                    $w *= ($w_current/$image_w);

                    $y *= ($h_current/$image_h);
                    $h *= ($h_current/$image_h);

                    $path = $folder. $image;
                    $dstImg = imagecreatetruecolor($w, $h);
                    $dat = file_get_contents($src);
                    $vImg = imagecreatefromstring($dat);
                    if($type=='png'){                        
                        imagealphablending($dstImg, false);
                        imagesavealpha($dstImg, true);
                        $transparent  = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
                        imagefilledrectangle($dstImg, 0, 0, $w, $h, $transparent);
                        //imagecolortransparent($dstImg, $transparent);
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagepng($dstImg, $src);
                    }
                    else{
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagejpeg($dstImg, $src);
                    }
                    imagedestroy($dstImg);
                    
                    $src=FCPATH .$folder.$image;
                    $name=rename_file($src,$folder,$image);
                    $data['name']=$name;
                    $data["status"]="success";
            }
        }
        return $data;  
    }
}
if (!function_exists('upload_flie')){
    function upload_flie($upload_path,$allowed_types,$file,$max_size = "auto",$max_width="auto",$max_height="auto"){
        $CI = get_instance();
        $data["success"] = "error";
        $data["message"] = "error";
        //config;
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['file_ext_tolower'] = 'TRUE';
        $config['remove_spaces'] = TRUE;
        if($max_size !="auto"){$config['max_size'] = $max_size;}
        if($max_width !="auto"){$config['max_width'] = $max_width;}
        if($max_height !="auto"){$config['max_height'] = $max_height;}
        $type = explode(".", $file['name']);
        $count = count($type) - 1;
        $name = uniqid().".".$type[$count];
        $_FILES['file']['name']     = $name ;
        $_FILES['file']['type']     = $file['type'];
        $_FILES['file']['tmp_name'] = $file['tmp_name'];
        $_FILES['file']['error']    = $file['error'];
        $_FILES['file']['size']     = $file['size'];
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload('file'))
        {
            $data["error"]   = $CI->upload->display_errors();
            $data["message"] = "Upload process an error please check back";
            $data["file"]    = $_FILES["file"];
        }
        else
        {   
            $data["success"] ="success";
            $data["message"] = array('upload_data' => $CI->upload->data());
            $data["reponse"]['name'] = $name ;
        }
        return $data;

    }
}
if (!function_exists('gen_slug')){
    function gen_slug($str){
        $str = ($str == null || trim($str) == "") ? "photo" : $str;
        $a = array("'",'"','À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array("",'','A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str))).".html";
    }
}
if (!function_exists('gen_slug_st')){
    function gen_slug_st($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9,. -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
}
function sendemail_fg($email, $subject, $message, $from){
    $CI = get_instance();
    $CI->load->library('email');
    $CI->email->from('noreply@dezignwall.com', $from);
    $CI->email->to($email);
    $CI->email->set_mailtype("html");
    $CI->email->subject($subject);
    $CI->email->message($message);
    $CI->email->send();
}
function breadcrumb(){
    $url =  "{$_SERVER['REQUEST_URI']}";
    $url = explode("?", $url);
    $url = $url[0];
    $url = str_replace("index.php/", "", $url);
    $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
    $before = strlen($escaped_url) - 1 ;
    $after  = $before + 1;
    if(substr( $escaped_url,$before,$after)=="/"){
        $escaped_url = substr($escaped_url, 0, -1);
    }
    $escaped_url = explode( '/', $escaped_url );
    $html  = "";
    $url_mother = base_url();
    if(is_array($escaped_url)&& count($escaped_url)>2){
        $html = "<ol class='breadcrumb' style='padding-bottom: 0;margin-bottom: 0;'>";
        for($i=0; $i<count($escaped_url) ;$i++){
            if($i>0){
                $url_mother .= $escaped_url[$i]."/";
                $title = str_replace("-"," ",$escaped_url[$i]);
                $title = str_replace("_","/",$title);
                $title = ucwords($title);
                $content = "";
                if($i == (count($escaped_url)-1)){
                    $content = $title;
                    $content = $content == 'Inspiration' ? 'Projects' : $content;
                }else{
                    $content = "<a href='".$url_mother."'>".$title."</a>";
                }
                $html .= "<li>".$content."</li>";
            }
        }    
        $html .="</ol>";
    }
    return $html;
    
}
if ( ! function_exists('paging')) {
    function paging($total_rows,$perpage,$number_itmems = 5,$url ="",$number_page = 20){
        $page = $total_rows/$number_page;
        if($page > 1){
            $page   = (explode(".",$page));
            $page   = (count($page)>1)?$page[0]+1:$page[0];
            if($perpage - 2 < 1 ){$number_page = 1;}else{
                if($page - 1 == $perpage){$number_page = $perpage - 3;}else{$number_page = $perpage - 2;}
            }
            if($number_page + ($number_itmems-1) < $page ){$page_show = $number_page + ($number_itmems-1);}else{$page_show = $page;}
            if($perpage == $page){$number_page = $page - ($number_itmems-1);}
            if($number_page < 1){$number_page = 1;}
            if($page_show > $page){$page_show = $page;}
            $next = $page_show + 3;
            $prev = $page_show - 7;
            $disabled_next ="";
            $disabled_prev ="";
            if($next > $page){$next = $page;}
            if($prev < 1){$prev = 1;$disabled_prev = "class='disabled'";}
            if($perpage + 3 >= $page){$disabled_next = "class='disabled'";}
            $html = '<ul class = "pagination pagination-md">';
            $html .="<li ".$disabled_prev."><a href = '".$url.$prev."'>&laquo;</a></li>";
            $active = "";
            for( $i = $number_page; $i<=$page_show ; $i++ ){
                if($i ==$perpage){
                    $active = 'class ="active"';
                }else{
                    $active = '';
                }
                $html .= "<li ".$active."><a href='".$url.$i."'>".$i."</a></li>";
            }
            $html .= "<li ".$disabled_next."><a href = '".$url.$next."'>&raquo;</a></li>";
            $html .="</ul>";
            return $html;
        }
        return "";
    }
}
function get_notifications($user_id){
    $CI = get_instance();
    $CI->db->select("id");
    $CI->db->from("notifications_common");
    $CI->db->where(["member_id" => $user_id,"status" => 0]);
    $data = $CI->db->count_all_results();
    return $data;
}
function get_notifications_by_user($user_id,$type_object,$type,$offset = 0,$limit = 6){
    $CI = get_instance();
    $CI->db->select("tbl1.*,count(tbl1.id) AS number_data");
    $CI->db->from("notifications_common AS tbl1");
    $CI->db->where([
        "tbl1.member_id" => $user_id,
        "tbl1.type_object" => $type_object,
        "tbl1.type" => $type
    ]);
    $CI->db->group_by("tbl1.reference_id");
    $CI->db->order_by("tbl1.id","DESC");
    $CI->db->limit($limit,$offset);
    $data = $CI->db->get();
    return $data->result_array();
}
function get_notifications_by_type ($user_id,$reference_id,$type_object,$type,$offset = 0,$limit = 2){
    $CI = get_instance();
    $CI->db->select("tbl1.id AS notifications_id,tbl1.type AS typeSuccess,tbl1.member_owner,tbl1.reference_id,tbl1.type_object,tbl1.type,tbl2.avatar,tbl2.first_name,tbl2.last_name,tbl2.job_title,tbl3.company_name,tblcmm1.*");
    $CI->db->from("notifications_common AS tbl1");
    if($type_object == "like")
        $CI->db->join("common_like AS tblcmm","tblcmm.reference_id = tbl1.reference_id"); 
    if($type_object == "comment")
        $CI->db->join("common_comment AS tblcmm","tblcmm.reference_id = tbl1.reference_id");      
    if($type == "photo")
        $CI->db->join("photos AS tblcmm1","tblcmm1.photo_id = tbl1.reference_id");
    if($type == "social")
        $CI->db->join("social_posts AS tblcmm1","tblcmm.id = tbl1.reference_id");
    $CI->db->join("members AS tbl2","tbl2.id = tbl1.member_owner");
    $CI->db->join("company AS tbl3","tbl3.member_id = tbl2.id","LEFT");
    $CI->db->where([
        "tbl1.member_id" => $user_id,
        "tbl1.type_object" => $type_object,
        "tbl1.type" => $type,
        "tbl1.reference_id" => $reference_id,
        "tbl1.allow"   => 1
    ]);
    $CI->db->group_by("tbl1.id");
    $CI->db->limit($limit,$offset);
    $CI->db->order_by("tbl1.id","DESC");
    $data = $CI->db->get();
    return $data->result_array();
}
function get_company_top_follow ($user_id){
    $CI = get_instance();
    $sql = "select tbl3.numberUpload AS number_follow,tbl2.* from common_follow AS tbl1 
    join company as tbl2 on tbl2.id = tbl1.reference_id and tbl1.type_object = 'company'
    join (select count(id) AS numberUpload , member_id,owner_id from tracking_upload_by_member where member_id = $user_id and status = 0 group by owner_id) AS tbl3 on tbl3.owner_id = tbl1.owner_id  
    where tbl1.member_id = $user_id
    group by tbl2.id ORDER BY number_follow DESC LIMIT 8";
    $query = $CI->db->query($sql);
    return $query->result_array();

}

function get_follow_by_user($user_id,$type_object,$type,$offset = 0,$limit = 6){
    $CI = get_instance();
    $CI->db->select("tbl1.*,tbl2.avatar,tbl2.first_name,tbl2.last_name,tbl2.job_title,tbl3.company_name,tbl3.logo");
    $CI->db->from("notifications_common AS tbl1");
    $CI->db->join("members AS tbl2","tbl2.id = tbl1.member_owner");
    $CI->db->join("company AS tbl3","tbl3.member_id = tbl2.id","LEFT");
    $CI->db->where([
        "tbl1.member_id" => $user_id,
        "tbl1.type_object" => $type_object,
        "tbl1.type" => $type,
        "tbl1.allow"   => 0
    ]);

    $CI->db->order_by("tbl1.id","DESC");
    $CI->db->limit($limit,$offset);
    $data = $CI->db->get();
    return $data->result_array();
}
function get_diff_year ($old,$to){
    $d1 = new DateTime($old);
    $d2 = new DateTime($to);
    $diff = $d2->diff($d1);
    $y = $diff->y;
    $m = $diff->m;

    if($m != 0){
        if($y == 0){
            return " &#8226; <span style='color:#7f7f7f'>" . $m . " mos</span>";
        }
        return " &#8226; <span style='color:#7f7f7f'>" .$y." yrs " . $m . " mos</span>";
    }else{
        if($y != 0){
            return " &#8226; <span style='color:#7f7f7f'>" .$y . " yrs<span>";
        }else{
            return "";
        }
        
    }
}
