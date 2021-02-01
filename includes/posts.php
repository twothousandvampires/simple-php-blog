<?

// подключение дб

require_once('database.php');

// класс прототип

class Blog{

    public $myAppDB = '';
    public $base = '';

    public function __construct(){

        $this->myAppDB = new Database;

        $this->base = new stdClass;

        $this->base->url = "http://".$_SERVER['SERVER_NAME'];

    }

}

// класс для просмотра всех новостей

class Posts extends Blog{

    public function __construct() {

        parent::__construct();

        $this->comments = new Comments();

        // просмотр всех новостей или конкретной при наличии id 

        if(!empty($_GET['id'])){
            $this->viewPosts($_GET['id']);
        }
        else{
            $this->getPosts();
        }

    }

    // вывод всех новостей

    public function getPosts(){

        $id = 0;
        $posts = $return = array();
        $template = '';
        $query = $this->myAppDB->db->prepare("SELECT * FROM posts");
        try{
            $query->execute();
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $value){
                    $return[$i][$key] = $value;
                }
            }
        }
        catch(PDOexception $e){
            echo $e->getMessage();
        }
        $posts = $return;
        foreach($posts as $key => $post){

            // получение количества комментариев для каждого поста

            $posts[$key]['comments'] = $this->comments->NumOfComments($post['id']);
            
		}
        $template = 'list-posts.php';

        // подключение шаблона отображения

        include_once('frontend/templates/'.$template);
    }

    // вывод конкретного поста

    public function viewPosts($postId){

        $id = $postId;
        $posts = $return = array();
        $template = '';
        $query = $this->myAppDB->db->prepare("SELECT * FROM posts WHERE id=?");
        try{
            $query->execute(array($id));
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $value){
                    $return[$i][$key] = $value;
                }
            }
        }
        catch(PDOexception $e){
            echo $e->getMessage();
        }
        $posts[] = $return[0];
        $posts[0]['id'] = $return[0]['id'];

        // получение комментариев для данного поста

        $postComments = $this->comments->getComments($posts[0]['id']);
        $template = 'view-post.php';
        
        // подключение шаблона отображения
        
        include_once('frontend/templates/'.$template);
    }

}

// класс представления комментариев

class Comments extends Blog{

    public function __construct(){

        parent::__construct();
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['context'])){
			$this->addComment();
		}
    }

    public function NumOfComments($postId){

        $return = array();        
		$query = $this->myAppDB->db->prepare("SELECT * FROM comments WHERE postid = $postId");
		try {
			$query->execute();
			for($i=0; $row = $query->fetch(); $i++){
				$return[$i] = array();
				foreach($row as $key => $rowitem){
					$return[$i][$key] = $rowitem;
				}
			}
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
        return count($return);
        
    }

    public function getComments($postId){
        $return = array();
        $query = $this->myAppDB->db->prepare("SELECT * FROM comments WHERE postid = $postId");
        
		try {
			$query->execute();
			for($i=0; $row = $query->fetch(); $i++){
				$return[$i] = array();
				foreach($row as $key => $rowitem){
					$return[$i][$key] = $rowitem;
				}
			}
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
		return $return;
    }

    public function addComment(){

        $status= '';

        $name = $context = $postid = $email = '';
        
		if(!empty($_POST['name'])){
			$name = $_POST['name'];
		}
	
		if(!empty($_POST['context'])){
			$context = $_POST['context'];
        }
        
		if(!empty($_POST['postid'])){
			$postid = $_POST['postid'];
		}
        if(!empty($_POST['email'])){
			$email = $_POST['email'];
		}
        try {

            $SQLquery = $this->myAppDB->db->prepare("INSERT INTO comments (postid ,name, context,email) VALUES (:postid, :name, :context, :email)");
        
            $SQLquery->execute(array(
                ':postid' => $postid,
                ':name' => $name,
                ':context' => $context,
                'email' => $email,
                
            ));
            $SQLquery->closeCursor();               
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
        
		header($this->base->url.'/?id='.$comment['postid']);
    }
}
