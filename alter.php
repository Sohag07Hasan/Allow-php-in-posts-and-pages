<?php
	include_once("../../../wp-config.php");
	include_once("../../../wp-load.php");
	include_once("../../../wp-includes/wp-db.php");
	global $wpdb;
	$refer = get_bloginfo('url')."/wp-admin/admin.php?page=allow-php-menu";
	if( !isset( $_POST['allowPHPNonce'] ) ){ wp_die("Authentication Failed"); }
	else{
		if(!function_exists(wp_verify_nonce) ){ wp_die("Authentication Failed"); }
		if ( !wp_verify_nonce( $_POST['allowPHPNonce'], 'options' ) ) { wp_die("Authentication Failed"); }
	}
	if( !isset( $_POST['action'] ) || !isset( $_POST['id'] ) || !isset( $_POST['validation'] ) ){ die("Authentication Failed"); }
	else{
		$action = $_POST['action'];
		$id = $_POST['id'];
		$validation = $_POST['validation'];
		if(!preg_match("/^[\d]*$/", $id) || $validation != md5( md5( sha1( $id ) ) ) ){ wp_die("Authentication Failed validation"); }
		$function;
		$name;
		if( isset( $_POST['function'] ) ){ $function = htmlspecialchars($_POST['function']); }
		if( isset( $_POST['name'] ) ){ $name = htmlspecialchars( $_POST['name'] ); }
		#delete
		if($action == "delete" && preg_match("/^[\d]*$/", $id)){
			$sql = "delete from ".$wpdb->prefix."allowPHP_functions WHERE id='".$id."'";
			$wpdb->query($wpdb->prepare($sql));
			header("location:".$refer."&tab=cs&deleted=$id");
		}
		#add
		elseif($action == "add" && $function != ""){
			$sql = "insert into ".$wpdb->prefix."allowPHP_functions (function,name) values('".$function."','".$name."')";
			$results = $wpdb->get_results($wpdb->prepare($sql));
			header("location:".$refer."&tab=cs&functionAdded");
		}
		#modify
		if( $action == "modify" && $function != "" && preg_match("/^[\d]*$/", $id) ){
			$sql = "update ".$wpdb->prefix."allowPHP_functions set function='".$function."', name='".$name."' where id = ".$id;
			$results = $wpdb->get_results($wpdb->prepare($sql));
			header("location:".$refer."&tab=cs&modified=$id");
		}
		elseif( $action == "options" && isset( $_POST['option_404msg'] ) ) {
			if( isset( $_POST["option_show404"] ) ){ $show404 = 1; }else{ $show404 = 0 ;}
			if( isset( $_POST["option_404msg"]  )){ $fourohfourmsg = $_POST['option_404msg'];}else{ $show404 = 0; }
			if( !preg_match("/^[\d]*$/", $fourohfourmsg) ){
				wp_die("Authentication Failed");
			}
			$options = get_option("allowPHP_options");
			$options = unserialize($options);
			$options['show404'] = $show404;
			$options['fourohfourmsg'] = $fourohfourmsg;
			update_option("allowPHP_options", $options);
			header("location:".$refer."&status=optionsupdated");
		}

	}
?>