<?php
/**
 *  define routes with its controllers and actions 
 */
const routes = array(
    '/'             => array('HomeController', 'index'),
    '/home'         => array('HomeController', 'index'),
    '/login'        => array('AuthController', 'loginView'),
    '/register'     => array('AuthController', 'registerView'),
);
