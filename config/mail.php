<?php
$recipient = "";

$errors = [];
if (isset($_POST['name'], $_POST['email'], $_POST['message']) ) {
    $fields = [
      "name"      => strip_tags(trim($_POST["name"])), 
      "email"     => stripcslashes(trim($_POST["email"])),
      "message"   => strip_tags($_POST["message"])
    ];

    foreach ($fields as $key => $val) {
        if (empty($_POST["name"])) {
            $errors['name'] = "Please provide your name";  
        }
        if (empty($_POST["email"])) {
            $errors['email'] = "Please provide your email"; 
        }
        if (empty($_POST["message"])) {
            $errors['message'] = "Please provide an appropriate message"; 
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
            $errors['name'] = "Please fill in your name.";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }

    if (!empty($errors)) {
        $array = array('errors' => true, 'fields' => $errors);
    } else {
        $response = "Your message was sent!";
        $subject = $_POST['name'];
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                          <meta name="viewport" content="width=device-width" />
                          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                          <title></title>
                          <style type="text/css">
                            html { 
                              font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                              box-sizing: border-box;
                              font-size: 14px;
                              margin: 0;
                            }
                            a img,hr { border:none; }
                            a,img { text-decoration:none; }
                            outlook a { padding:0; }
                            body{
                              width: 100%;
                              min-width: 100%;
                              -webkit-text-size-adjust: 100%;
                              -ms-text-size-adjust: 100%;
                            }
                            .ExternalClass { width:100%; }
                            .ExternalClass,.ExternalClass div,
                            .ExternalClass font,.ExternalClass p,
                            .ExternalClass span,.ExternalClass td { line-height:100%; }
                            #backgroundTable{
                              margin: 0;
                              padding: 0;
                              width: 100%;
                              line-height: 100%;
                            }
                            img.center,table.column,table.columns { margin:0 auto; }
                            center {
                              width: 100%;
                              min-width:580px;
                            }
                            table {
                              border-spacing: 0;
                              border-collapse: collapse;
                            }
                            td {
                              word-break:break-word;
                              -webkit-hyphens:auto;
                              -moz-hyphens:auto;
                              hyphens:auto;
                              border-collapse:collapse;
                            }
                            table,td,tr {
                              padding: 0;
                              vertical-align: top;
                              text-align: left;
                            }
                          </style>
                        </head>
                        <body itemscope itemtype="http://schema.org/EmailMessage">
                          <table style="width: 100%; background-color: #fff; max-width: 600px; margin: 20px auto; border: 1px solid #e9e9e9; border-radius: 2px;">
                            <tr>
                              <td style="padding:0; width:100%; display:block; max-width:600px;margin:0 auto; clear:both;" width="600">
                                <div style="max-width:600px; margin:0 auto; display: block;">
                                  <div style="margin-bottom: -5px; position: relative; padding: 20px; height: 50px;">
                                      <h1 style="color: #fff; font-weight: 200;">HEADER</h1>
                                  </div>
                                  <table style="vertical-align: top; border-radius: 3px 3px 0 0; margin: 10px; background-color: #fff; padding:15px;" cellpadding="0" cellspacing="0">';
        $body .=                              "<tr>
                                                <td>" . $_POST['name'] . "</td>
                                              </tr>
                                              <tr>
                                                <td>" . $_POST['email'] . "</td>
                                              </tr>
                                            </table>
                                            <table style='vertical-align: top; border-radius: 3px 3px 0 0; background-color: #fff; padding: 15px;' cellpadding='0' cellspacing='0'>
                                              <tr>
                                                <td>" . $_POST['message'] . "</td>
                                              </tr>
                                            </table>";
        $body .=                      '</div>
                                   </td>
                               </tr>
                           </table>
                       </body>
                       </html>';
 
        $headers = 'MIME-Version: 1.0'                                              . "\n";
        $headers .= 'Content-Type: text/html; charset=ISO-8859-1'                   . "\n";
 
        // Build the email content.
        $headers .= "From: "              . $_POST['name'] . " <" . $_POST['email'] .">\n";
        $headers .= "Reply-To: "          . $_POST['email']                          . "\n";
        $headers .= "Return-Path: From: " . $_POST['name'] . " (". $_POST['email']  .")\n";
        $headers .= "X-Mailer: PHP/"                              . phpversion()    . "\n";
 
        mail($recipient, $subject, $body, $headers);
        $array = array('errors' => false, 'response'  => $response);
    }
    header("Content-Type: application/json", true);
    echo json_encode($array);
}
?>