=== Allow PHP in Posts and Pages ===
Contributors: Hit Reach
Donate link: 
Tags: post, pages, posts, code, php, shortcode, 
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: 2.1.0

Allow PHP in posts and pages allows you to add php functionality to Wordpress Posts and Pages

== Description ==

Allow PHP in posts and pages adds the functionality to include PHP in wordpress posts and pages by adding a simple shortcode [php].code.[/php]

This plugin strips away the automatically generated wordpress &lt;p&gt; and &lt;br/&gt; tags but still allows the addition of your own &lt;p&gt; and &lt;br/&gt; tags 

Please update immeadiatly if using version 1.2.2

== Usage ==

To add the PHP code to your post or page simply place any PHP code inside the shortcode tags.

For example: If you wanted to add content that is visible to a particular user id:



	[php]
	 global $user_ID;
	 if($user_ID == 1){
	  echo "Hello World";
	 }
	[/php]
	

This code will output Hello World to only user id #1, and no one else

in addition, should this code not be working (for example a missing ";") simply just change the [php] to be [php debug=1]


     [php debug=1]
      global $user_ID;
      if($user_ID == 1){
       echo "Hello World"
      }
      [/php]
	

Will result in the output: 

	
     Parse error: syntax error, unexpected '}', expecting ',' or ';' in XXX : eval()'d code on line 5
     global $user_ID; 
     if($user_ID == 1){ 
       echo "Hello World" 
     } 

To use the new saved code parts, just add a function=xxx where xxx is the id to the APIP shortcode.


	[php function=1]
	

== Some Important Notes ==

This plugin strips away all instances of &lt;p&gt; and &lt;br /&gt; therefore code has been added so that if you wish to use tags in your output (e.g.): 
     [php]
      echo "hello <br /> world";
     [/php]
	

the &lt; and &gt; tags will need to be swapped for [ and ] respectively so &lt;p&gt; becomes [p] and &lt;/p&gt; becomes [/p] which is converted back to &lt;p&gt; at runtime. these [ ] work for all tags (p, strong, em etc.). 

     [php]
      echo "hello [br /] world";
     [/php]

== Installation ==

1. Extract the zip file and drop the contents in the wp-content/plugins/ directory of your WordPress installation
1. Activate the Plugin from Plugins page

== Misc ==
Developed by <a href='http://www.hitreach.co.uk' target="_blank" style='text-decoration:none;'>Hit Reach</a>

Check out our other <a href='http://www.hitreach.co.uk/services/wordpress-plugins/' target="_blank" style='text-decoration:none;'>Wordpress Plugins</a>

Version: 2.1.0 <a href='http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages/' target="_blank" style='text-decoration:none;'>Support & Comments</a>

== Change log ==
= 1.0 =
 * Initial Release
= 1.1 =
 * Bug fix for the conversion of the right square bracket
= 1.2 =
 * Character Conversion Fixes
= 1.2.3 =
 * Fixed major issue with 1.2.2
= 2.0.0.RC1 =
 * Addition of Code Snippets function to the plugin
 * Minor Bug Fixes
 * New Options Pages
 * TinyMCE editor button
 * allow shortcodes in text widgets by default
= 2.1.0 =
 * Overall file tightening and maintenance

== Frequently Asked Questions ==
= What Tags Are Automatically Removed? =
Currently all &lt;br /&gt; and &lt;p&gt; (and its closing counterpart) tags are removed from the input code because these are the tags that Wordpress automatically add.
= How Do I Add Tags Without Them Being Stripped? =
If you want to echo a paragraph tag or a line break, or any other tag (strong, em etc) instead of enclosing them in &lt; and &gt; tags, enclose them in [ ] brackets for example [p] instead of &lt;p&gt; The square brackets are converted after the inital tags are stripped and function as normal tags.
= Thats All Good But I want To Include A [ and ] In My Output! =
To include square brackets in your output simply add a \ before it so [ becomes \[ and ] becomes \], again these are converted and will display as [ and ]
= Can I still connect to non-wordpress databases? = 
Yes you can, just use the standard mysql_connect or the mysql_pconnect and their parameters.
= My Question Is Not Answered Here! =
If your question is not listed here please look on: <a href='http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages/' target="_blank" style='text-decoration:none;'>http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages/</a> and if the answer is not listed there, just leave a comment
