<?php

    include('../config.php');
    include(DBAPI);

    $usuarios = null;
    $usuario = null;

    /**
     *  Listagem de Usuários
     */
    function index() {
        global $usuarios;
        $usuarios = find_all("usuarios");
    }

    /**
     *  Visualização de um Usuário
     */
    function view($id = null) {
        global $usuario;
        $usuario = find("usuarios", $id);
    }


    /**
    *  Cadastro de Usuários
     */
    function add() {
        if (!empty($_POST['usuario'])) {
            try{

            }catch(Exception $e){
                $_SESSION['message'] = 'Aconteceu um erro: ' . $e->getMessage();
		        $_SESSION['type'] = 'danger';
            }

            $usuario = $_POST['usuario'];

            save('usuarios', $usuario);
            header('location: index.php');
        }
    }

    
    /**
     *	Atualizacao/Edicao de Usuario
    */
    function edit() {

        $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
    
        if (isset($_GET['id'])) {
    
        $id = $_GET['id'];
    
        if (isset($_POST['customer'])) {
    
            $customer = $_POST['customer'];
            $customer['modified'] = $now->format("Y-m-d H:i:s");
    
            update('customers', $id, $customer);
            header('location: index.php');
        } else {
    
            global $customer;
            $customer = find('customers', $id);
        } 
        } else {
        header('location: index.php');
        }
    }

    function delete($id = null) {

        global $customer;
        $customer = remove('customers', $id);
      
        header('location: index.php');
      }










?>
