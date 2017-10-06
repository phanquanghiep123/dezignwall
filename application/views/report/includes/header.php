<html>
    <head>
        <title>Report</title>
        <link href="<?php echo skin_url(); ?>/css/bootstrap.min.css" rel="stylesheet">
        <script src="<?php echo skin_url(); ?>/js/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".disabled").click(function () {
                    return false;
                });
            });
            var base_url = "<?php echo base_url();?>";
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
        <link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
        <script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
        <script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
    </head>

    <body style="padding:10px;">
        <div class="container-ful">
<?php 
$is_login_report = $this->session->userdata('is_login_report');
if ($is_login_report) : ?>
            <ul class="menu">
                <li class="initial"><a href="<?php echo base_url("report") ?>">Basic</a></li>
                <li class="initial"><a href="<?php echo base_url("report/user_conversion") ?>">User Conversion</a></li>
                <li class="initial"><a href="<?php echo base_url("report/activity") ?>">Activity</a></li>
                <li class="initial"><a href="<?php echo base_url("report/photo_upload_info") ?>">Move image order</a></li>
                <li class="initial"><a href="<?php echo base_url("report/keywords") ?>">Keyword</a></li>
                <li class="initial"><a href="<?php echo base_url("report/comment") ?>">Comment</a></li>
                <li class="initial"><a href="<?php echo base_url("report/notification") ?>">Notification</a></li>
                <li class="initial"><a href="<?php echo base_url("report/edit_user_password") ?>">Change password</a></li>
                <li class="initial"><a href="<?php echo base_url("report/web_setting") ?>">Web Setting</a></li>
            </ul>
            <style>
                ul.menu {padding: 0;margin: 10px 0;}
                ul.menu li{list-style: none;display: inline; margin-right: 10px;}
                ul.menu li a {font-size: 18px;}
                td {white-space:nowrap;}
            </style>
<?php endif; ?>
