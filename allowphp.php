<?php
/*
Plugin Name: Allow PHP in posts and pages
version: 2.1.0
Plugin URI: http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages/
Description: Allow PHP in posts and pages allows you to add php functionality to Wordpress Posts and Pages whilst still retaining HTML tags
Author: Hit Reach
Author URI: http://www.hitreach.co.uk/
*/
add_shortcode('php','php_handler');
add_shortcode('PHP','php_handler');
add_shortcode('allowphp','php_handler');
add_shortcode('ALLOWPHP','php_handler');
add_action('admin_menu', 'allow_php_menu');
add_filter('widget_text', 'do_shortcode');
register_activation_hook(__FILE__, 'allowPHP_activate');
global $dbVersion; $dbVersion = "1.0.0";
define("ALLOWPHPVERSION","2.1.0");
define("APIP_URL", WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));


function php_handler($args, $content=null){
	global $is_comment;
	global $wpdb;
	if($is_comment){return "";}
	extract( shortcode_atts(array('debug' => 0, 'function' => -1), $args));
	if($args['debug'] == 1){error_reporting(E_ALL);ini_set("display_errors","1");}
	if($function == ""){$function == "-1";}
	if($function == -1){
$content =(htmlspecialchars($content,ENT_QUOTES));$content = str_replace("&amp;#8217;","'",$content);$content = str_replace("&amp;#8216;","'",$content);$content = str_replace("&amp;#8242;","'",$content);$content = str_replace("&amp;#8220;","\"",$content);$content = str_replace("&amp;#8221;","\"",$content);$content = str_replace("&amp;#8243;","\"",$content);$content = str_replace("&amp;#039;","'",$content);$content = str_replace("&#039;","'",$content);$content = str_replace("&amp;#038;","&",$content);$content = str_replace("&amp;lt;br /&amp;gt;"," ", $content);$content = htmlspecialchars_decode($content);$content = str_replace("<br />"," ",$content);$content = str_replace("<p>"," ",$content);$content = str_replace("</p>"," ",$content);$content = str_replace("[br/]","<br/>",$content);$content = str_replace("\\[","&#91;",$content);$content = str_replace("\\]","&#93;",$content);$content = str_replace("[","<",$content);$content = str_replace("]",">",$content);$content = str_replace("&#91;",'[',$content);$content = str_replace("&#93;",']',$content);$content = str_replace("&gt;",'>',$content);$content = str_replace("&lt;",'<',$content);
	}
	else{
		$options = get_option("allowPHP_options");
		$show404 = $options['show404'];
		$fourohfourmsg = $options['fourohfourmsg'];
		if($fourohfourmsg != 0){
			$fourohfourmsg = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."allowPHP_functions WHERE id = '".$fourohfourmsg."';");
			$fourohfourmsg = $fourohfourmsg[0]->function;
		}
		else{
			$fourohfourmsg = '?><div style="font-weight:bold; color:red">Error 404: Function Not Found</div>';
		}
		$id = $args['function'];
		$sql = "SELECT function FROM ".$wpdb->prefix."allowPHP_functions WHERE id='".$id."'";
		$res = $wpdb->get_results($wpdb->prepare($sql));
		if(sizeof($res) == 0){	if($show404 == 1){$content = $fourohfourmsg;}}
		else{$content = $res[0]->function;}
	}
	ob_start();
		eval ($content);
		if($args['debug'] == 1){
			if(sizeof($res)==0 && $function != -1){
				$content = "Function id : $function : cannot be found<br/>";
			}else{
				$content =(htmlspecialchars($content,ENT_QUOTES));
			}
			echo ("<pre>".$content."</pre>");
		}
	$returned = ob_get_clean();
	return $returned;
}

function allow_php_menu(){
	add_menu_page( "Allow PHP in posts and pages", "Allow PHP in posts", "manage_options", "allow-php-menu", "allowPHP_functions");
	add_submenu_page('allow-php-menu','Information', 'Information', 'manage_options', 'allow-php-information', 'allow_php_information');
}

