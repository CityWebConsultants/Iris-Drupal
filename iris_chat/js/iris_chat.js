(function ($) {

  $(document).ready(function () {

    iris.angular.controller("chat", ["$scope", "$element", "$attrs", "$timeout", "$sce", function ($scope, $element, $attrs, $timeout, $sce) {

      // Angular functions.
      $scope.userSearchItem = function (obj) {
        return $sce.trustAsHtml(Drupal.theme.prototype.UserSearchItem(obj, $scope));
      }

      $scope.recentGroupItem = function (group) {
        return $sce.trustAsHtml(Drupal.theme.prototype.GroupListItem(group, $scope));
      }

      $scope.listMembersDisplay = function (member) {
        return $sce.trustAsHtml(Drupal.theme.prototype.listMembersDisplay(member, $scope));
      }

      iris.server = decodeURIComponent(readCookie("Drupal.visitor.iris_server"));
      iris.currentGroup = null;
      $scope.currentGroup = iris.currentGroup;

      iris.fetchEntities("groups", {
        entities: ["group"],
        queries: [{
          "field": "field_users.field_uid",
          "operator": "IS",
          "value": iris.credentials.userid
        }],
        sort: {
          "field_last_updated": "desc"
        },

      });

      iris.fetchEntities("users", {

        entities: ["user"]

      });

   }]);

  });
  
})(jQuery);;
