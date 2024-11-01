=== Simple Espace Table ===

Contributors: fbchville
Plugin Name: Simple Espace Table
Plugin URI: Plugins Web Page URL
Tags: espace, plugin, table, simple
Requires at least: 4.4
Tested up to: 4.9.8
Stable tag: 1.1.0
Version: 1.1.0
Requires PHP: 5.6

== Description ==
SIMPLE eSPACE TABLE (SeT) is designed to take the power of eSPACE, a product from CoolSolution Group, and output the event in a simple html table format to easily be shown on digital signage or a simple web view. The setup is easy and the configuration is a breeze. Just input your API key in settings and then customize one or more table views to output your event data.

== Frequently Asked Questions ==
#How to use?

-To display a table you simply use the shortcode `[simple-espace-table id="(the id)"]`

-You can add a table by simply going to [Tables](edit.php?post_type=crb_table)

-You need to specify an API Key in [Table Settings](admin.php?page=crb_carbon_fields_container_table_settings.php#!general)

#How it works

- This plugin relies on espace app server `https://app.espace.cool/`.

-We make a call to `https://app.espace.cool/api/v1/rest/events/occurrences` with the sepcified api key you entered in [Table Settings](admin.php?page=crb_carbon_fields_container_table_settings.php#!general)

- This call to the api doesn't send your private information to espace, it only sends the api key and gets the information.

- We get the events information for today or for a later date and show in in convinient styled table.

== Changelog ==
###-- Version 1.3 --
We've added a popup feature for the table.
You can customize the popup in Table settings.
The popup includes a title, date and time, location, event contact and campus location.

== Upgrade Notice ==
This is a new version, so no changes.After few updates we will update this readme