function allow_php_information(){
	?>
	<script type="text/javascript">
		var APIP_current = "APIP_general";
		var APIP_currentTab = "APIP_generalTab";
		function APIP_changeTab(APIP_new, APIP_newTab){
			document.getElementById(APIP_current).style.display="none";
			document.getElementById(APIP_currentTab).className="APIP_tab";
			document.getElementById(APIP_new).style.display="block";
			document.getElementById(APIP_newTab).className="APIP_currentTab";
			APIP_current = APIP_new;
			APIP_currentTab = APIP_newTab;
		}
	</script>
	<style type="text/css">
		#APIP_navigation{font-size:12px; line-height:25px;}
		#APIP_navigation a.APIP_currentTab, #APIP_navigation a.APIP_tab{padding:5px; border:1px #ddd solid;border-bottom:none; line-height:25px;cursor:pointer;}
		#APIP_navigation a.APIP_currentTab{border:1px #666 solid; border-bottom:1px white solid; background-color:white;}
		#APIP_usage,#APIP_notes,#APIP_tags{display:none;}
		#APIP_navigation, #APIP_container{width:98%; margin:0 auto;}
		#APIP_container{border:1px #ddd solid; background:white; padding:15px;}
	</style>
    <h1>Allow PHP in Posts and Pages</h1>
	<div style='width:1145px;'>
	    <div style='width:500px; float:right;'>
	        <?php APIP_appeal();?>
		</div>
		<div style='width:630px; float:left;'>
			<div id='APIP_navigation'>
				<a onclick="APIP_changeTab('APIP_general','APIP_generalTab')" name='APIP_generalTab' id='APIP_generalTab' class='APIP_currentTab'>General Information</a>
			    <a onclick="APIP_changeTab('APIP_usage','APIP_usageTab')" name='APIP_usageTab' id='APIP_usageTab' class='APIP_tab'>Usage</a>
			    <a onclick="APIP_changeTab('APIP_notes','APIP_notesTab')" name='APIP_notesTab' id='APIP_notesTab' class='APIP_tab'>Important Information</a>
			    <a onclick="APIP_changeTab('APIP_tags','APIP_tagsTab')" name='APIP_tagsTab' id='APIP_tagsTab' class='APIP_tab'>Tag List</a>
			    <a href="?page=allow-php-menu" name='APIP_optionsTab' id='APIP_optionsTab' class='APIP_tab'>Plugin Options</a>
			</div>
			<div id='APIP_container'>
			    <div id='APIP_general'>
			    	<h2>General Information</h2>
			        <p>Allow PHP in posts and pages adds the functionality to include PHP in your WordPress posts and pages by adding a simple shortcode <span style='color:green'>[php]</span> <em>your code</em> <span style='color:green'>[/php]</span></p>
			        <p>This plugin strips away the automatically generated wordpress &lt;p&gt; and &lt;br/&gt; tags but still allows the addition of your own &lt;p&gt; and &lt;br/&gt; tags using a tag replacement system.</p>
			        <p>Also, you can now save your most used PHP codes as &quot;snippets&quot; which you can insert into multiple pages at once.</p>
			    </div>
			    <div id='APIP_usage'>
			        <h2>Usage</h2>
			        <p>To add the PHP code to your post or page simply place any PHP code inside the shortcode tags.</p>
			        <p><em>For example: </em>If you wanted to add content that is visible to a particular user id:</p>
			        <blockquote>
			        [php]<br/>
			        &nbsp;&nbsp;&nbsp;global $user_ID;<br/>
			        &nbsp;&nbsp;&nbsp;if($user_ID == 1){<br/>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "Hello World";<br/>
			        &nbsp;&nbsp;&nbsp;}<br/>
			        [/php]
			        </blockquote>
			        <p><em>This code will output Hello World to only user id #1, and no one else</em></p>
			        <p>In addition, should this code not be working (for example a missing ";") simply just change the [php] to be [php debug=1]</p>
			        <blockquote>
			        [php debug=1]<br/>
			        &nbsp;&nbsp;&nbsp;global $user_ID;<br/>
			        &nbsp;&nbsp;&nbsp;if($user_ID == 1){<br/>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "Hello World"<br/>
			        &nbsp;&nbsp;&nbsp;}<br/>
			        [/php]
			        </blockquote>
			        <p><em>Will result in the output:</em></p>
			        <blockquote>
			        &nbsp;&nbsp;&nbsp;Parse error: syntax error, unexpected '}', expecting ',' or ';' in XXX : eval()'d code on line 5<br/>
			        &nbsp;&nbsp;&nbsp;global $user_ID; <br/>
			        &nbsp;&nbsp;&nbsp;if($user_ID == 1){ <br/>
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo "Hello World" <br/>
			        &nbsp;&nbsp;&nbsp;}
			        </blockquote>
			    </div>
			    <div id='APIP_notes'>
			        <h2>Some Important Notes</h2>
			        <p>This plugin strips away all instances of &lt;p&gt; and &lt;br /&gt; therefore code has been added so that if you wish to use tags in your output (e.g.):</p>
			        <blockquote>
			        [php]<br/>
			        &nbsp;&nbsp;&nbsp;echo "hello &lt;br /&gt; world";<br/>
			        [/php]
			        </blockquote>
			        <p>The &lt; and &gt; tags will need to be swapped for [ and ] respectively so &lt;p&gt; becomes [p] and  &lt;/p&gt; becomes [/p] which is converted back to &lt;p&gt; at runtime.  these [ ] work for all tags (p, strong, em etc.).</p>
			        <blockquote>
			        [php]<br/>
			        &nbsp;&nbsp;&nbsp;echo "hello [br /] world";<br/>
			        [/php]
			        </blockquote>
			    </div>
			    <div id='APIP_tags'>
			        <h2>Tag list</h2>
			        <table cellpadding="5" cellspacing="1" style='border:1px #ddd solid' width='60%'>

			            <tr>
			                <th align="left" style="padding:5px; background:#ffffcc">For</th>
			                <th align="left" style="padding:5px; background:#ffffcc">Write as</th>
			            </tr>
			            <tr>
			                <td align="left"  style="padding:5px; background:#ffffcc">&lt;p&gt; ... &lt;/p&gt;</td>
			                <td align="left" style="padding:5px; background:#ffffcc">[p] ... [/p]</td>
			            </tr>
			            <tr>
			                <td align="left"  style="padding:5px; background:#ffffcc">&lt;em&gt;...&lt;/em&gt;</td>
			                <td align="left"  style="padding:5px; background:#ffffcc">[em]...[/em]</td>
			            </tr>
			            <tr>
			                <td align="left"  style="padding:5px; background:#ffffcc">&lt;p style=''&gt; ... &lt;/p&gt;</td>
			                <td align="left"  style="padding:5px; background:#ffffcc">[p style=''] ... [/p]</td>
			            </tr>
			            <tr>
			                <td align="left"  style="padding:5px; background:#ffffcc">&lt;u&gt; ... &lt;/u&gt;</td>
			                <td align="left"  style="padding:5px; background:#ffffcc">[u] ... [/u]</td>
			            </tr>
			            <tr>
			                <td align="left"  style="padding:5px; background:#ffffcc">&lt;br /&gt;</td>
			                <td align="left"  style="padding:5px; background:#ffffcc">[br /]</td>
			            </tr>

			        </table>
			    </div>
			</div>
		</div>
	</div>
	<?php
}

