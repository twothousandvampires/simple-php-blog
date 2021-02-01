<?
session_start();

require_once('database.php');

// класс администрирования

class Adminpanel{
 
    public function __construct(){
        $inactive = 600;
			if (isset($_SESSION["login"])) {
			    $sessionTTL = time() - $_SESSION["timeout"];
			    if ($sessionTTL > $inactive) {
			    	session_unset();
			        session_destroy();
			        header("Location: http://".$_SERVER['SERVER_NAME']."/login.php?status=inactive");
			    }
			}
			$_SESSION["timeout"] = time();
			$login = $_SESSION['login'];
			if(empty($login)){
				session_unset();
				session_destroy();
				header('Location: http://'.$_SERVER['SERVER_NAME'].'/login.php?status=loggedout');
			}else{
				$this->myAppDB = new Database;
				$this->base = (object) '';
				$this->base->url = 'http://'.$_SERVER['SERVER_NAME'];
			}
    }
}

class Posts extends Adminpanel{

    public function __construct(){
        parent::__construct();
        if(!empty($_GET['action'])){
            switch ($_GET['action']){
                case 'create':
                    $this->addPost();
                    break;
                default:
                    $this->listPosts();
                    break;
                case 'save':
                    $this->savePost();
                    break;
                case 'edit':
                    $this->editPost($_GET['id']);
                    break;
                case 'delete':
                    $this->deletePost($_GET['id']);
                    break;
            }
        }else{
            $this->listPosts();
        }
    }

    // вывод всех постов

    public function listPosts(){
        
            $posts = $return = array();
            $query = $this->myAppDB->db->prepare("SELECT * FROM posts");
            try{
                $query->execute();
                    for ($i = 0; $row = $query->fetch(); $i++) {
                        $return[$i] = array();
                        foreach ($row as $key => $rowitem) {
                            $return[$i][$key] = $rowitem;
                        }
                    }
            } 
            catch (PDOException $e) {
                echo $e->getMessage();
            }
            $posts = $return;
            require_once 'templates/manageposts.php';      
    }

    // редактирование поста

    public function editPost($postId){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $query = $this->myAppDB->db->prepare("UPDATE posts SET title=:title, content=:content WHERE id=:id");
            $query->execute(array(
                "id" => $_POST['id'],
                "title" => $_POST['title'],
                "content" => $_POST['content'],
            ));
            header("Location: ".$this->base->url."/admin/posts.php");
        }
        else{
            $query = $this->myAppDB->db->prepare("SELECT * FROM posts WHERE id =:id");
            $query ->execute(array(
            'id'=>$postId
            ));
            $post = $query->fetch(PDO::FETCH_ASSOC);
            require_once 'templates/editpost.php';
        }        
    }

    // добавленеи поста

    public function addPost(){
        require_once 'templates/newpost.php';
    }

    // сохранение поста

    public function savePost(){
            $content = $title = '';
			if(!empty($_POST['content'])){
				$content = $_POST['content'];
			}
			if(!empty($_POST['title'])){
				$title = $_POST['title'];
			}		
			try {
                $SQLquery = $this->myAppDB->db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");              
                $SQLquery->execute(array(
                    ':title' => $title,
                    ':content' => $content
                ));
                $SQLquery->closeCursor();               
			}catch (PDOException $e) {
				echo $e->getMessage();
			}			
			header("Location: ".$this->base->url."/admin/posts.php?status=".$key);
    }

    // удаление поста

    public function deletePost($postId){
            try{
                $query = $this->myAppDB->db->prepare("DELETE FROM posts WHERE id = $postId");
                $query->execute();     
                $query = $this->myAppDB->db->prepare("DELETE FROM comments WHERE postid = $postId");
                $query->execute(); 
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }          
            header("Location: ".$this->base->url."/admin/posts.php");
    }
}

// класс для работы с комментариями

class Comments extends Adminpanel{

    public function __construct(){
        parent::__construct();
        if(!empty($_GET['action']) && $_GET['action'] == 'delete'){
            $this->deleteComment();
        }else{
            $this->listComments();
        }
    }

    public function listComments(){
        $comments = $return = array();
		$query = $this->myAppDB->db->prepare("SELECT * FROM comments");
		try {
			$query->execute();
			for($i=0; $row = $query->fetch(); $i++){
				$return[$i] = array();
				foreach($row as $key => $rowitem){
					$return[$i][$key] = $rowitem;
				}
			}
        }
        catch (PDOException $e) {
			echo $e->getMessage();
		}
		$comments = $return;
		require_once('templates/managecomments.php');
    }

    public function deleteComment(){
        if(!empty($_GET['id']) && is_numeric($_GET['id'])){
            $query = $this->myAppDB->db->prepare("DELETE FROM `comments` WHERE id = ".$_GET['id']);
            $query->execute();
        }
        header("Location: ".$this->base->url."/admin/comments.php");
    }
}