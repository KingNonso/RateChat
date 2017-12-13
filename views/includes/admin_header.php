<?php //print_r($_SESSION); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php $title = isset($this->title)? $this->title: 'RateChats'; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <?php  //General or public applicable css
        if (isset($this->generalCSS))
        {
            foreach ($this->generalCSS as $plugin)
            {
                echo '<link  href="'.URL.'public/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //General or public applicable css
        if (isset($this->pageCSS))
        {
            foreach ($this->pageCSS as $plugin)
            {
                echo '<link  href="'.URL.'views/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //page applicable plugin
        if (isset($this->cssPlugin))
        {
            foreach ($this->cssPlugin as $plugin)
            {
                echo '<link  href="'.URL.'public/custom/plugins/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo URL; ?>public/images/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo URL; ?>public/images/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo URL; ?>public/images/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>public/images/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo URL; ?>public/images/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL; ?>public/images/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo URL; ?>public/images/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL; ?>public/images/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo URL; ?>public/images/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo URL; ?>public/images/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo URL; ?>public/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo URL; ?>public/images/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo URL; ?>public/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo URL; ?>public/images/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo URL; ?>public/images/favicons/ms-icon-144x144.png">

    <!-- Theme style -->
    <link href="<?php echo URL; ?>public/custom/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URL; ?>public/custom/css/skins/skin-purple.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php
    include(View::topNav());
?>
