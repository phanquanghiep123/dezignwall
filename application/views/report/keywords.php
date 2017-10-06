<table class="table table-bordered">
        <tr style="background:#eeeeee">
            <td style="font-weight: bold;">x</td>
            <td style="font-weight: bold;">Keyword title</td>
            <td style="font-weight: bold;">Action</td>
            
      </tr>
    <?php
    if (isset($record)):
        $total = 1;
        if($page == 0){
            $page = "";
        }
                foreach ($record as $key => $value) {
                    echo '<tr>
                      <td>' . ($total++) . '</td>
                        <td>
                            <div class="title-keyword-default">' . $value['title'] . '</div>
                            <div class="title-keyword-set">
                                <input type = "text" id="value-new-keyword" value="'.$value['title'].'"/>                                
                                <button id="save" data-id = "'.$value['keyword_id'].'">Save</button>
<button id="cancel">Cancel</button>
                            </div>
                        </td>
                        <td>
                            <button id="edit">Edit</button>
                            <button data-href ="'.base_url("report/deletekeyword/".$value['keyword_id']."?page=".$page).'" id="Delete">Delete</button>
                        </td>
                    </tr>';
                }
        ?>
    <?php endif; ?>
</table>
<div class="col-md-12 text-right"><?php echo $this->pagination->create_links();?></div>
</div>
</body>
<style type="text/css">
    .title-keyword-set {display: none;}
    .error{border: 1px solid red;}
    td {white-space: normal;}
</style>
<script type="text/javascript">
    var url_base = "<?php echo base_url();?>";
    $(document).ready(function(){
        $("tr #edit").click(function(){
            $(this).parents("tr").find(".title-keyword-default").hide();
            $(this).parents("tr").find(".title-keyword-set").show();
        });
        $("tr #cancel").click(function(){
            $(this).parents("tr").find(".title-keyword-set").hide();
            $(this).parents("tr").find(".title-keyword-default").show();
            
        });
        $("tr #save").click(function(){
            var value_defult = $(this).parents("tr").find(".title-keyword-default").text();
            var this_ajax = $(this);
            $(this).parents("tr").find("#value-new-keyword").removeClass("error");
            var id = $(this).data("id");
            var value = $(this).parents("tr").find("#value-new-keyword").val();
            if(value != "" && !isNaN(id)){
                if(value_defult != value){
                    $.ajax({
                        url : url_base + "report/updatekeyword",
                        type:"post",
                        dataType:"json",
                        data:{id:id,value:value},
                        success:function(data){
                            if(data["success"] == "success"){
                                this_ajax.parents("tr").find(".title-keyword-default").html(data["record"]["title"]);
                                this_ajax.parents("tr").find(".title-keyword-set").hide();
                                this_ajax.parents("tr").find(".title-keyword-default").show();
                            }else{
                                alert("error");
                            }
                        },
                        error: function(){
                            alert("error");
                        }
                    });
                }else{
                    this_ajax.parents("tr").find(".title-keyword-set").hide();
                    this_ajax.parents("tr").find(".title-keyword-default").show();
                }
                
            }else{
                $(this).parents("tr").find("#value-new-keyword").addClass("error");
            }
        });
        $("tr #delete").click(function(){
            var c = confirm("Do you want to delete?");
            if(c == true){
                window.location.href = $(this).data("href");
            }
        });
    });
</script>
</html>