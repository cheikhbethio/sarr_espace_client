<?php
class Auth{

    private $options =[
        'restriction_msg' => 'Vous n\'êtes pas connecté !!'
    ];
    private $session;

    public function __construct($session, $options = []){
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }


    public function register($db, $username, $password, $email){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(70);
        $isAdmin = false;
        $db->query("insert into users set email =  ?, password =  ?, username =  ?, confirmation_token = ?, isAdmin = ?",
            [   $email,
                $password,
                $username,
                $token,
                $isAdmin]);
        $user_id = $db->lastInsertId();
        mail($email,
            'confirmation de votre compte', "Pour valider votre compte cliquez sur ce lien :
            http://localhost/sarr/restricted/action/confirm.php?id=$user_id&token=$token");
    }
    public function updater($db, $username, $password, $email, $idClient){
        $newPassword = password_hash($password, PASSWORD_BCRYPT);
        $res = $db->query("
          UPDATE users set email=?, username=?, password=? WHERE id=?",
            [   $email,
                $username,
                $newPassword,
                $idClient]);
        mail($email,
        'modification de votre compte',
            "Des  modifications ont été apporté à votre compte. \nVoici vos informations:
            email:$email\nusername:$username\npasseword:$password");
    }
    public function confirm($db, $user_id, $token){
        $req = $db->query('select * from users WHERE id=?', [$user_id]);
        $user = $req->fetch();
        if($user && $user->confirmation_token == $token){
            $db->query('update users set confirmation_token =NULL, confirm_at = NOW() WHERE id = ?', [$user_id]);
            $this->session->write('auth', $user);
            return true;
        }else{
            return false;
        }
    }

    public function restrict(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', $this->options['restriction_msg']);
            theApp::redirect('../action/login.php');
        }
    }
    public function restrictAdmin(){
        if(!$this->session->read('authAdmin')){
            $this->session->setFlash('danger', "Vous n'êtes pas Admin, vous n'avez pas les droits nécessaires");
            theApp::redirect('../action/login.php');
        }
    }
    public function isPermit(){
          return $this->session->read('authAdmin') || $this->session->read('auth');
    }

    public function user(){
        if(!$this->session->read('auth')){
            return null;
        }else{
            return $this->session->read('auth');
        }
    }

    public function connect($user){
        $this->session->write('auth', $user);
    }
    public function connectAdmin($user){
        $this->session->write('authAdmin', $user);
    }
    public function reconnect_from_cookie($db){
        if(isset($_COOKIE['remember']) && !$this->user()){
            $wasConnected = $_COOKIE['remember'];
            $parts = explode('==', $wasConnected);
            $user_id = $parts[0];
            $req = $db->prepare('SELECT * FROM users WHERE id = ?', [$user_id]);
            $user = $req->fetch();
            if($user){
                $expected = $user->id. "==" . $user->remember_token . sha1($user->id, "lesauveur");
                if($expected == $wasConnected) {
                    $this->connect($user);
                    setcookie("remember", $wasConnected, time() + 60*60*24*30);
                }else{
                    setcookie('remember', null, -1);
                }
            }else{
                setcookie('remember', null, -1);
            }
        }
    }
    public function login($db, $username, $password, $remember){
        $req = $db->query("
            SELECT * FROM users
            WHERE (username = :username OR email = :username) AND confirm_at IS NOT NULL", ['username' => $username]
        );
        $user = $req->fetch();
        if($user){
            if(password_verify($password, $user->password)){
                if($user->isAdmin){
                    $this->connectAdmin($user);
                }else{
                    $this->connect($user);
                }
                if($remember){
                    $this->rememberMe($db, $user->id);
                }
                return $user;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function rememberMe($db, $user_id){
        $rememberToken = Str::random(250);
        $db->query('UPDATE users SET remember_token=? WHERE id=?', [$rememberToken, $user_id]);
        setcookie("remember", $user_id . "==" . $rememberToken . sha1($user_id, "lesauveur"), time() + 60*60*24*30);
    }

    public function logout(){
        setcookie('remember', NULL, -1);
        $this->session->delete('auth');
        $this->session->delete('authAdmin');
        Session::getInstance()->setFlash('success', "Vous avez bien été déconnecté au revoir et à bientôt");
    }
    public function resetPassWord($db, $email){
        $req = $db->query("SELECT * FROM users WHERE email = ? AND confirm_at IS NOT NULL", [$_POST['email']]);
        $user = $req->fetch();
        $thisClient = $user->username;
        if($user){
            mail('p.quetard@ecotoit.net', "Demande d'un nouveau mot de passe",
                "Bonjour, \nLe client $thisClient a oublié son mot de passe et en demande un nouveau");
            return $user;
        }else{
            return false;
        }
    }

    public function checkResetToken($db, $id, $token){
        $req = $db->query('SELECT * from users WHERE id=? AND  reset_token=? AND reset_at > DATE_SUB(NOW(), INTERVAL 230 MINUTE)',
            [$id, $token]);
        return $req->fetch();
    }

}