function allowPHP_functions(){
	$activeTab = "";
	if( isset( $_GET['tab'] ) ){
		if("cs" == $_GET['tab'] ){
			$activeTab = "CS";
		}
	}
	global $wpdb;
	$options = get_option("allowPHP_options");
	$show404 = $options['show404'];
	$fourohfourmsg = $options['fourohfourmsg'];
	$fourohfourmsg_id = $options['fourohfourmsg'];
	if($fourohfourmsg != 0){
		$fourohfourmsg = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."allowPHP_functions WHERE id = '".$fourohfourmsg."';"));
		$fourohfourmsg = $fourohfourmsg[0]->function;
	}
	else{$fourohfourmsg = '<span style="font-weight:bold; color:red">Error 404: Function Not Found</span>';}

	$sql = "SELECT * FROM ".$wpdb->prefix."allowPHP_functions";
	$results = $wpdb->get_results($wpdb->prepare($sql));
	?>
	<script type="text/javascript">
	function confirmMod(id){
		return confirm("Are you sure you want to modify row id: "+id+"?");
	}
	function confirmDel(id){
		return confirm("Are you sure you want to delete row id: "+id+"?");
	}
	var APIP_current = "APIP_general";
    var APIP_currentTab = "APIP_generalTab";
    function APIP_changeTab(APIP_new, APIP_newTab){
        document.getElementById(APIP_current).style.display="none";
        document.getElementById(APIP_currentTab).className="APIP_tab";
        document.getElementById(APIP_new).style.display="block";
        document.getElementById(APIP_newTab).className="APIP_currentTab";
        APIP_current = APIP_new;
        APIP_currentTab = APIP_newTab;
    }
	</script>
	<style type="text/css">
		#APIP_navigation{font-size:12px; line-height:25px;}
		#APIP_navigation a.APIP_currentTab, #APIP_navigation a.APIP_tab{padding:5px; border:1px #ddd solid;border-bottom:none; line-height:25px;cursor:pointer;}
		#APIP_navigation a.APIP_currentTab{border:1px #666 solid; border-bottom:1px white solid; background-color:white;}
		#APIP_usage,#APIP_notes,#APIP_tags{display:none;}
		#APIP_navigation, #APIP_container{width:98%; margin:0 auto;}
		#APIP_container{border:1px #ddd solid; background:white; padding:15px;}
    </style>
	<h1>Allow PHP in Posts and Pages</h1>
	<div style='width:1145px;'>
		<div style='width:500px; float:right;'>
        	<?php APIP_Appeal()?>
		</div>
    	<div style='width:630px; float:left;'>
        	<div id='APIP_navigation'>
            	<a onclick="APIP_changeTab('APIP_general','APIP_generalTab')" name='APIP_generalTab' id='APIP_generalTab' class='<?php if( "" == $activeTab){echo "APIP_currentTab";}else{echo "APIP_tab";}?>'>Plugin Options</a>
            	<a onclick="APIP_changeTab('APIP_usage','APIP_usageTab')" name='APIP_usageTab' id='APIP_usageTab' class='<?php if( "CS" == $activeTab){echo "APIP_currentTab";}else{echo "APIP_tab";}?>'>Code Snippets</a>
            	<a href='?page=allow-php-information' name='APIP_notesTab' id='APIP_notesTab' class='APIP_tab'>Plugin Information</a>
        	</div>
        	<div id='APIP_container'>
            	<div id='APIP_general'>
	                <h2>Plugin Options</h2>
	                <form action='<?php echo WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/';?>alter.php' method="post">
		                <?php wp_nonce_field( 'options', 'allowPHPNonce' ); ?>
		                <input type="hidden" name='action' value='options' />
		                <input type="hidden" name="id" value="0" />
		                <input type="hidden" name="validation" value='<?php echo md5(md5(sha1("0")));?>'/>

		                <p><strong>Current 404 message:</strong></p>
		                <pre><?php echo htmlentities($fourohfourmsg);?></pre>
		                <table cellpadding='5' cellspacing='5' width='100%' align='center'>
		                	<tr>
		                		<td height='30' align='right' width='40%'><label for="show404">Show the snippet not found message?: </label></td>
		                		<td width='60%'> <input type='checkbox' name='option_show404' value='1' <?php if($show404 == 1)echo "checked='checked'";?> /></td>
		                	</tr>
		                	<tr>
		                		<td height='30' align='right'><label for="fourohfourmsg">Custom 404 message to be displayed: </label></td>
		                		<td> <select name='option_404msg'>
			                			<option value='0'> - Default Message - </option>
					                    <?php
					                        $res = "SELECT * FROM ".$wpdb->prefix."allowPHP_functions";
					                        $res = $wpdb->get_results($res);
					                        foreach($res as $row){
					                            echo "<option value='".$row->id."'";
					                            if($row->id == $fourohfourmsg_id){echo "selected='selected'";}
					                            echo"> - Snippet ID: ".$row->id." - </option>";
					                        }
					                    ?>
		               				</select>
		               			</td>
		                	</tr>
		                </table>
		                <input type='submit' class='button-primary' value='Save Plugin Options' />
	                </form>
	            </div>
	            <div id='APIP_usage'>
	            	<h2>Code Snippets</h2>
	            	<p><em>All snippets begin with a <span style='color:red'>&lt;?php</span> and end with a <span style='color:red'>?&gt;</span> So if you wish to use html only you will need to close the php tag, then re-open it at the end.</em></p>
	            	<table cellpadding='5' cellspacing='0' width="600">
					<?php if(sizeof($results) != 0){?>
		            	<tr>
			            	<th width='35' style='border-right:1px #ddd solid;'>ID</th>
			                <th width="15"></th>
				            <th width="475" align="left">Snippet</th>
			                <th width="75" align="right">&nbsp;</th>
		            	</tr>
		            	<tr>
		            		<td style='border-right:1px #ddd solid;' height="10"></td>
		                	<td colspan='3'></td>
		            	</tr>
						<?php foreach($results as $row): ?>
		                	<tr>
		                    	<th align='center' valign="top" scope="row" style='border-right:1px #ddd solid;'>
		                        	<?php echo $row->id; ?>
		                    	</th>
		                    	<td></td>
		                    	<td align="left" valign="top">
			                   		<form action='<?php echo WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/';?>alter.php' method="post" onsubmit="return confirmMod(<?php echo $row->id; ?>)">
			                            <?php wp_nonce_field( 'options', 'allowPHPNonce' ); ?>
			                            <input type='submit' value='Modify' class='button-secondary' style='float:right;' />
			                            <input type='hidden' name='action' value='modify' />
			                            <input type='hidden' name='id' value='<?php echo $row->id; ?>' />
		                          		<input type="hidden" name="validation" value='<?php echo md5(md5(sha1($row->id)))?>'/>
			                            <strong>Name:</strong>
			                            <input type='text' name='name' value='<?php echo $row->name;?>' onblur="javascript:this.style.textDecoration='none'; this.style.cursor='pointer'" onclick="javascript:this.style.textDecoration='underline'; this.style.cursor='text';" title="Click to edit" maxlength="99" style='width:370px; border:0px white solid !important;cursor:pointer; background:none !important;'/><br/>
			                            <span style='color:red; vertical-align:top;'>&lt;?php</span><textarea style="width:475px" rows="2" name='function'><?php echo $row->function; ?></textarea><span style='color:red'>?&gt;</span>
			                        </form>
		                    	</td>
			                    <td align="left" valign="top">
			                      <form action='<?php echo WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/';?>alter.php' method="post" onsubmit="return confirmDel(<?php echo $row->id; ?>)">
				                      <?php wp_nonce_field( 'options', 'allowPHPNonce' ); ?>
				                      <input type='hidden' name='action' value='delete' />
				                      <input type='hidden' name='id' value='<?php echo $row->id; ?>' />
				                      <input type="hidden" name="validation" value='<?php echo md5(md5(sha1($row->id)))?>'/>
				                      &nbsp;|&nbsp;<input type='submit' value='Delete' class='button-secondary' />
			                      </form>
			                    </td>
		                	</tr>
		            		<tr>
		            			<td style='border-right:1px #ddd solid;' height="20"></td>
		            			<td colspan='3'></td>
		            		</tr>
				        <?php endforeach;
					}
					else{?>
	            		<tr>
	            			<td style='border-right:1px #ddd solid;'></td>
	            			<td colspan='3' align="center"><em>No Snippets Found</em></td>
	            		</tr>
	            		<tr>
	            			<td style='border-right:1px #ddd solid;' height="20"></td>
	            			<td colspan='3'></td>
	            		</tr>
	           		<?php }?>
		           		<tr>
		           			<td style='border-right:1px #ddd solid;' height="20"></td>
		           			<td colspan='3' style='border-top:1px #ddd solid;'></td>
		           		</tr>
		          		<tr>
		            		<th width="35" style='border-right:1px #ddd solid;'>&nbsp;</th>
		            		<th width="15"></th>
		              		<th width="475" align="left"><h3>Add A New Snippet</h3></th>
		                	<th width="75" align="right">&nbsp;</th>
		                </tr>
		            	<tr>
		            		<td height="123" style='border-right:1px #ddd solid;'></td>
		            		<td></td>
		            		<td colspan="2" >
					            <form action='<?php echo WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/';?>alter.php' method="post">
					                <?php wp_nonce_field( 'options', 'allowPHPNonce' ); ?>
					                <input type='hidden' name='action' value='add' />
					                <input type='hidden' name='id' value='0' />
					                <input type="hidden" name="validation" value='<?php echo md5(md5(sha1("0")));?>'/>
					                <input type='submit' value='Save Snippet' class='button-primary' style='float:right;' />
					                <strong>Name: </strong><input type='text' name='name' id='name' style='width:405px;' maxlength="100" />
					                <br/>
					                <span style='color:red;vertical-align:top;'>&lt;?php</span><textarea style='width:550px' rows='3' name='function'></textarea><span style='color:red'>?&gt;</span><br/>
					            </form>
				         	</td>
			         	</tr>
					</table>
				</div>
			</div>
	    </div>
	</div>
	<?php if( "CS" == $activeTab){echo "<script type='text/javascript'>APIP_changeTab('APIP_usage','APIP_usageTab');</script>";}?>
	<?php
}

