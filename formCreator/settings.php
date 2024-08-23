<?php if (file_exists(GSDATAOTHERPATH . 'formCreator/settings.json')) {


    $file = json_decode(file_get_contents(GSDATAOTHERPATH . 'formCreator/settings.json'));
    $from = $file->from;
    $to = $file->to;
    $secretkey = $file->secretkey;
    $sitekey = $file->sitekey;
};

?>

<h3><?php echo i18n_r('formCreator/SETTINGS');?> Form Creator</h3>

<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=formCreator'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black"><?php echo i18n_r('formCreator/BACKTOLIST');?></a>


<form method="POST" class="w3-border w3-light-gray w3-padding w3-container" style="box-sizing:border-box">


    <label for="" class="w3-padding-16"><?php echo i18n_r('formCreator/RECIPIENT');?></label>
    <input type="text" name="to" value="<?php echo @$to; ?>" class="w3-input w3-border">

    <label for="" class="w3-padding-16"><?php echo i18n_r('formCreator/SENDER');?></label>
    <input type="text" name="from" value="<?php echo @$from; ?>" class="w3-input w3-border">

    <p class="w3-margin-top"><?php echo i18n_r('formCreator/CAPTCHAINFO');?> <a href="https://www.google.com/recaptcha/admin/create" target="_href">Google Recaptcha</a></p>

    <label for="" class="w3-padding-16"><?php echo i18n_r('formCreator/SECRETKEY');?></label>
    <input type="text" name="secretkey" value="<?php echo @$secretkey; ?>" class="w3-input w3-border">

    <label for="" class="w3-padding-16"><?php echo i18n_r('formCreator/SITEKEY');?></label>
    <input type="text" name="sitekey" value="<?php echo @$sitekey; ?>" class="w3-input w3-border">

    <input type="submit" name="savesettings" value="<?php echo i18n_r('formCreator/SAVESETTINGS');?>" class="w3-black w3-btn w3-margin-top">

</form>




<?php


if (isset($_POST['savesettings'])) {
    // Collect and sanitize form data
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $secretkey = isset($_POST['secretkey']) ? htmlspecialchars($_POST['secretkey']) : '';
    $sitekey = isset($_POST['sitekey']) ? htmlspecialchars($_POST['sitekey']) : '';

    // Create an associative array with the form data
    $settings = array(
        "to" => $to,
        "from" => $from,
        "secretkey" => $secretkey,
        "sitekey" => $sitekey
    );

    // Encode the array as a JSON object
    $json_data = json_encode($settings, JSON_PRETTY_PRINT);

    // Specify the file path
    $file_path = GSDATAOTHERPATH . 'formCreator/settings.json';

    // Write the JSON data to the file
    if (file_put_contents($file_path, $json_data)) {
        echo "<div class='w3-card w3-green w3-margin-top w3-padding w3-text-center'>Settings saved successfully!</div>";
        echo "<meta http-equiv='refresh' content='1;url=" . $SITEURL . $GSADMIN . "/load.php?id=formCreator&settings'>";
    }
};
?>