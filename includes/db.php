<?php
function db_connect(){
    return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
}
$conn = db_connect();


$user_insert = pg_prepare($conn,"client_insert","INSERT INTO client(client_email) VALUES($1)");


function insert_client($email_address){
    global $conn;
    return pg_excute($conn,"client_insert",array($email_address));
    }
    $stmt1 = pg_prepare($conn, 'employee_retrieve','SELECT * FROM employee WHERE employee_id = $1 ');

    
    function  email_exist( $email ) {
        $conn = db_connect();
        $result = pg_execute( $conn, 'email_exist', array( $email ) );
        if ( pg_num_rows( $result ) == 1 ) {
          $user = pg_fetch_assoc( $result, 0 );
          return $user;
        } else {
          return false;
        }
      }
      function employee_select( $employee_id ) {
        $conn = db_connect();
        $result = pg_execute( $conn, 'employee_select', array( $employee_id ) );
        if ( pg_num_rows( $result ) == 1 ) {
          $employee = pg_fetch_assoc( $result, 0 );
          return $employee;
        } else {
          return false;
        }
      }
      function user_authenticate( $employee_id, $password ) {
        $conn = db_connect();
        $result = pg_execute( $conn, "employee_select", array( $employee_id ) );
        $employee = pg_fetch_assoc( $result );
        // verifys the password has input returns false if not correct password
        if ( password_verify( $password, $employee[ 'password' ] ) == 1 ) {
          return true;
        } else {
          return false;
        }
      }
?>