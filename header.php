<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1">
    <meta http-equiv="X-UA-Comorange patible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>?v=<?php echo filemtime(get_stylesheet_directory() . '/style.css'); ?>">
    <title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>
</head>
<body>