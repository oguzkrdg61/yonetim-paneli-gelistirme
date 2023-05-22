<?php 
//bağlantı
class AdminUsersClass{
 protected $pdo=null;
 protected $host='localhost';
 protected $dbname='yonetimpaneli';
 protected $username='root';
 protected $password='herkesler12';
 protected $charset = 'utf8';
//db ile bağlantı
 public function __construct(){
    try{
      $this->pdo=new pdo("mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset", $this->username, $this->password);
   }catch(PDOException $error){
     die($error->getMessage());
  }
  if (isset($_SESSION['mail']) && isset($_SESSION['login'])) {
      header('location: ./index.php');
  }
}
public function getUser($mail){
   $query = $this->pdo->prepare('SELECT * FROM qp_users WHERE mail=?');
   $query->execute([$mail]);
   $variable=$query->fetch(PDO::FETCH_ASSOC);
   if ($variable) {
      return $variable;
   }else{return false;}
} 


// form doldurma güvenlik önemleri
public function getSecurity($data)
{
   if (is_array($data)) {
      $variable = array_map('htmlspecialchars',$data);
      $response = array_map('stripcslashes',$variable);
      return $response;
   }else{
      $variable=htmlspecialchars($data);
      $response=stripcslashes($variable);
      return $response;
   }
}
}
?>
