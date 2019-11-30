<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'functions.php';


createTable('members',
            'member_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            s_name VARCHAR(16),
            f_name VARCHAR(16),
            phone VARCHAR(16),
            email VARCHAR(128),
            address VARCHAR(256),
            date TIMESTAMP');  

createTable('login',
            'member_id INT UNSIGNED NOT NULL PRIMARY KEY,
            username VARCHAR(128),
            password VARCHAR(128)');

createTable('category',
            'member_id INT UNSIGNED NOT NULL PRIMARY KEY,
            category INT UNSIGNED');

createTable('genealogy',
            'member_id INT UNSIGNED NOT NULL PRIMARY KEY,
             parent_id INT');

createTable('training',
            'article_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(128),
            content VARCHAR(512),
            category INT');

createTable('transactions',
            'tranc_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            member_id INT,
            description VARCHAR(128),
            amount INT,
            date TIMESTAMP');

createTable('validate',
            'email VARCHAR(128),
            code VARCHAR(128)');


?>
