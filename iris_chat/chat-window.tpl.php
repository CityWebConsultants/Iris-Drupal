
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<div ng-controller="iris-template" ng-iris-template="users">

  {{drupal_user[1].field_username}}

</div>


<!--<div ng-controller="chat">

  <h1>Chat!</h1>

  <div ng-controller="iris-template" ng-iris-template="groups">

    <div ng-repeat="group in groups">

      <button data-group="{{group.eid}}" class="open-group">{{group.name}}</button>

    </div>

    <button id="newGroup">Create a group</button>

    <div ng-controller="iris-template" ng-iris-template="messages">


      <div ng-repeat="group in groups">

        <div ng-if="$parent.$parent.$parent.currentGroup == group.eid">

          <b>Members:</b> {{group.members}}

        </div>

      </div>

      <div ng-if="messages">

        <div>
          <ul>
            <li ng-repeat="message in messages">{{message.content}}</li>
          </ul>
        </div>
        <form id="chat">
          <input id="message" autocomplete="off" name="message">
          <input type="submit" value="send" />
        </form>

        <h2>Add members search</h2>

        <div ng-controller="iris-template" ng-iris-template="users">

          <input id="user" />

          <ul>

            <li ng-repeat="user in users" ng-if="user.eid != credentials.userid">

              <button class="addToGroup" data-userid={{user.eid}}>{{user.username}}</button>

            </li>

          </ul>

        </div>

      </div>
    </div>

  </div>
</div>-->


<!--<div ng-controller="chat">
   <div ng-controller="iris-template" ng-iris-template="groups">

    <div ng-repeat="group in groups">

      <button data-group="{{group.eid}}" class="open-group">{{group.name}}</button>

    </div>
  </div>
</div>-->


<div ng-controller="chat" id="outer-chat-window">
  <section class="chat-window" id="chat">
    <div id="responsive-heads">
      <h3 class="recent" data-panel="groupbar"><?php print t('Recent'); ?></h3>
      <h3 class="search" data-panel="chat-search-pane"><?php print t('Search'); ?></h3>
      <h3 class="chat-head active" data-panel="chat-panel"><?php print t('Chat...'); ?></h3>
    </div>
    <section>
      <div id="lookup-panel">
        <div id='lookup-header'>
          <h3 class="lookup-title recent active"><?php print l('Recent','javascript:void(0)',array('fragment' => '','external'=>true)); ?></h3>
          <h3 class="lookup-title search"><?php print l('Search','javascript:void(0)',array('fragment' => '','external'=>true)); ?></h3>
        </div>
        <div id="chat-search-pane" class="lookup-col-container">
          <form id="chat-search">
            <label>Search for users</label>

            <div ng-controller="iris-template" ng-iris-template="drupal_user">

              <input id="chat-search-field" />

              <ul> <!--id="chat-search-results"-->

                <li data-userid="{{user.field_drupal_uid}}" ng-bind-html="userSearchItem(user)" class="user" ng-repeat="user in drupal_user" ng-if="user.field_drupal_uid != credentials.userid"></li>

              </ul>
<!--<div ng-include="'/<?php print drupal_get_path('module', 'iris_chat');?>/templates/user-search.html'"></div>-->
            </div>
          </form>

        </div>

        <div id='groupbar' class="lookup-col-container open">
          <div ng-controller="iris-template" ng-iris-template="groups">
            <ul id='grouplist' class="lookup-col">
              
              <li class="group" data-group="{{group.eid}}" ng-bind-html="recentGroupItem(group)" class="group" ng-repeat="group in groups" ></li>
              
              
              <!--<li ng-repeat="group in groups" class="group" data-group="{{group.eid}}" class="open-group" title="{{group.name}}">
                <span class="image-container online-surround "><img src="/sites/all/themes/hub/img/hub-picture-default.png">  </span>
                <span>{{group.name}}</span>
                <span class="unread"></span>
              </li>-->
            </ul>
          </div>
        </div>

      </div>
      <div id="chat-panel" class="active">

        <div class="mediacall-window-surround window-surround" style="display: none;">
          <div class="calling"><span class="glyphicon glyphicon-earphone"></span><span><?php print t('Calling'); ?></span></div>
          <div id='mediacall-window'></div>
          <ul id='mediacallbuttons'>
            <li id="hangup" class='group-action group-action-hangup' style="display:none;" title="Hang up"><a href='javascript:void(0)'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hang up</a>
            </li>
          </ul>
        </div>

        <div id="conversation-wrapper">
          <div id='group-header'>
            <h2><?php print t('Chat...'); ?></h2>
            <div class="member-count-surround">
              <span id='member-count'></span>
              <ul id='group-members' style="display: none"></ul>
            </div>
            <div class="meeting-window-surround window-surround" style="display: none;">
              <h3>Meeting</h3>
              <div id="meeting-window"></div>
            </div>
          </div>
          <div id='conversation' data-groupid>

            <div class="conversation-inner" ng-controller="iris-template" ng-iris-template="messages">


              <div ng-repeat="group in groups">

                <div ng-if="$parent.$parent.$parent.currentGroup == group.eid">

                  <b>Members:</b>

                </div>

              </div>

              <div class="message-window" ng-if="messages">

                <ul>
                  <li ng-repeat="message in messages">{{message.content}}</li>
                </ul>

                <form class='submit-message-from'>

                  <input class='message-send' type='submit' value='send' />
                  <div class='submit-message-box'>
                    <span id="typing"></span>
                    <input class='message-textfield' id='messageinput' name="message" autocomplete='off' />
                  </div>
                </form>

              </div>
            </div>

          </div>
          <!--<form class='submit-message-from'>
        <input class='message-send' type='submit' value='send' />
        <div class='submit-message-box'>
          <span id="typing"></span>
          <input class='message-textfield' id='messageinput' autocomplete='off' />
        </div>
      </form>-->

          <ul class='group-actions'>
            <li class='group-action group-action-in-bar group-action-add-user' style="display:none;">
              <a><span class='glyphicon glyphicon-plus' aria-hidden='true'></span><?php print t('Add user'); ?></a>
            </li>
            <li class='group-action group-action-in-bar group-action-rename' style="display:none;">
              <a><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span><?php print t('Rename group'); ?></a>
            </li>
            <li class='group-action group-action-in-bar group-action-leave' style="display:none;">
              <a><span class='glyphicon glyphicon-log-out' aria-hidden='true'></span><?php print t('Leave group'); ?></a>
            </li>
            <li class='group-action group-action-in-bar group-action-send-file' style="display:none;">
              <a><span class="glyphicon glyphicon-file" aria-hidden="true"></span><?php print t('Send file'); ?></a>
            </li>
            <li class='group-action group-action-in-bar group-action-voicecall' style="display:none;">
              <a><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php print t('Call'); ?></a>
            </li>
            <li class='group-action group-action-in-bar group-action-videocall' style="display:none;">
              <a><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span><?php print t('Video call'); ?></a>
            </li>
          </ul>

          <div id="fileupload" style="display: none">
            <input type="file" id="files" name="files[]" />
          </div>
        </div>
      </div>
    </section>
  </section>

  <div class="chat-window">
    <?php if (arg(0) != 'chat') : ?>
      <div id="popout-link">
        <a target="_blank" href="javascript:void(0)">Open in popout <i class="glyphicon glyphicon-new-window"></i></a>
      </div>
      <?php endif; ?>
  </div>
</div>
