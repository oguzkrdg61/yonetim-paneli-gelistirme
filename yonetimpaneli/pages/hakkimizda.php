<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>HAKKIMIZDA</h1>
</div>
<div class="col-sm-6">
</div>
</div>
</div><!-- /.container-fluid -->
</section>
<!-- Main content -->

<!-- Hakkımızda formu için db ye veri gönderme -->
<?php
if(isset($_POST['save'])){
if ($_POST['save']==1001) {
$title = $adminclass->getSecurity($_POST['title']);
$description = $adminclass->getSecurity($_POST['description']);
$adddate= date('Y-m-d H:i:s');
$statu =$adminclass->getSecurity($_POST['statu'][0]);
$sql = "INSERT INTO qp_about(title, description, adddate,user_id, statu) VALUES (?,?,?,?,?) ";
$args = [$title,$description,$adddate,$user_id,$statu];
$result=$adminclass->getSecurity($args);
print $adminclass->pdoInsert($sql,$result);
}
}

//veri güncelleme
if(isset($_POST['update'])){
if ($_POST['update']==1002) {
	$ID=$_POST['ID'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$statu=$_POST['statu'][0];

$sql = "UPDATE qp_about SET title=?,description=?,statu=? WHERE ID =?";
$args=[$title,$description,$statu,$ID];
$args=$adminclass->getSecurity($args);
$variable=$adminclass->pdoPrepare($sql,$args);
if ($variable = 1) {
	print '<div class="alert alert-success text-center">İŞLEM BAŞARILI</div>';
}else{
	print '<div class="alert alert-danger text-center">İŞLEM BAŞARISIZ</div>';
}
}
}

//veri silme
if (isset($_POST['dataDelete'])) {
$delete_id = $_POST['dataDelete'];
$sql = "DELETE FROM qp_about WHERE ID = ?";
$args = [$delete_id];
$result = $adminclass->pdoDelete($sql,$args);
print $result;
}

?>

<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<!-- /.card -->
<div class="card">
<div class="card-header">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default-newpost">
Yeni Ekle
</button>
</div>
<!-- /.card-header -->
<div class="card-body">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>ID</th>
<th>Başlık</th>
<th>Açıklama</th>
<th>Durum</th>
<th>Tarih</th>
<th>İşlem</th>
</tr>
</thead>
<tbody>

<?php 
$variable = $adminclass->getAbout();
if ($variable) {
foreach ($variable as $value) { ?>
<tr>
<td><?php print $value['ID']; ?></td>
<td><?php print $value['title']; ?></td>
<td><?php print $value['description']; ?></td>
<td><?php print $adminclass->getStatu($value['statu']); ?></td>
<td><?php print $value['adddate']; ?></td>
<td><button type="button" class="btn btn-danger " data-toggle="modal" data-target="#modal-default<?php print $value['ID']; ?>">
Sil
</button>
<div class="modal fade" id="modal-default<?php print $value['ID']; ?>">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Hakkımızda | Sil</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<!-- general form elements enable -->
<div class="card card-info">
<div class="card-header">
</div>
<div class="card-title"></div>
<!-- /.card-header -->
<div class="card-body">
<form method="POST">
<input type="hidden" name="dataDelete" value="<?php print $value['ID']; ?>">
<p><?php print $value['title']; ?> : Bölümü silmek istiyor musunuz?</p>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-success" data-dismiss="modal">VAZGEÇ</button>
<button type="submit" class="btn btn-danger">SİL</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<button type="button" class="btn btn-warning " data-toggle="modal" data-target="#modal-default-update<?php print $value['ID']; ?>">
Güncelle
</button>
<div class="modal fade" id="modal-default-update<?php print $value['ID']; ?>">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Hakkımızda | Güncelle</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<!-- general form elements enable -->
<div class="card card-info">
<div class="card-header">
</div>
<div class="card-title"></div>
<!-- /.card-header -->
<div class="card-body">
<form method="POST">
<div class="row">
<div class="col-sm-12">
<!-- text input -->
<div class="form-group">
<label>Başlık</label>
<input type="text" class="form-control" name="title" value="<?php print $value ['title']; ?> ">
</div>
</div>

</div>
<div class="row">
<div class="col-sm-12">
<!-- textarea -->
<div class="form-group">
<label>Açıklama</label>
<textarea class="form-control" rows="5" name="description"><?php print $value ['description']; ?></textarea>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<!-- select -->
<div class="form-group">
<label>Durum</label>
<select name="statu[]" class="form-control">
<option value="1">Aktif</option>
<option value="2">Pasif</option>
</select>
</div>
</div>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-danger" data-dismiss="modal">VAZGEÇ</button>
<button type="submit" class="btn btn-success">KAYDET</button>
</div>
<input type="hidden" name="ID" value="<?php print $value ['ID']; ?>">
<input type="hidden" name="update" value="1002">
</form>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
<!-- /.modal-content -->
</div>
</div>
</td>
</tr>
<?php } } ?>


</tbody>
<tfoot>
<tr>
<th>ID</th>
<th>Başlık</th>
<th>Açıklama</th>
<th>Durum</th>
<th>Tarih</th>
<th>İşlem</th>
</tr>
</tfoot>
</table>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
<!-- /.modal-content -->
</div>
<div class="modal fade" id="modal-default-newpost">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Hakkımızda | Yeni Ekle</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<!-- general form elements enable -->
<div class="card card-info">
<div class="card-header">
</div>
<div class="card-title"></div>
<!-- /.card-header -->
<div class="card-body">
<form method="POST">
<div class="row">
<div class="col-sm-12">
<!-- text input -->
<div class="form-group">
<label>Başlık</label>
<input type="text" class="form-control" name="title">
</div>
</div>

</div>
<div class="row">
<div class="col-sm-12">
<!-- textarea -->
<div class="form-group">
<label>Açıklama</label>
<textarea class="form-control" rows="5" name="description"></textarea>
</div>
</div>
</div>

<div class="row">
<div class="col-sm-12">
<!-- select -->
<div class="form-group">
<label>Durum</label>
<select name="statu[]" class="form-control">
<option value="1">Aktif</option>
<option value="2">Pasif</option>
</select>
</div>
</div>
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-danger" data-dismiss="modal">VAZGEÇ</button>
<button type="submit" class="btn btn-success">KAYDET</button>
</div>
<input type="hidden" name="save" value="1001">
</form>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
<!-- /.modal-content -->
</div>
</div>