<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>E-TİCARET</h1>
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
$title=$_POST['title'];
$description=$_POST['description'];
$image='images/'.$_FILES['images']['name'];
$price=$_POST['price'];
$adddate=date('Y-m-d H:i:s');
$statu=$_POST['statu'][0];
$image_tmp=$_FILES['images']['tmp_name'];
if (file_exists($image)) {
print '<div class="alert alert-danger">Resim eklemeniz gerek // Aynı isimde dosya mevcut</div>';
}else {
move_uploaded_file($image_tmp, $image);
$sql="INSERT INTO qp_ecommerce(title, description, image, price, adddate, statu, user_id) VALUES (?,?,?,?,?,?,?)";
$args=[$title,$description,$image,$price,$adddate,$statu, $user_id];
$args=$adminclass->getSecurity($args);
$query=$adminclass->pdoPrepare($sql,$args);

if ($query) {
print '<div class="alert alert-success">İşlem Başarılı...</div>';
header("refresh:1;url=eticaret") ;
}else{ print '<div class="alert alert-danger">İşlem Başarışız...</div>';}
}
}
} 
?>


<div class="card card-secondary">
<div class="card-header">
<h3 class="card-title">Yeni Paket Ekle</h3>
</div>
<!-- /.card-header -->
<!-- form start -->
<form method="post" enctype="multipart/form-data">
<div class="card-body">
<div class="form-group">
<label >Paket Adı</label>
<input type="text" class="form-control" name="title" placeholder="Başlık giriniz...">
</div>
<div class="form-group">
<label >Paket Özellikleri</label>
<textarea rows="3" class="form-control" name="description" placeholder="Açıklama giriniz..."></textarea>
</div>
<div class="form-group">
<label >Fiyat</label>
<input type="text" name="price" class="form-control">
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
</div>
</div>
<!-- /.card-body -->
<input type="hidden" name="save" value="1001">
<div class="card-footer">
<button type="submit" class="btn btn-success">Kaydet</button>
</div>
</form>
</div>
<!-- /.card -->

<!-- /.tablo -->
<div class="card">
<div class="card-header">
<h3 class="card-title">Paket Listesi</h3>
</div>
<!-- /.card-header -->
<div class="card-body">

<?php 
if (isset($_POST['deleteData'])) {
if ($_POST['deleteData']==1001) {
$deleteData = $_POST['checkbox'];
$deleteData = implode("','", $deleteData);
$sql1001="SELECT * FROM qp_ecommerce WHERE ID IN ('$deleteData')";
$statement=$adminclass->pdoQuery($sql1001);
if ($statement) {
foreach ($statement as $value) {
$unlink=unlink($value['image']);
}
}
$sql = "DELETE FROM qp_ecommerce WHERE ID IN ('$deleteData')";
$query=$adminclass->pdoPrepare($sql);
if ($query) {
print '<div class="alert alert-success">Silme İşlemi Başarılı...</div>';
}else{print '<div class="alert alert-success">Silme İşlemi Başarısız...</div>';}
}
}
?>


<form method="post">
<button type="submit" class="btn btn-danger" onclick=" return confirm('Silmek istiyor musunuz?');">SİL</button>
<input type="hidden" name="deleteData" value="1001">
<table id="example2" class="table table-bordered table-hover">
<thead>
<tr>
<th>Seç</th>
<th>ID</th>
<th>Paket Adı</th>
<th>Paket Özellikleri</th>
<th>Resim</th>
<th>Fiyat</th>
<th>Durum</th>
<th>İşlem</th>
</tr>
</thead>
<tbody>
<?php 
$sql = "SELECT * FROM qp_ecommerce";
$query = $adminclass->pdoQueryObj($sql);
if ($query) {

foreach ($query as $value) {

?>
<tr>
<td style="width: 5px; ">
<input type="checkbox" name="checkbox[]" id="checkbox[]" value="<?php print $value->ID; ?>">
</td>
<td><?php print $value->ID; ?></td>
<td><?php print $value->title; ?></td>
<td><?php print $value->description; ?></td>
<td><img src="<?php print $value->image; ?>" style="width: 100px;"></td>
<td><?php print $value->price; ?></td>
<td><?php print $adminclass->getStatu($value->statu);?></td>  
<td style="width: 20px;">
<a href="./eticaret_edit?id=<?php print $value->ID; ?>" class="btn btn-warning">GÜNCELLE</a>
</td>
</tr>
<?php } } ?>
</tbody>
<tfoot>
	<tr>
<th>Seç</th>
<th>ID</th>
<th>Paket Adı</th>
<th>Paket Özellikleri</th>
<th>Resim</th>
<th>Fiyat</th>
<th>Durum</th>
<th>İşlem</th>
</tr>
</tfoot>
</table>
</form>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
</div>
</section>
</div>