function allowPHP_activate(){
	global $wpdb;
	global $dbVersion;
	$options = get_option("allowPHP_options");
	$installedVersion = $options['dbVersion'];
	$show404 = 1;
	$fourohfourmsg = 0;
	if(isset($options['show404'])){
		$show404 = $options['show404'];
	}
	if(isset($options['fourohfourmsg'])){
		$fourohfourmsg = $options['fourohfourmsg'];
	}
	if($installedVersion != $dbVersion){
		$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."allowPHP_functions(
			id int NOT NULL AUTO_INCREMENT,
			name varchar(100) NOT NULL,
			function text NOT NULL,
			PRIMARY KEY(id)
		);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	$options = array("show404" => $show404,"fourohfourmsg" => $fourohfourmsg, "dbVersion" => $dbVersion);
	update_option("allowPHP_options", $options);
}

function add_APIP_button() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ){
     return;
   }
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_APIP_tinymce_plugin');
     add_filter('mce_buttons', 'register_APIP_button');
   }
}

define( "APIP_PLUGIN_DIR", "allow-php-in-posts-and-pages" );
define( "APIP_PLUGIN_URL", get_bloginfo('url')."/wp-content/plugins/" . APIP_PLUGIN_DIR );

function register_APIP_button($buttons) {
   array_push($buttons, "|", "allowPHP");
   return $buttons;
}
function add_APIP_tinymce_plugin($plugin_array) {
   $plugin_array['allowPHP'] = APIP_PLUGIN_URL . '/AP.js';
   return $plugin_array;
}

