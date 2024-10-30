=== Connexion Logs ===
Contributors: floriansimunek
Donate link: https://www.paypal.com/donate?hosted_button_id=M4SD83EMAHYDU
Tags: wordpress logs, activity, user activity, user logs, logs
Requires at least: 4.6
Tested up to: 6.2
Stable tag: 3.0.2
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Are you a professional training organization ? Get the connexion logs of your users and connected members on your site in real time. The data thus obtained are compatible with CPF funding, the various OPCOs and other funders, for the training courses of your vocational training center, and which are accessible online.

== Description ==

Are you a professional training organization ? Or you simply want to check your users activity ?

Get the connexion logs of your users and connected members on your site in real time. The data are dispayed in a tabular form and allow you to see various informations such as :

-   The user's firstname and lastname.
-   The page he is browsing
-   The time he spent on each page with the URL
-   The time interval spent on entering and leaving the page

== Installation ==

This section describes how to install and activate the plugin.

1. Add the plugin to the `/ wp-content / plugins / plugin-name` folder, or you can directly install it from the plugins installation page on Wordpress.
1. Activate the plugin from the 'Plugin' page on Wordpress. You need to leave "Heartbeat" enabled in Wordpress (enabled by default).
1. It is done ! You have now installed and activated the plugin, all you have to do is consult the information in the table (in the 'WP Logs' section)

= IMPORTANT : If you use WPRocket =

Be careful to add cookie to "Never cache these Cookies"

1. WPRocket
1. Go to setting
1. Advanced rules
1. Never cache these Cookies
1. Add "WPLogs_Key"

== Frequently Asked Questions ==

= What information is it possible to retrieve ? =

-   The user's firstname and lastname.
-   The page it is on in real time and the time it has spent on it, as well as the time interval between arriving and leaving the page

= What features are available for the admin panel ? =

-   It is possible to sort the data in ascending or descending order on any column.
-   You can also delete an entry (a row) from the table if you wish.
-   And there is a filter field that allows you to filter the information of a column by writing what you want to search.

== Screenshots ==

1. Administrator table, display of user logs
2. Filter on a column
3. View a row
4. Informations about the row you want to delete
5. WPRocket - Never cache the cookie "WPLogs_key" (plugin not properly work if not enable)

== Changelog ==

= 3.0.2 (07/06/2023) =

-   Filters columns working properly again
-   Refresh button working properly again

= 3.0.1 (01/05/2023) =

-   Fixes

= 3.0.0 (26/04/2023) =

-   Cookie is now destroyed every page load
-   Add a warning to every WPRocket user
-   Add message if no data
-   Add PRO Version link

= 1.3.2 (14/04/2022) =

-   Fix errors

= 1.3.1 (06/04/2022) =

-   Stabilize language support

= 1.3.0 (05/04/2022) =

-   Add English support

= 1.2.0 (23/03/2022) =

-   Fix links url

= 1.1.2 (17/02/2022) =

-   Fix null variables

= 1.1.1 (07/01/2022) =

-   Code is cleaner
-   Add special character for ascending and descending filters

= 1.1.0 (06/01/2022) =

-   Restyle all the table
-   Navigation is easier
-   Add view options on rows

= 1.0.2 (04/11/2021) =

-   Fix admin imports links

= 1.0.1 (30/09/2021) =

-   Fix some admin page code

= 1.0.0 (11/09/2021) =

-   Display of logs and connected user information in real time
-   Possibility to delete entries (rows) from the table
-   Filter in ascending or descending order each column
-   Filter with one or more words to find the desired information in a column
