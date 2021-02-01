<?
require_once('database.php');
session_start();

// класс для входа и валидации в админ панель

class Login{

    public function __construct(){

        $this->myAppDB = new Database;
        $this->base = (object) '';
        $this->base->url = "http://".$_SERVER['SERVER_NAME'];
        $this->index();
    }

    public function index(){

        // если пользователь вышел сам

        if(!empty($_GET['status']) && $_GET['status'] == 'logout'){
            session_unset();
            session_destroy();
            $error = 'You have been logged out. Please login again.';
			require_once('admin/templates/loginform.php');
        }

        // если пользователь уже проходил валидацию

        else if(!empty($_SESSION['login']) && $_SESSION['login'] = true){
            header('Location: '.$this->base->url.'/admin/posts.php');
            exit();
        }

        // если пользователь пытается валидироваться 
        else{
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $this->validateDetails();
            }
            else if(!empty($_GET['status']) && $_GET['status'] === 'inactive'){

                session_unset();
				session_destroy();
                $error = 'relog pls';

            }
            require_once 'admin/templates/loginform.php';
        }      
    }

    public function loginSucces(){

        // валидация прошла успешно

        $_SESSION['login'] = true;
	    $_SESSION["timeout"] = time();
        header('Location: http://'.$_SERVER['SERVER_NAME'].'/admin/posts.php');
        return;     
    }
    
    public function loginFail(){
        
    }

    private function validateDetails(){
        
        // admin admin для входа

        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';
            $password = crypt($_POST['password'], $salt);
            $return = array();
            $query = $this->myAppDB->db->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
            try{
                $query->execute(array($_POST['username'], $password));
                for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $value){
                    $return[$i][$key] = $value;
                }
            }
            }
            
            catch(PDOException $e){
                $e->getMessage();
            }
            if(!empty($return) && !empty($return[0])){             
                $this->loginSucces();
            }
            else{
                $error  = $this->loginFail();
            }
        }
    }
  
}