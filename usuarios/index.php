<?php
include('functions.php');

index();

include(HEADER_TEMPLATE);
?>

<header class="mt-2">
    <div class="row">
        <div class="col-sm-6">
            <h2>Usuários</h2>
        </div>
        <div class="col-sm-6 text-right h2">
            <a class="btn btn-secondary" href="add.php"><i class="fa-solid fa-user-tie"></i> Novo usuário</a>
            <a class="btn btn-light" href="index.php"><i class="fa-solid fa-refresh"></i> Atualizar</a>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $_SESSION['message']; ?>
    </div>
    <!--  clear_messages(); -->
<?php endif; ?>

<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th width="30%">Nome</th>
            <th>User</th>
            <th>Foto</th>
            <th class="text-start">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($usuarios) : ?>
            <?php foreach ($usuarios as $usuario) : 
                      $deleteLink = "delete.php?id=" . $usuario['id'];
                
                ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['user']; ?></td>
                    <td><?php echo $usuario['foto']; ?></td>

                    <td class="actions text-start">
                        <a href="view.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-light"><i class="fa fa-eye"></i> Visualizar</a>
                        <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> Editar</a>

                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" 
                        data-bs-usuario="<?php echo $usuario['id'];?>" data-bs-target="#exampleModal">
                             <i class="fa fa-trash"></i>Excluir
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6">Nenhum registro encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



<?php
//entao ele quer 1 modal pra todos os links, 
//criar uma function com js pra passar o link do id no http e o modal usar isso?

include('modal.php');
include(FOOTER_TEMPLATE);
?>