var chat = {
  groups: [],
  activeGroup: 0,
  lastTime: "",
  msgRequest: null,
  userRequest: null,

  setGroup: function(id, name) {
    var found = false;
    for (var i in this.groups) {
      if (this.groups[i].id == id) {
        found = true;
      }
    }
    if (found == false) {
      this.groups.push({
        id: id,
        name: name,
        messages: [],
        users: ["Douglas", "Elaine", "Osvaldo", "Ciclano"]
      });
    }
    if (this.groups.length == 1) {
      this.setActiveGroup(id);
    }
    this.updateGroupView();
    if (this.msgRequest != null) {
      this.msgRequest.abort();
    }
  },

  removeGroup: function(id) {
    for (var i in this.groups) {
      if (this.groups[i].id == id) {
        this.groups.splice(i, 1);
      }
    }
    if (this.activeGroup == id) {
      if (this.groups.length > 0) {
        this.setActiveGroup(this.groups[0].id);
      } else {
        this.setActiveGroup(0);
      }
    }
    this.updateGroupView();
    if (this.msgRequest != null) {
      this.msgRequest.abort();
    }
  },

  getGroups: function() {
    return this.groups;
  },

  updateGroupView: function() {
    var html = "";
    for (var i in this.groups) {
      html +=
        "<li data-id='" +
        this.groups[i].id +
        "'>" +
        "<div class='groupName'>" +
        this.groups[i].name +
        "</div>" +
        "<div class='groupClose'>X</div>" +
        "</li>";
    }
    $("nav ul").html(html);
    this.loadConversation();
  },
  loadGroupList: function(ajaxCallback) {
    var url = BASE_URL + "ajax/getGroups";
    $.ajax({
      url: url,
      type: "GET",
      dataType: "json",
      success: function(json) {
        if (json.status == "1") {
          ajaxCallback(json);
        } else {
          window.location.href = BASE_URL;
        }
      }
    });
  },
  addNewGroup: function(groupName, ajaxCallback) {
    var url = BASE_URL + "ajax/addGroup";
    $.ajax({
      url: url,
      type: "POST",
      dataType: "json",
      data: { name: groupName },
      success: function(json) {
        if (json.status == "1") {
          ajaxCallback(json);
        } else {
          window.location.href = BASE_URL;
        }
      }
    });
  },

  setActiveGroup: function(id) {
    this.activeGroup = id;
    this.loadConversation();
  },

  getActiveGroup: function() {
    return this.activeGroup;
  },

  loadConversation: function() {
    $("nav ul")
      .find(".activeGroup")
      .removeClass("activeGroup");
    $("nav ul")
      .find("li[data-id='" + this.activeGroup + "']")
      .addClass("activeGroup");

    //pegar conversa daquele Grupo

    this.showMessages();
    this.showUserList();
  },

  showUserList: function() {
    if (this.activeGroup != 0) {
      var users = [];
      for (var i in this.groups) {
        if (this.groups[i].id == this.getActiveGroup()) {
          users = this.groups[i].users;
        }
      }
      var html = "";
      for (var i in users) {
        html += "<li>" + users[i] + "</li>";
      }
      $(".userList ul").html(html);
    } else {
      $(".userList ul").html("");
    }
  },

  showMessages: function() {
    $(".messages").html("");
    if (this.getActiveGroup() != 0) {
      var msgs = [];
      for (var i in this.groups) {
        if (this.groups[i].id == this.getActiveGroup()) {
          msgs = this.groups[i].messages;
        }
      }
      for (var i in msgs) {
        var html =
          '<div class="message">' +
          '<div class="mInfo">' +
          '<span class="mSender">' +
          msgs[i].senderName +
          "</span> - " +
          '<span class="mDate">' +
          msgs[i].senderDate +
          "</span>" +
          "</div>" +
          '<div class="mBody">';
        if (msgs[i].msg_type == "text") {
          html += msgs[i].msg;
        } else if (msgs[i].msg_type == "img") {
          html +=
            "<img src='" + BASE_URL + "media/images/" + msgs[i].msg + "' />";
        }

        html += "</div>" + "</div>";
        $(".messages").append(html);
      }
    }
  },
  sendMessage: function(msg) {
    if (msg.length > 0 && this.getActiveGroup() != 0) {
      var url = BASE_URL + "ajax/addMessage";
      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: { idGroup: this.getActiveGroup(), msg: msg },
        success: function(json) {
          if (json.status == "1") {
            if (json.error == "1") {
              alert(json.errorMsg);
            }
          } else {
            window.location.href = BASE_URL;
          }
        }
      });
    }
  },
  sendPhoto: function(img) {
    if (this.getActiveGroup() != 0) {
      var url = BASE_URL + "ajax/addPhoto";
      var formData = new FormData();
      formData.append("img", img);
      formData.append("idGroup", chat.activeGroup);
      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        success: function(json) {
          if (json.status == "1") {
            if (json.error == "1") {
              alert(json.errorMsg);
            }
          } else {
            window.location.href = BASE_URL;
          }
        },
        xhr: function() {
          var xhrDefault = $.ajaxSettings.xhr();
          if (xhrDefault.upload) {
            xhrDefault.upload.addEventListener(
              "progress",
              function(p) {
                var total = p.total;
                var loaded = p.loaded;
                var pct = (total / loaded) * 100;
                if (pct > 0) {
                  $(".progressBar").css("width", pct + "%");
                  $(".progress").slideDown();
                }

                if (pct >= 100) {
                  $(".progressBar").css("width", "0%");
                  $(".progress").slideUp();
                }
              },
              false
            );
          }
          return xhrDefault;
        }
      });
    }
  },

  updateLastTime: function(lastTime) {
    this.lastTime = lastTime;
  },

  insertMessage: function(item) {
    for (var i in this.groups) {
      if (this.groups[i].id == item.id_group) {
        var dateMsg = item.date_msg.split(" ");
        dateMsg = dateMsg[1];
        this.groups[i].messages.push({
          id: item.Id,
          senderId: item.id_user,
          senderName: item.username,
          senderDate: dateMsg,
          msg: item.msg,
          msg_type: item.msg_type
        });
      }
    }
  },

  updateUserList: function(list, g) {
    for (var i in this.groups) {
      if (this.groups[i].id == g) {
        this.groups[i].users = list;
      }
    }
  },

  chatActivity: function() {
    var url = BASE_URL + "ajax/getMessages";
    var gs = this.getGroups();
    var groups = [];
    for (var i in gs) {
      groups.push(gs[i].id);
    }
    if (groups.length > 0) {
      this.msgRequest = $.ajax({
        url: url,
        type: "GET",
        data: { lastTime: this.lastTime, groups: groups },
        dataType: "json",
        success: function(json) {
          if (json.status == "1") {
            chat.updateLastTime(json.lastTime);
            for (var i in json.msgs) {
              chat.insertMessage(json.msgs[i]);
            }
            chat.loadConversation();
          } else {
            window.location.href = BASE_URL;
          }
        },
        complete: function() {
          chat.chatActivity();
        }
      });
    } else {
      setTimeout(function() {
        chat.chatActivity();
      }, 1000);
    }
  },

  userListActivity: function() {
    var gs = this.getGroups();
    var groups = [];
    for (var i in gs) {
      groups.push(gs[i].id);
    }
    if (groups.length > 0) {
      var url = BASE_URL + "ajax/getUserList";
      this.userRequest = $.ajax({
        url: url,
        type: "GET",
        data: { lastTime: this.lastTime, groups: groups },
        dataType: "json",
        success: function(json) {
          if (json.status == "1") {
            for (var i in json.users) {
              chat.updateUserList(json.users[i], i);
            }

            chat.showUserList();
          } else {
            window.location.href = BASE_URL;
          }
        },
        complete: function() {
          setTimeout(function() {
            chat.userListActivity();
          }, 5000);
        }
      });
    } else {
      setTimeout(function() {
        chat.userListActivity();
      }, 1000);
    }
  }
};
