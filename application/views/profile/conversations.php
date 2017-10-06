<section class="section">

    <div class="relative">

        <div class="container">

            <h3><?php echo @$title_page; ?></h3>

            <?php

            if (isset($results) && count($results) > 0):

                foreach ($results as $key => $photo) : $comments = $photo['photo_comment'];

                    ?>

                    <div class="row card-wrapper" style="padding-bottom: 20px;">

                        <div class="col-sm-5">

                            <div class="card-image conversations-images relative" style="background-image:url('<?php echo base_url(@$photo['path_file']); ?>') "></div>

                        </div>

                        <div class="col-sm-7">

                            <div class="card item-conversations" data-id="<?php echo @$photo['photo_id']; ?>" data-type="<?php echo $datatype;?>">

                                <div class="card-info conversations-info">

                                    <div class="row">

                                        <div class="col-xs-2"></div>

                                        <div class="col-xs-10">

                                            <div class="card-top">

                                                <span><span id="number-like"><?php echo @$photo['qty_like'] == null ? 0 : $photo['qty_like']; ?></span> Likes</span>

                                                <span><span id="num-comment"><?php echo @$photo['qty_comment'] == null ? 0 : $photo['qty_comment']; ?></span> Comments</span>

                                                <?php if (isset($photo['qty_comment']) && $photo['qty_comment'] >= 3) : ?> <span class="more-comment" data-type ="<?php echo $datatype;?>" id="view-more"><i class="fa fa-comment"></i> View older comments…</span><?php endif; ?>		    

                                            </div>

                                        </div>

                                    </div><!--end row-->

                                    <div class="uesr-box-impromation">

                                        <div class="avatar">

                                            <?php if (count($comments) > 0) : ?>

                                                <?php foreach ($comments as $comment) : ?>

                                                    <div class="row comment-items">

                                                        <div class="col-xs-2">

                                                            <?php

                                                            $src = skin_url() . "/images/signup.png";

                                                            if (isset($comment["avatar"]) && $comment["avatar"] != null) {

                                                                $src = $comment["avatar"];

                                                            }

                                                            ?>

                                                            <img src="<?php echo @$src; ?>" class="left">

                                                        </div>

                                                        <div class="col-xs-10">

                                                            <p><strong><?php echo $comment["first_name"] . ' ' . $comment["last_name"]; ?> | <?php echo @$comment["company_name"]; ?></strong></p>

                                                            <div>

                                                                <p class="text-comment" data-id="<?php echo $comment['id']; ?>">

                                                                    <?php

                                                                    if (strlen($comment['comment']) <= 79) {

                                                                        echo "<span>" . $comment['comment'] . "</span>";

                                                                    } else {

                                                                        echo "<span class='comment-item-text default-show block'>" . substr($comment['comment'], 0, 71) . "<span class='more' id='more-comment'> MORE...</span></span>";

                                                                        echo "<span class='comment-item-text default-hie'>" . $comment['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";

                                                                    }

                                                                    ?>

                                                                </p>

                                                                <?php if ($user_id == $comment['member_id']) : ?>

                                                                    <span class="action-comment">

                                                                        <a data-id="<?php echo @$comment['id']; ?>" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>

                                                                        <a data-id="<?php echo @$comment['id']; ?>" class="delete-comment" href="#"><i class="fa fa-times"></i></a>

                                                                    </span>

                                                                <?php endif; ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                <?php endforeach; ?>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-xs-2"></div>

                                        <div class="col-xs-10">

                                            <p class="label-add-comment"><a href="#">Post comment...</a></p>

                                        </div>

                                    </div>

                                    <div class="row" style="background:#fff;margin:0;">

                                        <div class="col-xs-2"></div>

                                        <div class="col-xs-10">

                                            <div class="box-input-comment" style="display:none;">

                                                <div class="close_box_custom">x</div>

                                                <div class="relative">

                                                    <textarea id="content-comment"></textarea>

                                                    <div class="action text-right">

                                                        <button class="btn btn-gray clear button-singin" id="clear-text">Clear Text</button>

                                                        <button class="sign-in btn btn-primary button-singin" id="add-comment" data-object ="<?php echo $datatype;?>" data-id="<?php echo @$photo['photo_id']; ?>" data-parent="card-<?php echo @$photo['photo_id']; ?>">Add Comment</button>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div><!--end row-->

                                </div>

                            </div>

                        </div>

                    </div><!--end row-->

                    <?php

                endforeach;

            endif;

            ?>

            <?php if (isset($links) && $links != null) : ?>

                <div class="row">

                    <div class="col-sm-12">

                        <?php echo $links; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<script type="text/javascript">

    $(document).ready(function () {

        $(document).on('click', '.close_box_custom', function () {

            $(this).parents('.box-input-comment').slideUp('slow');

            return false;

        });



        $(document).on('click', '.label-add-comment a', function () {

            $('.card').find('.box-input-comment').hide();

            $(this).parents('.card').find('.box-input-comment').slideDown('slow');

            return false;

        });

    });

</script>

<style type="text/css">

    .edit-comment{margin-right: 5px;}

    .card.item-conversations{

        width: 100%;

        float:none;

    }

    .card.item-conversations .card-info{

        display: block;

        position: relative;

        top:0;

        box-shadow: none;

    }

    .card.item-conversations .uesr-box-impromation {

        height: 220px;

        overflow-y: scroll;

        margin-right: 5px;

    }

    .card.item-conversations .col-xs-10.box-impromation p > a {color:rgb(33, 25, 34) !important}

    .card.item-conversations .uesr-box-impromation .avatar img{

        width: 73px;

        height: 73px;

    }

    .card.item-conversations .comment-items{

        margin-bottom: 10px;

    }

    .card.item-conversations .card-top{

        font-size: 16px;

        padding-left: 0;

        margin-left: 10px;

        padding-top: 15px;

        padding-bottom: 10px;

        border-bottom: 1px solid #ccc;

    }

    .card.item-conversations .box-input-comment{

        position: relative;

        display: block;

        z-index: 100;

        margin-top: 15px;

        left: 15px;

        width: 95%;

    }

    .card.item-conversations .close_box_custom{

        position: absolute;

        right: 5px;

        top: -25px;

        color: #ccc;

        cursor: pointer;

    }

    .card.item-conversations .col-xs-2.remove-padding{

        padding-left: 10px;

        padding-right: 10px;

    }

    .card.item-conversations .col-xs-10.box-impromation{

        padding-left: 10px;

        padding-right: 10px;

    }

    .card.item-conversations .col-xs-10.box-impromation p,

    .card.item-conversations .col-xs-10.box-impromation span{

        font-size: 16px;

    }

    .card.item-conversations .uesr-box-impromation .box-impromation p a,

    .card.item-conversations .company-content-box .comment-item p a{

        color: #37a7a7;

    }

    .card.item-conversations .label-add-comment{

        margin: 0;

        padding-left: 20px;

        margin-bottom: 10px;

    }

</style>