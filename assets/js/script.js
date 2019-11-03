function fecharModal() {
  $(".modalBG").fadeOut();
}

function addGroupModal() {
  var html = "<h1>Criar nova sala de Bate Papo</h1>";
  html +=
    "<input type='text' id='newGroupName' placeholder='Digite o nome da nova sala...'/>";
  html += "<br/><button id='newGroupButton'>Cadastrar</button>";
  html += "<hr/><button onclick='fecharModal();'>Fechar Janela</button>";
  $(".modalArea").html(html);
  $(".modalBG").fadeIn();
  $("#newGroupButton").on("click", function() {
    var newGroupName = $("#newGroupName").val();
    if (newGroupName != "") {
      chat.addNewGroup(newGroupName, function(json) {
        if (json.error == "0") {
          $(".addTab").trigger("click");
        } else {
          alert(json.errorMsg);
        }
      });
    }
  });
}

$(function() {
  if (groupList.length > 0) {
    for (var i in groupList) {
      chat.setGroup(groupList[i].Id, groupList[i].name);
    }
  }
  chat.chatActivity();
  chat.userListActivity();

  $(".addTab").on("click", function() {
    /*
    var chatId = window.prompt("Digite o ID do chat");
    var chatName = window.prompt("Digite o Nome do chat");
    chat.setGroup(chatId, chatName);
    */

    var html = "<h1>Escolha uma sala de Bate Papo</h1>";
    html += "<div id='groupList'>Carregando...</div>";

    html += "<hr/><button onclick='addGroupModal();'>Criar Nova Sala</button>";
    html += "<button onclick='fecharModal();'>Fechar Janela</button>";

    $(".modalArea").html(html);
    $(".modalBG").fadeIn();
    chat.loadGroupList(function(json) {
      var html = "";
      for (var i in json.list) {
        html +=
          "<button data-id='" +
          json.list[i].Id +
          "'>" +
          json.list[i].name +
          "</button>";
      }
      $("#groupList").html(html);

      $("#groupList")
        .find("button")
        .on("click", function() {
          var cid = $(this).attr("data-id");
          var cnm = $(this).text();

          chat.setGroup(cid, cnm);

          $(".modalBG").fadeOut();
          //if (chat.getActiveGroup() == 0) {
          // chat.setActiveGroup(cid);
          //}
        });
    });
  });
  $("nav ul").on("click", "li .groupName", function() {
    var id = $(this)
      .parent()
      .attr("data-id");
    chat.setActiveGroup(id);
  });
  $("nav ul").on("click", "li .groupClose", function() {
    var id = $(this)
      .parent()
      .attr("data-id");
    chat.removeGroup(id);
  });
  $("#senderInput").on("keyup", function(e) {
    if (e.keyCode == 13 && $(this).val() != "") {
      var msg = $(this).val();
      $(this).val("");
      chat.sendMessage(msg);
    }
  });

  //upload File
  $(".imgUploadBtn").on("click", function() {
    $("#senderInputImg").trigger("click");
  });
  $("#senderInputImg").on("change", function(e) {
    chat.sendPhoto(e.target.files[0]);
  });
});
