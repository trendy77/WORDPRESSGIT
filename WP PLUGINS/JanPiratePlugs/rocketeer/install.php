<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/2/2016
 * Time: 7:02 PM
 */

$m                                              =   "";

if(isset($_POST['dbhost'], $_POST['dbname'], $_POST['dbusername'], $_POST['dbpass'])){
    try {
        $db                                     =   new PDO('mysql:host=' . $_POST['dbhost'] . ';dbname=' . $_POST['dbname'], $_POST['dbusername'], $_POST['dbpass']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tableSQL                               =   file_get_contents('db.sql.txt');
        $createTables                           =   $db->prepare($tableSQL);
        $createTables->execute();
        $createTables->closeCursor();

        $domain                                 =   str_replace("http://", "", $_POST['site_domain']);
        $dir                                    =   str_replace("\\", "", dirname(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $dir                                    .=  substr($dir, -1) != "/" ? '/' : '';

        $insertSQL                              =   file_get_contents('insert.sql.txt');
        $insertSQL                              =   str_replace( "PLACEHOLDER_SITE_DIR", $dir, $insertSQL );
        $insertSQL                              =   str_replace( "PLACEHOLDER_SITE_DOMAIN", $domain, $insertSQL );
        $insertSQL                              =   str_replace( "PLACEHOLDER_OVERRIDES", json_encode([
            'poll_page_content'                 =>  2,
            'poll_style'                        =>  2,
            'poll_animation'                    =>  2,
            'quiz_page_content'                 =>  2,
            'quiz_animation'                    =>  2,
            'quiz_style'                        =>  2,
            'quiz_timed'                        =>  2,
            'quiz_timer'                        =>  2,
            'quiz_randomize_questions'          =>  2,
            'quiz_randomize_answers'            =>  2,
            'quiz_show_correct_answer'          =>  2,
            'image_page_content'                =>  2,
            'meme_page_content'                 =>  2,
            'video_page_content'                =>  2,
            'list_page_content'                 =>  2,
            'list_style'                        =>  2,
            'list_animation'                    =>  2
        ]), $insertSQL );
        $insertSQL                              =   str_replace( "PLACEHOLDER_DEFAULTS", json_encode([
            'poll_style'                        =>  1,
            'poll_animation'                    =>  '',
            'quiz_animation'                    =>  '',
            'quiz_style'                        =>  1,
            'quiz_timed'                        =>  1,
            'quiz_timer'                        =>  0,
            'quiz_randomize_questions'          =>  1,
            'quiz_randomize_answers'            =>  1,
            'quiz_show_correct_answer'          =>  1,
            'list_style'                        =>  1,
            'list_animation'                    =>  '',
        ]), $insertSQL );
        $insertSQL                              =   str_replace( "PLACEHOLDER_IFRAME_URLS", json_encode([
            "www.youtube.com/embed/", "player.vimeo.com/video/", "w.soundcloud.com/player/", "www.instagram.com"
        ]), $insertSQL);
        $insertSQL                              =   str_replace( "PLACEHOLDER_LANG", json_encode([
            [
                'locale'            =>  'en',
                'readable_name'     =>  'English'
            ]
        ]), $insertSQL );
        $insertQuery                            =   $db->prepare($insertSQL);
        $insertQuery->execute();
        
        unlink("db.sql.txt");
        unlink("insert.sql.txt");

        $env_file                               =   file_get_contents('storage/app/env.txt');
        $env_file                               =   str_replace( "ROCKETEER_LOCALE=", "ROCKETEER_LOCALE=en", $env_file );
        $env_file                               =   str_replace( "DB_HOST=", "DB_HOST=" . $_POST['dbhost'], $env_file );
        $env_file                               =   str_replace( "DB_DATABASE=", "DB_DATABASE=" . $_POST['dbname'], $env_file );
        $env_file                               =   str_replace( "DB_USERNAME=", "DB_USERNAME=" . $_POST['dbusername'], $env_file );
        $env_file                               =   str_replace( "DB_PASSWORD=", "DB_PASSWORD=" . $_POST['dbpass'], $env_file );
        $env_file                               =   str_replace( "APP_DOMAIN=", "APP_DOMAIN=" . "http://" . $domain, $env_file );
        $fh                                     =   fopen('.env', 'w') or die("Can't open .env.example. Make sure it is writable.");
        fwrite($fh, $env_file);
        fclose($fh);
        $m                                      =   '
        <div class="alert alert-success text-center">
            <strong>Rocketeer hass been installed successfully!</strong><br>
            To get started, please log into the account we created for you during installation.<br>
            <strong>Username: </strong> admin <br>
            <strong>Password: </strong> admin<br>
            <strong>PLEASE DELETE THE install.php FILE! THIS IS VERY IMPORTANT!</strong>
        </div>';
    } catch(PDOException $e) {
        $m                                      =   '<div class="alert alert-danger"><strong>' . $e->getMessage() . '</strong></div>';
    }
}
?>
<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Rocketeer Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid">
    <!--left-->
    <div class="col-sm-12">
        <h1 class="lobster text-center">Install Rocketeer</h1>
        <div class="panel panel-primary">
            <div class="panel-heading">Configuration</div>
            <div class="panel-body">
                <?php echo $m; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Database Host</label>
                        <input type="text" class="form-control" name="dbhost">
                    </div>
                    <div class="form-group">
                        <label>Database Name</label>
                        <input type="text" class="form-control" name="dbname">
                    </div>
                    <div class="form-group">
                        <label>Database Username</label>
                        <input type="text" class="form-control" name="dbusername">
                    </div>
                    <div class="form-group">
                        <label>Database Password</label>
                        <input type="text" class="form-control" name="dbpass">
                    </div>
                    <div class="form-group">
                        <label>Site Domain</label>
                        <input type="text" class="form-control" name="site_domain">
                    <span id="helpBlock" class="help-block">
                        The domain name of your site. Do not include http:// or a forward slash after the domain.
                        Example: rocketeer-demo.com
                    </span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--/left-->
</div><!--/container-fluid-->
</body>
</html>