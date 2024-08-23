<?php

class frontendFormCreator
{


    function show($val)
    {
        function hex_encode($input) {
            return bin2hex($input);
        }
        
        function hex_decode($input) {
            return hex2bin($input);
        }

        if (file_exists(GSDATAOTHERPATH . 'formCreator/settings.json')) {


            $file = json_decode(file_get_contents(GSDATAOTHERPATH . 'formCreator/settings.json'));
            $from = $file->from;
            $to = $file->to;
            $to = $file->secretkey;
            $secretkey = $file->secretkey;
            $sitekey = $file->sitekey;
        };


        echo '<form method="POST">';

        if (file_exists(GSDATAOTHERPATH . 'formCreator/' . $val . '.json')) {

            $js = file_get_contents(GSDATAOTHERPATH . 'formCreator/' . $val . '.json');

            $json = json_decode($js);

            foreach ($json as $key => $value) {

                $hashed = hex_encode($value[0]);

                echo  '<div class="formcreator-'.$hashed.'"><label for="' . $hashed . '">' . $value[0] . '</label>';

                if ($value[1] == 'textarea') {
                    echo  '<textarea name="' .  $hashed . '" '.(isset($value[2]) && $value[2]=='on'? 'required':'').'></textarea></div>';
                } else {
                    echo  '<input type="' . $value[1] . '" name="' . $hashed . '" '.(isset($value[2]) && $value[2]=='on'? 'required':'').'></div>';
                }
            };
        }



        echo  '
            <div class="g-recaptcha" data-sitekey="' . @$sitekey . '"></div>
            <input type="submit" style="margin-top:10px;" name="submit" value="'.i18n_r('formCreator/SENDMESSAGE').'">';

       echo '</form>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>';





        if (isset($_POST['submit'])) {
            $to = $to;
            $secretKey =  @$secretkey; // Klucz tajny reCAPTCHA
            $responseKey = $_POST['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);

            if (intval($responseKeys["success"]) !== 1) {
                echo "<span style='color:red;'>".i18n_r('formCreator/CAPTCHAERROR')."</span>";
            } else {


                $subject = i18n_r('formCreator/SUBJECT');
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: " . @$from . "\r\n";

                $message = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            color: #333;
                        }
                        .container {
                            padding: 20px;
                            border: 1px solid #ddd;
                            background-color: #f9f9f9;
                        }
                        .header {
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                            color: #004085;
                        }
                        .content {
                            margin-bottom: 20px;
                        }
                        .content p {
                            margin: 5px 0;
                        }
                        .footer {
                            font-size: 12px;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>".i18n_r('formCreator/NEWMSG')."</div>
                        <div class='content'>
                ";

                foreach ($_POST as $name => $value) {
                    if ($name !== 'submit' && $name !== 'g-recaptcha-response') {
                        $message .= "<p><strong>" . htmlspecialchars(hex_decode($name)) . ":</strong> " . htmlspecialchars($value) . "</p>";
                    }
                }

                $message .= "
                        </div>
                        <div class='footer'>
                            ".i18n_r('formCreator/FOOTERINFO')."
                        </div>
                    </div>
                </body>
                </html>
                ";

                // Wysyłanie wiadomości
                if (mail($to, $subject, $message, $headers)) {
                    echo "<span color='green'>".i18n_r('formCreator/SENDEDMSG')."</span>";
                } else {
                    echo "<span color='red'>".i18n_r('formCreator/SENDESMGERROR')."</span>";
                   
                }
            }
        }
    }



   
}
