<?php

require 'vendor/autoload.php';

use Niyko\NoiseCaptcha\NoiseCaptcha;

$captcha = NoiseCaptcha::generate('7v2AEZ6Me13m');

if(isset($_POST['token'])){
    if(NoiseCaptcha::check('7v2AEZ6Me13m', $_POST['code'], $_POST['token'])){
        echo '<p style="color: green;">Captcha verified</p>';
    }
    else{
        echo '<p style="color: red;">Captcha is invalid</p>';
    }
}

?>

<html>
    <body>
        <form action="test.php" method="POST">
            <input name="token" type="text" value="<?php echo $captcha->getToken(); ?>" autocomplete="off">
            <img src="<?php echo $captcha->getBase64Image(); ?>">
            <input name="code" type="text" value="" autocomplete="off" placeholder="code">
            <input type="submit" value="submit">
        </form>
    </body>
</html>