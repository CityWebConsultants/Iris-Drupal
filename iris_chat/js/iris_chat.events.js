(function ($) {

  $(document).ready(function () {

    // View a group's messages

    document.addEventListener('entityListUpdate', function (e) {

      if (e.detail.entities.message) {
        $('.message-window ul')[0].scrollTop = $('.message-window ul')[0].scrollHeight;
      } else if (e.detail.entities.group) {
        e.detail.entities.group.forEach(function (group, index) {
          var current = iris.unread;
          iris.unread += group.unread;

          if (current === 0 && iris.unread > 0) {

            document.title = "(" + iris.unread + ")" + " " + document.title;

          } else if (current > 0 && iris.unread === 0) {

            document.title = document.title.replace("(" + current + ")" + " ", "");

          } else {

            document.title = document.title.replace("(" + current + ")" + " ", "(" + iris.unread + ")" + " ");

          }
        });
      }


    }, false);


    $("body").on("click", "#grouplist .group", function (e) {

      var groupid = jQuery(this).data("group");

      iris.currentGroup = groupid;
      iris.setActiveGroup(groupid, false);
      iris.fetchEntities("messages", {
        entities: ["message"],
        queries: [{
          "field": "groups",
          "operator": "includes",
          "value": groupid
        }],
        sort: {
          field_created: 'asc'
        }

      });

      iris.fetchEntities("members", {
        entities: ["group"],
        queries: [{
          "field": "eid",
          "operator": "IS",
          "value": groupid
        }]

      });

    });

    $("body").on("click", ".members-view, #message-count", function (e) {
      $(this).parent().toggleClass('closed');
    });

    // Post a message

    $("body").on("submit", ".submit-message-from", function (e) {

      var value = $(".message-textfield", $(this)).val();

      $(".message-textfield", $(this)).val("");

      iris.createMessage(iris.credentials, value, [iris.currentGroup]);

      return false;

    });

    // Search for users

    $("body").on("keyup", "#chat-search-field", function () {

      var value = $("#chat-search-field").val();

      if (value.length) {

        iris.fetchEntities("drupal_user", {
          entities: ["drupal_user"],
          queries: [{
            "field": "field_username",
            "operator": "contains",
            "value": $("#chat-search-field").val()
            }]

        });

      } else {

        iris.fetchEntities("drupal_user", {

          entities: ["drupal_user"],
          queries: [{
            "field": "field_username",
            "operator": "is",
            "value": "empty"
                    }]

        });
      }

    });


    // Create new group by selecting user from search results.
    $('body').on('click', '#chat-search li span:not(.add)', function (e) {

      var current_uid = iris.credentials.userid;
      var selected_uid = jQuery(this).parent().data('userid');

      var groupId = iris.groupExists(selected_uid)
      if (groupId) {
        iris.togglerecent();
        $('#grouplist .group[data-group=' + groupId + ']').click();
        return false;
      }

      var entity = {
        name: iris.generateGroupName([current_uid, selected_uid]),
        field_121: true,
        field_users: [{
          field_uid: current_uid
                    }, {
          field_uid: selected_uid
                    }]
      };

      iris.createGroup(entity);


    });

    // Add a member to the group or create new multi-user group.
    $("body").on("click", "#chat-search li span.add", function (e) {

      var selected_uid = $(this).parent().data("userid");

      if (iris.userExistsInGroup(iris.fetchedEntities.group[iris.currentGroup], selected_uid)) {

        alert("User already exists in this group.");
        return false;

      } else {

        // If it's not a 121 group, add user to current group.
        if (iris.fetchedEntities.group[iris.currentGroup].field_121 !== true) {

          var groupEntity = iris.fetchedEntities.group[iris.currentGroup];
          groupEntity.field_users.push({
            field_uid: selected_uid
          });

          groupEntity.name = iris.generateGroupName(iris.getGroupUserIds(groupEntity.field_users));

          iris.editGroup(groupEntity);

        } else {
          // Create new multi-user group.

          var users = JSON.parse(JSON.stringify(iris.fetchedEntities.group[iris.currentGroup].field_users));
          users.push({
            field_uid: selected_uid
          });
          var name = iris.generateGroupName(iris.getGroupUserIds(users));
          var entity = {
            name: name,
            field_users: users
          };

          iris.createGroup(entity);

        }


        /*if ($scope.currentGroup) {
          jQuery.post(iris.server + '/groups/addMember/' + $scope.currentGroup + '/' + userid + '/drupal_user/field_users.field_uid', {
            credentials: iris.credentials
          }, function (err, result) {

            console.log(err, result);

          });
        }*/
      }

    });


    jQuery(".lookup-title.recent").click(iris.togglerecent);
    jQuery(".lookup-title.search").click(iris.togglesearch);

  });
}(jQuery))
