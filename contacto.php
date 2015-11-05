<?php 
$your_email ='javiercferrans@gmail.com';// <<=== update to your email address

session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';

if(isset($_POST['submit']))
{

    $name = $_POST['name'];
    $visitor_email = $_POST['email'];
    $user_message = $_POST['message'];
    ///------------Do Validations-------------
    if(empty($name)||empty($visitor_email))
    {
        $errors .= "\n Name and Email are required fields. ";   
    }
    if(IsInjected($visitor_email))
    {
        $errors .= "\n Bad email value!";
    }
    if(empty($_SESSION['6_letters_code'] ) ||
      strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
    {
    //Note: the captcha code is compared case insensitively.
    //if you want case sensitive match, update the check above to
    // strcmp()
        $errors .= "\n The captcha code does not match!";
    }
    
    if(empty($errors))
    {
        //send the email
        $to = $your_email;
        $subject="New form submission";
        $from = $your_email;
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        
        $body = "Un usuario se contacto por medio de la página:\n".
        "Nombre: $name\n".
        "Email: $visitor_email \n".
        "Mensaje: \n ".
        "$user_message\n".
        "IP: $ip\n";    
        
        $headers = "From: $from \r\n";
        $headers .= "Reply-To: $visitor_email \r\n";
        
        mail($to, $subject, $body,$headers);
        
        header('Location: gracias.html');
    }
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
      '(\r+)',
      '(\t+)',
      '(%0A+)',
      '(%0D+)',
      '(%08+)',
      '(%09+)'
      );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
  {
    return true;
}
else
{
    return false;
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="puentesApp">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/main.css" type="text/css" rel="stylesheet" />

    <title>Puentes y Carreteras</title>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="js/gen_validatorv31.js" type="text/javascript"></script>    
    <style>
        label 
        {
            font-family : Arial, Helvetica, sans-serif;
            font-size : 12px; 
        }
        .err
        {
            font-family : Verdana, Helvetica, sans-serif;
            font-size : 12px;
            color: red;
        }
    </style>
</head>

<body onload="randBackground()">
    <div class="wrap">
        <div class="align">
            <!--header-->
            <header id="header">
                <a href="index.html"><img src="img/logo.png" alt="Logotipo Puentes y Carreteras" height="70" style="margin:30px 30px 30px 30px" /></a>
                <div id="contacto2">
                    <p class="grey">Puentes y Carreteras S.A.S.</p>
                    <p class="blue">Nit 860.402.284-0</p>
                    <p class="grey">Dir.: Av. 7 No 114 - 33, Of 705 <br />Centro Empresarial Santa Bárbara</p>
                    <p class="grey">Tel.: (57 1) 640 06 30 / 31 / 32 </p>
                    <p class="blue">Bogot&aacute; - Colombia</p>
                </div>

                <div id="contacto">

                </div>

            </header>
            <!--fin header-->


            <div id="contenido" ng-controller="experienciaCtrl">
                <div id="cercania2">
                    <div class="tagmenu1">
                        <h1>Contacto</h1>
                    </div>
                </div>
                <div id="derecha">
                    <div class="contacto">
                        <?php
                        if(!empty($errors)){
                            echo "<p class='err'>".nl2br($errors)."</p>";
                        }
                        ?>
                        <div id='contact_form_errorloc' class='err'></div>
                        <form method="POST" name="contact_form" 
                        action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 
                        <div class="form-row">
                            <div class="form-control">
                                <label for='name'>Nombre: </label><br>
                                <input type="text" name="name" value='<?php echo htmlentities($name) ?>'>
                            </div>
                            <div class="form-control">

                                <label for='email'>Email: </label><br>
                                <input type="text" name="email" value='<?php echo htmlentities($visitor_email) ?>'>

                            </div>
                        </div>
                        <div class="form-row">
                            <label for='message'>Mensaje:</label>
                            <textarea name="message" rows=8 cols=30><?php echo htmlentities($user_message) ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-control">
                                <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
                                <label for='message'>Ingrese el código :</label><br>
                                <input id="6_letters_code" name="6_letters_code" type="text"><br>
                            </div>
                        </div>
                        <small>¿No puede ver la imagen? haga click <a href='javascript: refreshCaptcha();'>aquí</a> para generar una nueva</small>
                    </p>
                    <input type="submit" value="Enviar" name='submit'>
                </form>
            </div>
        </div>

    </div>
    <footer id="footer">
        <div id="footer1">
            <p>Puentes y Carreteras &copy; PRIVACY POLICY</p>
        </div>
        <div id="footer2">
            <a href="experiencia.html" target="_self">Experiencia</a>
            <a href="profesionalismo.html" target="_self">Profesionalismo</a>
            <a href="cercania.html" target="_self">Cercan&iacute;a</a>
            <a href="contacto.php" target="_top" target="_self">Contacto</a>
        </div>
        <div id="footer3">
            <img src="img/Logo_BV2.png" style="height:80px;"  />
        </div>
    </footer>
</div>
</div>
<script language="JavaScript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("contact_form");
//remove the following two lines if you like error message box popups
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();

frmvalidator.addValidation("name","req","Please provide your name"); 
frmvalidator.addValidation("email","req","Please provide your email"); 
frmvalidator.addValidation("email","email","Please enter a valid email address"); 
</script>
<script language='JavaScript' type='text/javascript'>
    function refreshCaptcha()
    {
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
    }
</script>
</body>
</html>
