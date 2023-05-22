<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>REFERANSI GÜNCELLE</h1>
</div>
</div>
</div>
</section>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="row">
<!-- left column -->
<div class="col-sm-12">
<?php 
if (isset($_POST['save'])) {
if ($_POST['save']==1001) {
$ID=$_POST['ID'];
$title=$_POST['title'];
$description=$_POST['description'];
$adddate=date('Y-m-d H:i:s');
$statu=$_POST['statu'][0];
$image="images/".$_FILES['images']['name'];
$image_tmp=$_FILES['images']['tmp_name'];

if ($image_tmp !='') {
if (file_exists($image)) {
print '<div class="alert alert-danger">Aynı isimde dosya mevcut</div>';
}else{
	$sql="SELECT image FROM qp_references WHERE ID={$ID}";
$query=$adminclass->pdoQuery($sql);
if ($query) {
$delete_image=$query[0]['image'];
unlink($delete_image);
}
move_uploaded_file($image_tmp, $image);
$sql="UPDATE qp_references SET title=?, description=?, adddate=?, user_id=?, statu=? image=? WHERE ID=?";
$args=[$title,$description,$adddate,$user_id,$statu, $image, $ID];
$args=$adminclass->getSecurity($args);
$query=$adminclass->pdoPrepare($sql,$args);
if ($query) {
print '<div class="alert alert-success">Resim güncellendi...</div>';
header("location: ./referanslar") ;
}else{ print '<div class="alert alert-danger">Resim güncellenemedi...</div>';}

}  }


$sql="UPDATE qp_references SET title=?, description=?, adddate=?, user_id=?, statu=? WHERE ID=?";
$args=[$title,$description,$adddate,$user_id,$statu,$ID];
$args=$adminclass->getSecurity($args);
$query=$adminclass->pdoPrepare($sql,$args);
if ($query) {
print '<div class="alert alert-success">İşlem Başarılı...</div>';
header("location: ./referanslar") ;
}else{ print '<div class="alert alert-danger">İşlem Başarışız...</div>';}
}
} 


if (isset($_GET['id'])) {
$ID=$adminclass->getSecurity($_GET['id']);

?>
<div class="card card-secondary">
<div class="card-header">
<h3 class="card-title">Referans Güncelle</h3>
</div>
<!-- /.card-header -->

<!-- form start -->
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="ID" value="<?php print $ID; ?>">
<?php 
$sql="SELECT * FROM qp_references WHERE ID={$ID}";
$query=$adminclass->pdoQuery($sql);
if ($query) {

?>
<div class="card-body">
<div class="form-group">
<label >Başlık</label>
<input type="text" class="form-control" name="title" value="<?php echo $query[0]['title']; ?>" placeholder="Başlık giriniz...">
</div>
<div class="form-group">
<label >Açıklama</label>
<textarea rows="3" class="form-control" name="description" placeholder="Açıklama giriniz..."><?php  echo $query[0]['description']; ?></textarea>
</div>
<div class="form-group">
<label>Durum</label>
<select name="statu[]" class="form-control">
<option value="1">Aktif</option>
<option value="2">Pasif</option>
</select>
</div>
<div class="form-group">
<label for="exampleInputFile">Resim/Fotoğraf</label>
<div class="input-group">
<div class="custom-file">
<input type="file" name="images" >
</div>
</div>
<img style="width: 200px;" src="<?php echo $query[0]['image']; ?>" alt="">
</div>
</div>
<?php  } } ?>
<!-- /.card-body -->
<input type="hidden" name="save" value="1001">
<div class="card-footer">
<button type="submit" class="btn btn-success">Güncelle</button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
</div>
</div>


