<?php
/* Подключение к серверу MySQL */ 

$link_to_mysql = mysqli_connect( 
            'localhost',  /* Хост, к которому мы подключаемся */ 
            'root',       /* Имя пользователя */ 
            '',   /* Используемый пароль */ 
            'mac');     /* База данных для запросов по умолчанию */ 

if (!$link_to_mysql) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
} 

//config flag