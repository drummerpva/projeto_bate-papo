<!DOCTYPE html>
<html>
    <head>
        <title>Chat - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="<?php echo BASE_URL; ?>assets/css/login.css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <h2>Faça o Login</h2>
            <?php if (!empty($msg)) {?>
                <div class="warning"><?php echo $msg; ?></div>
            <?php }?>
            <form method="POST" action="<?php echo BASE_URL . "login/signin" ?>">
                Usuário: <br>
                <input type="text" name="username" required><br><br>

                Senha: <br>
                <input type="password" name="pass" required><br><br>

                <input type="submit" value="Entrar"/>

            </form>
            <div style='clear:both;'></div>
            <br>
            <a href="<?php echo BASE_URL . "login/signup" ?>">Cadastre-se</a>
        </div>
    </body>

</html>

