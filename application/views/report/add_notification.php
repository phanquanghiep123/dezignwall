
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/bootstrap.min.css")?>"></link>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/prettify.css");?>"></link>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/bootstrap-wysihtml5.css")?>"></link>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;">Add new notification</h1>
      <div style="height:30px; width:100%;"></div>
      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="control-label col-sm-2" for="title">Title*:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" value="<?php echo @$_POST["title"];?>" placeholder="Enter Title">
            <?php echo form_error('title', '<div class="error">', '</div>'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="summary">Summary*:</label>
          <div class="col-sm-10"> 
          <textarea style="height:150px; " class="form-control" name="summary" id="summary" placeholder="Enter summary"><?php echo @$_POST["summary"];?></textarea>
          <?php echo form_error('summary', '<div class="error">', '</div>'); ?>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="content">Content:</label>
          <div class="col-sm-10">
            <textarea style="height:200px; " class="textarea form-control" name="content" id="content" placeholder="Enter content"><?php echo @$_POST["content"];?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="images">Images:</label>
          <div class="col-sm-10">
            <input type="file" name="images" id="images" accept="image/*">
          </div>
        </div>
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10 text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo skin_url("wysihtml5/js/wysihtml5-0.3.0.js")?>"></script>
<script src="<?php echo skin_url("wysihtml5/js/jquery-1.7.2.min.js")?>"></script>
<script src="<?php echo skin_url("wysihtml5/js/prettify.js")?>"></script>
<script src="<?php echo skin_url("wysihtml5/js/bootstrap.min.js")?>"></script>
<script src="<?php echo skin_url("wysihtml5/js/bootstrap-wysihtml5.js");?>"></script>
<script type="text/javascript">
    $('#content').wysihtml5();
</script>
<script type="text/javascript" charset="utf-8">
  $(prettyPrint);
</script>