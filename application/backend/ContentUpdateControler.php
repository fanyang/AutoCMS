<?php
include_once (dirname(__FILE__) . '/ManagementControler.php');
class ContentUpdateControler extends ManagementControler{

	public $content;

	public function __construct($backendName) {
		parent :: __construct($backendName);
		if (!($this->is_cookie_auth() && $this->url_ok())) {$this->jump("/$this->backendName");}
		$this->make_header();
		if($this->exec_post()) {$this->jump("/$this->backendName");}
	}

	function url_ok() {
		if (preg_match_all("#^/$this->backendName/content/(\d+)\$#iUs",$this->uri,$arr)) {
			$id = $arr[1][0];
			$sql = "SELECT * FROM content WHERE id=$id";
			if($this->content=$this->db->fetch_array($this->db->query($sql))){return true;}
			else {return false;}

		} else {
			return false;
		}
	}

	function get_deal_url($content_id,$deal_url_id){
		$sql="SELECT * FROM content_link WHERE content_id=$content_id AND link_num=$deal_url_id";
		if ($deal_url_class=$this->db->fetch_array($this->db->query($sql))){
			return $deal_url_class['deal_link'];
		}
		else {return false;}
	}

	function exec_post() {
		if (!(isset ($_POST['submit']) && isset ($_POST['title']) && isset ($_POST['pic']) && isset ($_POST['link'])&& isset ($_POST['body']) && isset ($_POST['display']) )) {
			return false;
		}

		$id = $this->content['id'];
		$title = $this->form_filter_simpletext($this->form_filter_ending_space($_POST['title']));
		$pic = $_POST['pic'];
		$link = $this->form_filter_url($_POST['link']);
		$body = $_POST['body'];
		$display = $_POST['display'];
		if($title==""){$title="New Title";}
		if($pic!=""){$pic=$this->process_thumb_pic($pic);}
		if (!($display==0 || $display==1)){return false;}
		if (strlen($link)>2048) {return false;}

		$this->insert_deal_content_url($id,$_POST['deal_content_url']);

		$title =$this->form_filter_sql($title);
		$sql = "UPDATE content SET title = '$title' where id = $id";
		$this->db->query($sql);
		$pic =$this->form_filter_sql($pic);
		$sql = "UPDATE content SET pic = '$pic' where id = $id";
		$this->db->query($sql);
		$link =$this->form_filter_sql($link);
		$sql = "UPDATE content SET link = '$link' where id = $id";
		$this->db->query($sql);
		$body =$this->form_filter_sql($body);
		$sql = "UPDATE content SET body = '$body' where id = $id";
		$this->db->query($sql);
		$display =$this->form_filter_sql($display);
		$sql = "UPDATE content SET display = '$display' where id = $id";
		$this->db->query($sql);

		return true;
	}

	function process_thumb_pic($pic_url, $limitWidth = 135, $limitHeight = 135) {
		preg_match_all("#<img src=\"(.+)\" (.*)>#iUs",$pic_url,$url);
		$pic_addr_rel=$url[1][0];
		$pic_addr = dirname(__FILE__)."/../..".$pic_addr_rel;
		$img=getimagesize($pic_addr);
		switch($img[2]){
   			case 1:
    		$im = @imagecreatefromgif($pic_addr);
    		$bgcolor = ImageColorAllocate($im,0,0,0);
			$bgcolor = ImageColorTransparent($im,$bgcolor);
   			break;
   			case 2:
    		$im=@imagecreatefromjpeg($pic_addr);
   			break;
   			case 3:
    		$im=@imagecreatefrompng($pic_addr);
    		$bgcolor = ImageColorAllocate($im,0,0,0);
			$bgcolor = ImageColorTransparent($im,$bgcolor);
   			break;
  		}
 	$widthOld = $img[0];
	$widthNew = $img[0];
	$heightOld = $img[1];
	$heightNew = $img[1];
	if ($widthNew > $limitWidth) {
		$heightNew = round($heightNew / ($widthNew / $limitWidth));
		$widthNew = $limitWidth;

	}
	if ($heightNew > $limitHeight) {
		$widthNew = round($widthNew / ($heightNew / $limitHeight));
		$heightNew = $limitHeight;

	}

  		if ($widthOld > $limitWidth || $heightOld > $limitHeight){
  		$newim = imagecreatetruecolor($widthNew, $heightNew);
		imagealphablending($newim,false);
		imagesavealpha($newim,true);
  		imagecopyresampled($newim, $im, 0, 0, 0, 0, $widthNew, $heightNew, $widthOld, $heightOld);
  		switch($img[2]){
   			case 1:
    		imagegif($newim,$pic_addr);
   			break;
   			case 2:
    		imagejpeg($newim,$pic_addr, 100);
   			break;
   			case 3:
    		imagepng($newim,$pic_addr);
   			break;
  		}
  		}

		return $pic_addr_rel;
	}

	function insert_deal_content_url($content_id, $deal_content_url){
		foreach($deal_content_url as $key=>$url){
			$url = $this->form_filter_sql($this->form_filter_ending_space($this->form_filter_url($url)));
			$sql="SELECT * FROM content_link WHERE content_id='$content_id' AND link_num='$key'";
			if ($deal_url_class=$this->db->fetch_array($this->db->query($sql))){
				if($url==""){
					$sql="DELETE FROM content_link WHERE content_id='$content_id' AND link_num='$key'";
				}
				else{
					$sql="UPDATE content_link SET deal_link='$url' WHERE content_id='$content_id' AND link_num='$key'";
				}
				$this->db->query($sql);
			}
			else {
				if($url!=""){
					$sql = "INSERT INTO content_link (content_id, link_num, deal_link) VALUES ('$content_id','$key', '$url')";
					$this->db->query($sql);
				}
			}
		}

	}


}
?>
