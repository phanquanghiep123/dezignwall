<div class="row">
    <div id="box-refine-common">
        <div class="col-xs-12 col-sm-9 col-md-9 static">
            <div class="seach-home relative destop-seach">
                <div class="box-seach">
                    <form id="seach-home-photo" method="GET" action="<?php echo base_url("search") ?>" class="relative form-color">
                        <input type="text" class="form-control" name="keyword" id="input-seach" value="<?php echo @$_GET["keyword"]; ?>" placeholder="Begin your search ..." autocomplete="off">
                        <input type="hidden" class="form-control" name = "location" id = "location" value="">
                        <input type="hidden" class="form-control" name = "all_category" id="all_category" value="">
                        <button name="seach-sumit" class="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="box-refine">
                <a href="#" class="refine-search">Refine<br/>your search</a>
                <a href="#" class="refine-search mobile">Refine your search</a>
                <div class="box-refine-search avenir-regular">
                    <div class="row text-left">
                        <div class="col-md-12">
                            <div id="close-form">x</div>
                            <div class="left-box">Location:</div>
                            <div class="right-box location">
                                <ul class="menu-location">
                                    <li>
                                        <div class="checkbox radio-yelow checkbox-circle">
                                            <input class="indoor" id="data-check-1" class="" type="checkbox" value="1">
                                            <label for="data-check-1">Indoor</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox radio-yelow checkbox-circle">
                                            <input class="outdoor" id="data-check-2" class="" type="checkbox" value="2">
                                            <label for="data-check-2">Outdoor</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        $CI = & get_instance();
                        echo $CI->Common_model->get_search_category();
                        ?>
                        <div class="col-md-12 text-right">
                            <a id="clear-find-search" for-parent="#formsearch_service" class="btn btn-gray">Clear</a>
                            <button id="find-search" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>