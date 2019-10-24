<!DOCTYPE html>
<html lang="<?php echo $language_code; ?>" class=" js backgroundsize borderradius boxshadow cssanimations">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $title ?> - Jorani</title>
    <link href="<?php echo base_url(); ?>assets/v2/css/jorani.css" media="screen" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!--<link href="<?php echo base_url(); ?>assets/css/jorani-0.6.6.css" rel="stylesheet" />-->
    <link href="<?php echo base_url(); ?>assets/css/jorani-1.0.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/MDI-3.4.93/css/materialdesignicons.min.css">

    <link href="<?php echo base_url(); ?>assets/v2/favicon.ico" rel="shortcut icon" type="image/x-icon">

    <script src="<?php echo base_url(); ?>assets/v2/js/modernizr.min.js" type="text/javascript"></script>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta description="Jorani a free and open source leave management system. Workflow of approval; e-mail notifications; calendars; reports; export to Excel and more.">
    <meta name="version" content="1.0">
    <meta content="A1QME020P" name="slack-app-id">

    <?php CI_Controller::get_instance()->load->helper('language');
    $this->lang->load('global', $language); ?>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>