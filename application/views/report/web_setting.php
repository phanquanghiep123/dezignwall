<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/bootstrap.min.css")?>"></link>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/prettify.css");?>"></link>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("wysihtml5/css/bootstrap-wysihtml5.css")?>"></link>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;">Web Setting</h1>
      <div style="height:30px; width:100%;"></div>
      <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php if (isset($list) && count($list) > 0) :
                $listtemp = $list;
                foreach ($list as $item) :
                  if ($item['group_id'] == 0) :
                    echo '<div class="form-group">
                            <div class="col-md-3"><label class="control-label">' . $item['title'] . ': </label></div>
                            <div class="col-md-9">
                              <select name="'. $item['key_identify'] .'"">';
                    foreach ($listtemp as $item_temp) :
                      if ($item_temp['group_id'] == $item['id'])  :
                        $selected = ($item['selected_item'] == $item_temp['id']) ? "selected" : "";
                        echo '<option value="'.$item_temp['id'].'" '. $selected . ' >'.$item_temp['key_identify'].': '.$item_temp['title'].'</option>';
                      endif;
                    endforeach;
                    echo '</select></div></div>';
                  endif;
                endforeach;
              endif;
        ?>
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10 text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

