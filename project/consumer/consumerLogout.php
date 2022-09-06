<?php
   session_start() ;
   
   session_destroy() ;

   setcookie(session_name(), "", 1 , "/") ; // delete memory cookie 
   header("Location: consumerLoginRegister.php") ;