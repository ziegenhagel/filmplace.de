<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1">
    <meta http-equiv="X-UA-Comorange patible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?' . time(); ?>"/>
    <title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>
<?php
// include nav-top
include 'parts/nav-top.php';
