<div class="container">
    <div class="progress">
        <div class="progressBar" style="width: 25%;"></div>
    </div>
    <div class="userInfo">
        Logado como: <b><?php echo $name ?? "";?></b> - <a href="<?php echo BASE_URL."login/logOut";?>">Sair</a>
    </div>
  <nav>
    <ul></ul>
    <button class="addTab">+</button>
  </nav>

  <section>
      <div class="messages"></div>
    <div class="userList">
        <ul>
        </ul>
    </div>

</section>

  <footer>
    <div class="senderArea">
        <input type="file" id="senderInputImg">
      <input
        type="text"
        id="senderInput"
        placeholder="Digite aqui sua mensagem!"
        
      />
      <div class="senderTools">
            <div class="senderTool imgUploadBtn"></div>
            <div class="senderTool"></div>
    </div>
    </div>
  </footer>
</div>
