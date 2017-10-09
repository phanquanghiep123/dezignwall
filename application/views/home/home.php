
<div class="section section-1">
    <div id="slider-home-page">
        <ul class="bxslider">
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-0.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-1.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-2.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-3.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-4.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
            <li class="item-slider" style="background-image:url(<?php echo skin_url(); ?>/images/slider-5.jpg)">
                <div class="img-local text-right">
                    <p>Image Title</p>
                    <p>Company Name</p>
                    <p>Photo by: Photographer</p>
                </div>
                <div class="bg-slider-image"></div>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-11 content-cented ">
                <div class="seach-in-slider">
                    <h1 class="text-center color-white strong">The home for commercial design professionals.</h1>
                    <form class="relative fom-seach-slider content-cented destop">
                        <input type="text" class="seach-input-slider form-control" name="input-seach" id="input-seach" placeholder="Begin your search ...">
                        <button class="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section section-2 box-wapper-show-image">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center color-yellow">Find your commercial design inspiration...</h2>
        </div>
        <div class="col-md-12">
            <!--<div class="gird-img">
                <div class="cards">
            <?php
            if (isset($photo) && count($photo) > 0):
                $index = 6;
                for ($i = 1; $i <= 6; $i++) {
                    ?>
                                            <div class="card" style="z-index:<?php echo $index; ?>">
                                                    <div class="card-wrapper">
                                                        <div class="card-image relative">
                                                            <img src="<?php echo skin_url("images/list-" . $i . ".jpg"); ?>"/>
                                                            <div class="impromation-project">
                                                                <div class="logo-company"><img src="<?php echo skin_url("images/logo-company.png"); ?>"></div>
                                                                <div class="impromation-project-dropdown">
                                                                    <div class="dropdown-impromation relative">
                                                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                                        <ul class="dropdown-impromation-menu">
                                                                            <li><a href="#">Residential...</a></li>
                                                                            <li><a href="#">Inappropriate...</a></li>
                                                                            <li><a href="#">Wrong category...</a></li>
                                                                            <li><a href="#">Unauthorized image use...</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="impromation">
                                                                    <h5><strong>Company Name</strong></h5>
                                                                    <p>Business Description</p>
                                                                </div>
                                                            </div>
                                                            <div class="commen-like">
                                                                <div class="row">
                                                                    <div class="col-xs-3 col-md-3 text-center">
                                                                        <div class="likes">
                                                                            <p>38 Likes</p>
                                                                            <p><img src="<?php echo skin_url(); ?>/images/like.png"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-2 col-md-2 text-center">
                                                                        <div class="microsite">
                                                                            <p style="height:20px"></p>
                                                                            <p><img src="<?php echo skin_url(); ?>/images/i.png"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-7 col-md-7">
                                                                        <p>2 Comments</p>
                                                                        <div class="comment">
                                                                            <img src="<?php echo skin_url(); ?>/images/comment.png" class="left">
                                                                            <h3>Comment</h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
        <?php if ($i == 6): ?>
                                                            <div class="card-info">
                                                                <div class="uesr-box-impromation">
                                                                    <div class="avatar">
                                                                        <div class="row">
                                                                            <div class="col-md-3"><img src="<?php echo skin_url(); ?>/images/avata-men.png" class="left"></div>
                                                                            <div class="col-md-9 box-impromation">
                                                                                <p><strong>Persons name | Company Name</strong></p>
                                                                                <p>One or two rows of the last comment string posted to this image...</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
        <?php endif; ?>
                                                        <div class="box-input-comment">
                                                            <div class="relative">
                                                                <div class="close_box">x</div>
                                                                <textarea id="content-comment"></textarea>
                                                                <div class="action text-right">
                                                                    <button id="clear-text btn btn-gray">Clear Text</button>
                                                                    <button id="add-comment btn btn-primary">Add Comment</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                    <?php
                    $index--;
                }
            endif;
            ?>
                </div>
            </div>-->
            <div class="list-image col-md-12"  >
                <div class="row">
                    <div class="col-md-4 items">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item">
                                    <img src="<?php echo skin_url(); ?>/images/list-1.jpg">
                                    <div class="impromation-project">
                                        <div class="impromation-project-dropdown">
                                            <div class="dropdown-impromation relative">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                <ul class="dropdown-impromation-menu">
                                                    <li><a href="#">Residential...</a></li>
                                                    <li><a href="#">Inappropriate...</a></li>
                                                    <li><a href="#">Wrong category...</a></li>
                                                    <li><a href="#">Unauthorized image use...</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="logo-company"><img src="http://beta.dezignwalldev.com/skins/images/logo-company.png"></div>
                                        <div class="impromation">
                                            <h5><strong>Company Name</strong></h5>
                                            <p>Business Description</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="item">
                                    <img src="<?php echo skin_url(); ?>/images/list-4.jpg">
                                    <div class="impromation-project">
                                        <div class="logo-company"><img src="<?php echo skin_url(); ?>/images/logo-company.png"></div>
                                        <div class="impromation-project">
                                            <div class="impromation-project-dropdown">
                                                <div class="dropdown-impromation relative">
                                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                    <ul class="dropdown-impromation-menu">
                                                        <li><a href="#">Residential...</a></li>
                                                        <li><a href="#">Inappropriate...</a></li>
                                                        <li><a href="#">Wrong category...</a></li>
                                                        <li><a href="#">Unauthorized image use...</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="logo-company"><img src="http://beta.dezignwalldev.com/skins/images/logo-company.png"></div>
                                            <div class="impromation">
                                                <h5><strong>Company Name</strong></h5>
                                                <p>Business Description</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 items">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item">
                                    <img src="<?php echo skin_url(); ?>/images/list-2.jpg">
                                    <div class="impromation-project">
                                        <div class="impromation-project-dropdown">
                                            <div class="dropdown-impromation relative">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                <ul class="dropdown-impromation-menu">
                                                    <li><a href="#">Residential...</a></li>
                                                    <li><a href="#">Inappropriate...</a></li>
                                                    <li><a href="#">Wrong category...</a></li>
                                                    <li><a href="#">Unauthorized image use...</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="logo-company"><img src="http://beta.dezignwalldev.com/skins/images/logo-company.png"></div>
                                        <div class="impromation">
                                            <h5><strong>Company Name</strong></h5>
                                            <p>Business Description</p>
                                        </div>
                                    </div>
                                    <div class="commen-like">
                                        <div class="row">
                                            <div class="col-xs-3 col-md-3 text-center"><p>38 Likes</p><p><img src="<?php echo skin_url(); ?>/images/like.png"></p></div>
                                            <div class="col-xs-2 col-md-2 text-center"><p style="height:20px"></p><p><img src="<?php echo skin_url(); ?>/images/i.png"></p></div>
                                            <div class="col-xs-7 col-md-7"><p>16 Comments</p>
                                                <div class="comment">
                                                    <img src="<?php echo skin_url(); ?>/images/comment.png" class="left">
                                                    <h3>Comment</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="item">
                                    <img src="<?php echo skin_url(); ?>/images/list-5.jpg">
                                    <div class="impromation-project">
                                        <div class="impromation-project-dropdown">
                                            <div class="dropdown-impromation relative">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                <ul class="dropdown-impromation-menu">
                                                    <li><a href="#">Residential...</a></li>
                                                    <li><a href="#">Inappropriate...</a></li>
                                                    <li><a href="#">Wrong category...</a></li>
                                                    <li><a href="#">Unauthorized image use...</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="logo-company"><img src="http://beta.dezignwalldev.com/skins/images/logo-company.png"></div>
                                        <div class="impromation">
                                            <h5><strong>Company Name</strong></h5>
                                            <p>Business Description</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 items">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item">
                                    <img src="<?php echo skin_url(); ?>/images/list-3.jpg">
                                    <div class="impromation-project">
                                        <div class="impromation-project-dropdown">
                                            <div class="dropdown-impromation relative">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                <ul class="dropdown-impromation-menu">
                                                    <li><a href="#">Residential...</a></li>
                                                    <li><a href="#">Inappropriate...</a></li>
                                                    <li><a href="#">Wrong category...</a></li>
                                                    <li><a href="#">Unauthorized image use...</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="logo-company"><img src="http://beta.dezignwalldev.com/skins/images/logo-company.png"></div>
                                        <div class="impromation">
                                            <h5><strong>Company Name</strong></h5>
                                            <p>Business Description</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="item">
                                    <div class="relative">
                                        <img src="<?php echo skin_url(); ?>/images/list-6.jpg">
                                        <div class="impromation-project">
                                            <div class="impromation-project-dropdown">
                                                <div class="dropdown-impromation relative">
                                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                    <ul class="dropdown-impromation-menu">
                                                        <li><a href="#">Residential...</a></li>
                                                        <li><a href="#">Inappropriate...</a></li>
                                                        <li><a href="#">Wrong category...</a></li>
                                                        <li><a href="#">Unauthorized image use...</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="logo-company"><img src="<?php echo skin_url(); ?>/images/logo-company.png"></div>
                                            <div class="impromation">
                                                <h5><strong>Company Name</strong></h5>
                                                <p>Business Description</p>
                                            </div>
                                        </div>
                                        <div class="commen-like">
                                            <div class="row">
                                                <div class="col-xs-3 col-md-3 text-center"><p>38 Likes</p><p><img src="<?php echo skin_url(); ?>/images/like.png"></p></div>
                                                <div class="col-xs-2 col-md-2 text-center"><p style="height:20px"></p><p><img src="<?php echo skin_url(); ?>/images/i.png"></p></div>
                                                <div class="col-xs-7 col-md-7"><p>16 Comments</p>
                                                    <div class="comment">
                                                        <img src="<?php echo skin_url(); ?>/images/comment.png" class="left">
                                                        <h3>Comment</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uesr-box-impromation">
                                        <div class="avatar">
                                            <div class="row">
                                                <div class="col-md-3"><img src="<?php echo skin_url(); ?>/images/avata-men.png" class="left"></div>
                                                <div class="col-md-9 box-impromation">
                                                    <p><strong>Persons name | Company Name</strong></p>
                                                    <p>One or two rows of the last comment string posted to this image...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
