<?php
include_once (dirname(__FILE__) . '/../../library/Controler.php');
class ArticleController extends Controler{
	public $article;
	public $comments;
	public $articlePager;
	public $lastArticle;
	public $nextArticle;
	public function __construct() {
		parent :: __construct();
		if (!$this->url_ok()){
			$this->errorPage();
		}
		$this->make_header();
		$this->managePost();
		$this->comments = $this->getCommentsByArticleId($this->article['id']);
		$this->articlePager = $this->pageArticleById($this->article['id']);
		for ($i=0;$i<5;$i++){
			if($this->articlePager[$i]['id']==$this->article['id']){$pos = $i;break;}
		}
		$this->lastArticle['id'] = $pos>1?$this->articlePager[$pos-1]['id']:$this->articlePager[0]['id'];
		$this->nextArticle['id'] = $pos<3?$this->articlePager[$pos+1]['id']:$this->articlePager[4]['id'];
		$this->lastArticle['title'] = $pos>1?$this->articlePager[$pos-1]['title']:$this->articlePager[0]['title'];
		$this->nextArticle['title'] = $pos<3?$this->articlePager[$pos+1]['title']:$this->articlePager[4]['title'];
	}
	function url_ok() {
			// /deals/12345-i-love-you.html
			$this->uri = explode("/",$this->uri);
			if (count($this->uri)!=3||$this->uri[1]!='deals'){return false;}
			$this->uri = explode(".",$this->uri[2]);
			if (count($this->uri)!=2||$this->uri[1]!='html'){return false;}
			$this->uri = explode("-",$this->uri[0]);
			if (!is_numeric($this->uri[0])){return false;}
			$sql = "select * from content where id=".$this->uri[0]." and display=1 limit 1";
			if (!($this->article = $this->db->fetch_array($this->db->query($sql)))){return false;}
			return true;
		}

	function managePost(){
		if (!isset($_POST['submit'])){return false;}
		$ip = addslashes($_SERVER['REMOTE_ADDR']);
		$sql = "select id from iplist where ip='$ip' limit 1"; //禁止ip表
		if ($this->db->fetch_array($this->db->query($sql))){return false;}
		$sql = "select create_at from comment where now()-create_at<15 and ip='$ip' order by id desc limit 1"; //防止连续灌水
		if ($this->db->fetch_array($this->db->query($sql))){return false;}

		$content_id = $this->article['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$body = $_POST['body'];
		$name = addslashes(strip_tags($name));
		$email = addslashes(strip_tags($email));
		$body = addslashes(strip_tags($body));
		if($name == ""){$name = 'Anonymous';}
		if($body == ""||strlen($body)>300||strlen($name)>25||strlen($email)>50){return false;}
		$sql = "insert into comment (content_id,ip,name,email,body) values ($content_id,'$ip','$name','$email','$body')";
		$this->db->query($sql);
	}

	function getCommentsByArticleId($articleId){
		$sql = "select * from comment where content_id=$articleId order by id asc";
		return $this->db->fetch_to_array($sql);
	}

	function make_header() {
		$this->header['title'] = $this->article['title'].' | DealForGirl';
		$this->header['description'] = $this->article['title'];
		$this->header['keywords'] = $this->article['title'];
		$this->header['css_array'][] = "/public/styles/reset.css";
		$this->header['css_array'][] = "/public/styles/global.css";
		$this->header['css_array'][] = "/public/styles/article.css";
	}

	function pageArticleById($articleId){
		$articleArray = array();
		$sql = "select * from content where id>$articleId and display=1 order by id asc limit 4";
		$previousArticle = $this->db->fetch_to_array($sql);
		$numPreviousArticle = count($previousArticle);
		$sql = "select * from content where id=$articleId limit 1";
		$currentArticle = $this->db->fetch_to_array($sql);
		$sql = "select * from content where id<$articleId and display=1 order by id desc limit 4";
		$laterArticle = $this->db->fetch_to_array($sql);
		$numLaterArticle = count($laterArticle);
		if($numPreviousArticle>=2&&$numLaterArticle>=2){
			for($i=1;$i>=0;$i--){
				$articleArray[] = $previousArticle[$i];
			}
			$articleArray[] = $currentArticle[0];
			for($i=0;$i<=1;$i++){
				$articleArray[] = $laterArticle[$i];
			}
		}
		else{
			if ($numPreviousArticle<2){
				for($i=$numPreviousArticle-1;$i>=0;$i--){
					$articleArray[] = $previousArticle[$i];
				}
				$articleArray[] = $currentArticle[0];
				for($i=0;$i<=3-$numPreviousArticle;$i++){
					$articleArray[] = $laterArticle[$i];
				}
			}
			else{
				for($i=3-$numLaterArticle;$i>=0;$i--){
					$articleArray[] = $previousArticle[$i];
				}
				$articleArray[] = $currentArticle[0];
				for($i=0;$i<=$numLaterArticle-1;$i++){
					$articleArray[] = $laterArticle[$i];
				}
			}
		}
		return $articleArray;
	}

}
?>
