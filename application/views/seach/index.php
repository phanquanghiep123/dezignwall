<div class="section section-1 box-wapper-show-image">
    <div class="container">
        <div class="top">
            <div class="row">
                <div class="col-md-12">
                    <?php echo breadcrumb(); ?>
                    <?php
                    if (!isset($photo_type) && !isset($keyword)) {
                        $photo_type = "Search";
                    }
                    ?>
                    <?php
                    if (isset($slug) && $slug != "") {
                        $slug = str_replace("-", " ", $slug);
                        $slug = str_replace("_", "/", $slug);
                        $slug = ucwords($slug);
                        $slug = $slug == 'Inspiration' ? 'Projects' : $slug;
                        $photo_type = "";
                    }
                    ?>
                    <h1 id="all-img-seach"><?php echo @$photo_count . " results found in " . @$photo_type . @$keyword . @$slug; ?></h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 relative">
                <div id="refresh-new-image"><a href="<?php echo base_url(); ?>" class="btn btn-primary">15 New Images Posted</a></div>
            </div>
            <div class="col-sm-12">
                <div class="gird-img column-3" data-count="<?php echo @$photo_count; ?>">
                    <div class="cards">
                        <div class="row">
                            <?php
                            if (isset($photo)) {
                                $data["photo"] = $photo;
                                $this->load->view("seach/seach_result", $data);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="loadding text-center"><img src="<?php echo skin_url("images/loadding.GIF"); ?>"></div>
                </div>
            </div>
        </div>
    </div>
   