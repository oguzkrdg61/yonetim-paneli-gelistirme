<?php 
//bağlantı
class AdminClass{
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
  if (!isset($_SESSION['mail']) && !isset($_SESSION['login'])) {
      header('location: ./login.php');
  }
}

// durum için aktif pasif
public function getStatu($data){
   switch ($data) {
      case '1':
         return 'Aktif';
         break;
      case '2':
         return 'Pasif';
         break;
      default:
         return 'Belirsiz';
         break;
   }
}
//fonksiyonu kendi içinde çağırma, child category listeleme
public function getCategories($categoryList, $parent =0){
$data = [];
foreach ($categoryList as $category) {
  if ($category->parent_id == $parent) {
     $childCategory = $this->getCategories($categoryList, $category->ID);
     if ($childCategory) {
        $category->child=$childCategory;
     }
     $data[]= $category;
  }
}
return $data;
}


//query yoluyla
public function pdoQueryObj($sql){
$query= $this ->pdo->query($sql,PDO::FETCH_OBJ)->fetchAll();
if ($query) {
   return $query;
}else{
   return false;
}
}


//query yoluyla
public function pdoQuery($sql){
$query= $this ->pdo->query($sql,PDO::FETCH_ASSOC)->fetchAll();
if ($query) {
   return $query;
}else{
   return false;
}
}

//   veri ekleme
public function pdoInsert($sql,$args){
   $statement = $this->pdo->prepare($sql);
   $response = $statement->execute($args);
   if ($response) {
      return '<div class="alert alert-success text-center">İŞLEM BAŞARILI</div>';
   }else{
      return'<div class="alert alert-danger text-center">İŞLEM BAŞARISIZ</div>';
   }
}
//   veri güncelleme
public function pdoPrepare($sql, $args = []){
   $statement = $this->pdo->prepare($sql);
   $response = $statement->execute($args);
   if ($response) {
      return $response;
   }else{
      return false;
   }
}


//   veri silme
public function pdoDelete($sql,$args)
{
   $statement = $this->pdo->prepare($sql);
   $response = $statement->execute($args);
    if ($response) {
      return '<div class="alert alert-success text-center">İŞLEM BAŞARILI</div>';
   }else{
      return'<div class="alert alert-danger text-center">İŞLEM BAŞARISIZ</div>';
   }
}


public function getAbout(){
   $sql = $this->pdo->query("SELECT * FROM qp_about ORDER BY ID ASC",PDO::FETCH_ASSOC)->fetchAll();

   if ($sql) {
      return $sql;
   }else{
      return false;
   }
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
