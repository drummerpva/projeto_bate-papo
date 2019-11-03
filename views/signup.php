<!DOCTYPE html>
<html>
    <head>
        <title>Chat - Cadastrar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="<?php echo BASE_URL; ?>assets/css/login.css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <?php if(!empty($msg)){?>
                <div class="warning"><?php echo $msg;?></div>
            <?php }?>
            <h2>Cadastre-se</h2>
            <form method="POST" >
                Usuário: <br>
                <input type="text" name="username" required><br><br>

                Senha: <br>
                <input type="password" name="pass" required><br><br>

                <input type="submit" value="Cadastrar"/>

            </form>
            <div style='clear:both;'></div>

        </div>
    </body>

</html>

