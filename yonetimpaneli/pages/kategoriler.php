<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>KATEGORİLER</h1>
</div>
</div>
</div>
</section>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="row">
<!-- left column -->
<div class="col-sm-8">

<?php
//veri ekleme 
if(isset($_POST['save'])){
if ($_POST['save']==5001) {
$title = $_POST['title'];
$parent_id=$_POST['parent_id'];
$statu =$_POST['statu'];
$adddate= date('Y-m-d H:i:s');
$sql = "INSERT INTO qp_categories(title, parent_id, statu, user_id, adddate) VALUES (?,?,?,?,?)";
$args = [$title,$parent_id,$statu,$user_id,$adddate];
$result=$adminclass->getSecurity($args);
$response= $adminclass->pdoPrepare($sql,$result);
if ($response) {
print '<div class="alert alert-success">Kategori Eklendi</div>';
header("refresh:1 url=kategoriler");
}else{print '<div class="alert alert-danger">Kategori Eklenemedi</div>';}
}
}
?>

<!-- general form elements disabled -->
<div class="card card-secondary">
<div class="card-header">
<h3 class="card-title">Kategori Ekle</h3>
</div>
<!-- /.card-header -->

<div class="card-body">
<form method="post">
<div class="form-group">
<label>Kategori Açıklaması</label>
<input type="text" class="form-control" name="title">
</div>

<!-- select box -->
<div class="form-group">
<label>Üst Kategori</label>
<select class="form-control" name="parent_id">
<option value="0" selected>Yok</option>
<?php
$sql="SELECT * FROM qp_categories";
$categories=$adminclass->pdoQueryObj($sql);
if ($categories) {
foreach ($categories as $category) {  
?>

<option value="<?php print $category->ID; ?>"><?php print $category->title; ?></option>

<?php 
} }
?>	
</select>
</div>

<div class="form-group">
<label>Durum</label>
<select name="statu" class="form-control">
<option value="1">Aktif</option>
<option value="2">Pasif</option>
</select>
</div>
<div class="form-group">
<button type="submit" name="save" value="5001" class="btn btn-success">Kaydet</button>
</div>
</form>
</div>
</div>
<!-- /.card-body -->
</div>
<div class="col-sm-4">
<pre>
<?php 
$sql="SELECT * FROM qp_categories";
$categoryList=$adminclass->pdoQueryObj($sql);
$category = $adminclass->getCategories($categoryList);
if ($category) {
foreach ($category as $value ) {
print 'ANA KATEGORİLER: '.$value->title.'<br>';
if (isset($value->child)) {
foreach ($value->child as $value) {
print '1.ALT KATEGORİLER: '.$value->title.'<br>';
if (isset($value->child)) {
foreach ($value->child as $value) {
print '2.ALT KATEGORİLER: '.$value->title.'<br>';
if (isset($value->child)) {
foreach ($value->child as $value) {
print '3.ALT KATEGORİLER: '.$value->title.'<br>';
}
}
}}
}}
}
}
?>
</pre>
</div>
<!-- /.card -->
<!-- general form elements disabled -->
</div>

</div>
</div>
</section>
</div>