function APIP_my_refresh_mce($ver) {
  $ver += 2;
  return $ver;
}
add_action('init', 'add_APIP_button');
add_filter( 'tiny_mce_version', 'APIP_my_refresh_mce');

function APIP_Appeal(){
	?>
	<div style='float:right; display:inline; width:450px; margin-left:25px; margin-bottom:10px; margin-right:15px; padding:10px; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: #666 2px 2px 5px;-moz-box-shadow: #666 2px 2px 5px;box-shadow: #666 2px 2px 5px;background: #ffff00;background: -webkit-gradient(linear, 0 0, 0 bottom, from(#ffff00), to(#ffffcc));background: -moz-linear-gradient(#ffff00, #ffffcc);background: linear-gradient(#ffff00, #ffffcc);'>
        <span style='font-size:1em; color:#999; display:block; line-height:1.2em;'><strong>Developed by <a href='http://www.hitreach.co.uk' target="_blank" style='text-decoration:none;'>Hit Reach</a></strong><a href='http://www.hitreach.co.uk' target="_blank" style='text-decoration:none;'></a></span>
        <span style='font-size:1em; color:#999; display:block; line-height:1.2em;'><strong>Check out our other <a href='http://www.hitreach.co.uk/services/wordpress-plugins/' target="_blank" style='text-decoration:none;'>Wordpress Plugins</a></strong><a href='http://www.hitreach.co.uk/services/wordpress-plugins/' target="_blank" style='text-decoration:none;'></a></span>
        <span style='font-size:1em; color:#999; display:block; line-height:1.2em;'><strong>Version: <?php echo ALLOWPHPVERSION; ?> <a href='http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages/' target="_blank" style='text-decoration:none;'>Support, Comments &amp; Questions</a></strong></span>
        <hr/>
        <h2>Please help! We need your support...</h2>
        <p>If this plugin has helped you, your clients or customers then please take a moment to 'say thanks'. </p>
        <p>By spreading the word you help increase awareness of us and our plugins which makes it easier to justify the time we spend on this project.</p>
        <p>Please <strong>help us keep this plugin free</strong> to use and allow us to provide on-going updates and support.</p>
        <p>Here are some quick, easy and free things you can do which all help and we would really appreciate.</p>
        <ol>
            <li>
                <strong>Promote this plugin on Twitter</strong><br/>
                <a href="http://twitter.com/home?status=I'm using the Allow PHP in Posts and Pages WordPress plugin by @hitreach and it rocks! You can download it here: http://bit.ly/e2Q4Az" target="_blank">
                <img src='<?php echo APIP_URL;?>/twitter.gif' border="0" width='55' height='20'/>
                </a><br/><br/>
        </li>
            <li>
                <strong>Link to us</strong><br/>
                By linking to <a href='http://www.hitreach.co.uk' target="_blank">www.hitreach.co.uk</a> from your site or blog it means you can help others find the plugin on our site and also let Google know we are trust and link worthy which helps our profile.<br/><br/>
                </li>
          <li>
                <strong>Like us on Facebook</strong><br/>
                Just visit <a href='http://www.facebook.com/webdesigndundee' target="_blank">www.facebook.com/webdesigndundee</a> and hit the 'Like!' button!<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.facebook.com/webdesigndundee" send="true" width="450" show_faces="false" action="like" font="verdana"></fb:like><br/><br/>
          </li>
            <li>
                <strong>Share this plugin on Facebook</strong><br/>
                <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.hitreach.co.uk/wordpress-plugins/allow-php-in-posts-and-pages" send="true" width="450" show_faces="false" action="recommend" font="verdana"></fb:like>
                Share a link to the plugin page with your friends on Facebook<br/><br/>
            </li>
            <li>
                <strong>Make A Donation</strong><br/>
                Ok this one isn't really free but hopefully it's still a lot cheaper than if you'd had to buy the plugin or pay for it to be made for your project. Any amount is appreciated
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <input type="hidden" name="cmd" value="_donations">
                    <input type="hidden" name="business" value="admin@hitreach.co.uk">
                    <input type="hidden" name="lc" value="GB">
                    <input type="hidden" name="item_name" value="Hit Reach">
                    <input type="hidden" name="item_number" value="APIP-Plugin">
                    <input type="hidden" name="no_note" value="0">
                    <input type="hidden" name="currency_code" value="GBP">
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
                    <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </li>
        </ol>
    </div>
    <?php
}

?>