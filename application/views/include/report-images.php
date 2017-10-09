<div class="modal fade popup" id="reporting_images" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <h3 class="text-center" style="margin-bottom: 30px;"><strong>Thank you for reporting this <span class="type-report"></span>!</strong></h3>
                <div class="content-modal-body">
                    <p>Please select from one of the following reason for reporting this <span class="type-report"></span>:</p>
                    <div class="select-box-reporting">
                        <ul class="custom required-group">
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" checked name="reporting" id="residential" value="Residential">
                                    <label for="residential">
                                        Residential...
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="reporting" id="inappropriate" value="Inappropriate">
                                    <label for="inappropriate">
                                        Inappropriate...
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="reporting" id="wrongcategory" value="Wrong category">
                                    <label for="wrongcategory">
                                        Wrong category...
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="reporting" id="unauthorized" value="Unauthorized image use">
                                    <label for="unauthorized">
                                        Unauthorized image use...
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <p>Let us know your thoughts:</p>
	                <textarea id="messenger" name="messenger" class="form-control"></textarea>  
                </div>
            </div>  
	        <div class="modal-footer">
                <div class="content-modal-body">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id ="sent-report">Report</button>
                </div>
	        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->