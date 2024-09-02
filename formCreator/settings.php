<?php if (file_exists(GSDATAOTHERPATH . 'formCreator/settings.json')) {


    $file = json_decode(file_get_contents(GSDATAOTHERPATH . 'formCreator/settings.json'));
    $from = $file->from;
    $to = $file->to;
     $secretkey = $file->secretkey;
    $sitekey = $file->sitekey;
    $redirectpage= $file->redirectpage;
    $successpage = $file->successpage;
    $errorpage = $file->errorpage;
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


    <div class="w3-red w3-padding-16 w3-margin-top" style="color:#fff !important;">
    <label for="" style="color:#fff !important;margin-left:10px;"><?php echo i18n_r('formCreator/REDIRECTQUESTION');?><input type="checkbox" name="redirectpage" style="margin-left:10px" value="on"></label>
    </div>

    <label for="" class="w3-padding-16"><?php echo i18n_r('formCreator/SUCCESSPAGE');?></label>

    <?php 
     echo '<select name="successpage" class="w3-border" style="width:100%;padding:8px;margin:10px 0;">';
    echo '<option value="none">none</option>';

    $pages = GSDATAPAGESPATH;

    foreach(glob($pages.'*.xml') as $page){

        $name = pathinfo($page)['filename'];
        print_r($name);

        echo '<option value="'.$name.'">'.$name.'</option>';
        
    };

    echo '</select>';

    ;?>

    <label for=""><?php echo i18n_r('formCreator/ERRORPAGE');?></label>

    <?php 
    
    echo '<select name="errorpage" class="w3-border" style="width:100%;padding:8px;margin:10px 0;">';
    echo '<option value="none">none</option>';

    $pages = GSDATAPAGESPATH;

    foreach(glob($pages.'*.xml') as $page){

        $name = pathinfo($page)['filename'];
        print_r($name);

        echo '<option value="'.$name.'">'.$name.'</option>';
        
    };

    echo '</select>';

    ;?>

    <input type="submit" name="savesettings" value="<?php echo i18n_r('formCreator/SAVESETTINGS');?>" class="w3-black w3-btn w3-margin-top">

</form>


<?php if(isset($redirectpage)):?>

    <script>

if('<?php echo $redirectpage;?>' == 'on'){
document.querySelector('input[name="redirectpage"]').checked = true;
};
  

if('<?php echo $successpage;?>' !== 'none' || '<?php echo $successpage;?>' !== ''  ){
document.querySelector('select[name="successpage"]').value = '<?php echo $successpage;?>';
};

if('<?php echo $errorpage;?>' !== 'none' || '<?php echo $errorpage;?>' !== ''  ){
document.querySelector('select[name="errorpage"]').value = '<?php echo $errorpage;?>';
};


    </script>

<?php endif;?>



<?php


if (isset($_POST['savesettings'])) {
    // Collect and sanitize form data
    $to = isset($_POST['to']) ? htmlspecialchars($_POST['to']) : '';
    $from = isset($_POST['from']) ? htmlspecialchars($_POST['from']) : '';
    $secretkey = isset($_POST['secretkey']) ? htmlspecialchars($_POST['secretkey']) : '';
    $sitekey = isset($_POST['sitekey']) ? htmlspecialchars($_POST['sitekey']) : '';
    $redirectpage = isset($_POST['redirectpage'])? htmlspecialchars($_POST['redirectpage']) : '';
    $successpage = isset($_POST['successpage'])? htmlspecialchars($_POST['successpage']) : '';
    $errorpage = isset($_POST['errorpage'])? htmlspecialchars($_POST['errorpage']) : '';


    // Create an associative array with the form data
    $settings = array(
        "to" => $to,
        "from" => $from,
        "secretkey" => $secretkey,
        "sitekey" => $sitekey,
        "redirectpage"=>$redirectpage,
        "successpage"=>$successpage,
        "errorpage"=>$errorpage
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