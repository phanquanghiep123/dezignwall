<div class="col-md-12">
<table class="table table-bordered">
        <tr style="background:#eeeeee">
            <th>x</th>
            <th>Full name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    <?php
    if (isset($record)):
        $total = 1;
        if($page == 0){
            $page = "";
        }
            foreach ($record as $key => $value) {
                echo'<tr>
                        <td>' . ($total++) . '</td>
                        <td>'.$value['first_name'].' '.$value['last_name'].'</td>
                        <td>'.$value['email'].'</td>
                        <td>
                            <button><a href ="'.base_url("report/export_member/".$value['id'].'/'.$page).'">Export photo</a></button>
                        </td>
                    </tr>';
            }
        ?>
    <?php endif; ?>
</table>
</div>
<div class="col-md-12 text-right"><?php echo $this->pagination->create_links();?></div>
</div>
</body>
<style type="text/css">
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
        $("tr #edit").click(function(){
            window.location.href = $(this).data("href");
        });
    });
</script>
</html>