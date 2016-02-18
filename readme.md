# Iris intergration module for Drupal

Very simple Iris authentication integration for a Drupal 7 site.

## Instructions

* Install the module
* Head over to `admin/config/iris/settings`
* Set a username and password that corresponds to an Iris user with the Can Make Authtoken permission.
* Set the url to the url of your Iris site.
* Navigate to a page as a logged in user and you should have a valid socket.io connection (socket.io is loaded automatically) which pairs to the server.
* You'll also get an iris.credentials object to use in HTTP requests and an iris.url variable for the Iris server address. These are taken from cookies that Drupal saves.

On the Iris side you will need to ensure the group and message entity types are installed (place in your site/configurations/entity folder). You will also need to ensure the Iris uer entity type has a numeric field_external_id field.