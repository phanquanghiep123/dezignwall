<div class="modal fade popup" id="pin_to_wall" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><div class="logo"><div class="logo-site"></div></div></h4>
            </div>
            <div class="modal-body">
                <h3 class="title_box">Pin to Your Wall</h3>
                <div class="row">
                    <div class="col-md-12"><img id="image-pin" src=""></div>
                    <div class="col-md-12">
                      <div class="box-boder-bottom">
                        <p class="title"><strong>Choose a Wall:</strong></p>
                        <div id="box-all-wall" class="common-box-wall">
                        	<div class="box-wall-pin"></div>
                        </div> 
                        <p id="add_new_project"><a href="<?php echo base_url("designwalls/upgrade");?>">+ Create a new Wall</a></p>
                        <p id="add_upgrade" data-type ="upgrade"><a href="<?php echo base_url("designwalls/upgrade");?>">Oops! Looks like you’re out of Walls.</br>
Click here to add more Walls.</a></p>
                        <input type="text" name="new-project" placeholder="Give your Wall a name..." id="new-project" class="none-element form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                        <p class="title"><strong>Choose a Category:</strong></p>
                        <div id="box-all-category" class="common-box-wall">
                        	<div class="box-wall-pin"></div>
                        </div>
                        <p id="add_new_category"><a href="#">+ Create a new Folder</a></p>
                        <input type="text" id="pin-new-category" class="form-control" name="pin-new-category" placeholder="Give your Folder a name..."> 
                    </div>
                    <div class="col-md-12">
                        <p class="title"><strong>What do you like about this Image?</strong></p>
                        <textarea id="pin-comment" name="pin-comment" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-dezignwall">Pin to Your Wall</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<style type="text/css">
    .box-wall-pin ul {padding: 0;}
    .box-wall-pin li {font-size: 17px; list-style: none;margin-bottom: 1px; cursor: pointer; display: none;}
    .box-wall-pin li:hover{color: #2c9595;}
    .chose-value{color:#2c9595;font-weight: bold; }
    #add_upgrade{
        background: #37a7a7;
        border-radius: 5px;
        padding: 5px 10px;
    }
    #add_upgrade a{
        color: #fff;
        font-weight: bold;
        font-size: 17px;
    }
    #pin-new-category,#new-project{border-color:#2c9595; }
    #pin-new-category::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color:    #2c9595;
    }
    #pin-new-category:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color:    #2c9595;
       opacity:  1;
    }
    #pin-new-category::-moz-placeholder { /* Mozilla Firefox 19+ */
       color:    #2c9595;
       opacity:  1;
    }
    #pin-new-category:-ms-input-placeholder { /* Internet Explorer 10-11 */
       color:    #2c9595;
    }
    #new-project::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color:    #2c9595;
    }
    #new-project:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color:    #2c9595;
       opacity:  1;
    }
    #new-project::-moz-placeholder { /* Mozilla Firefox 19+ */
       color:    #2c9595;
       opacity:  1;
    }
    #new-project:-ms-input-placeholder { /* Internet Explorer 10-11 */
       color:    #2c9595;
    }
    .box-wall-pin{
    	max-height: 76px;
	    overflow-y: auto;
	    direction: rtl;
	    padding-left: 15px;
    }
    .box-wall-pin ul{
    	direction: ltr;
    }
    .box-wall-pin::-webkit-scrollbar {
    width: 5px;
	}
	.box-wall-pin::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
	    border-radius: 2px;
	}
	.box-wall-pin::-webkit-scrollbar-thumb {
	    border-radius: 2px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
	}
	#more_wall{padding-left: 15px;}
	.show{display: block !important;}
</style>