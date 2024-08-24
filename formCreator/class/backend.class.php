<?php

class backendFormCreator
{


    function editform($val)
    {

        if (file_exists(GSDATAOTHERPATH . 'formCreator/' . $val . '.json')) {

            $js = file_get_contents(GSDATAOTHERPATH . 'formCreator/' . $val . '.json');

            $json = json_decode($js);
       

            foreach ($json as $key => $value) {


                echo ' 
                 <div class="w3-border w3-panel w3-light-grey w3-padding-16" style="position:relative;padding-top:30px !important;">
                <button onclick="event.preventDefault();this.parentElement.remove()" class="w3-btn w3-hover-black w3-red closethis" style="position:absolute;top:0;right:0;">X</button>
                <label>Label</label>
        <input type="text" name="label-' . $key . '" value="' . $value[0] . '" style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
        <label>Type</label>
   <select name="type-' . $key . '"  style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
         <option value="checkbox" >Checkbox</option>
        <option value="color" >Color</option>
        <option value="date">Date</option>
        <option value="datetime-local" >Datetime Local</option>
        <option value="email" >Email</option>
         <option value="month" >Month</option>
        <option value="number" >Number</option>
        <option value="password" >Password</option>
        <option value="radio" >Radio</option>
        <option value="range" >Range</option>
        <option value="tel" >Telephone</option>
        <option value="text" >Text</option>
        <option value="time" >Time</option>
         <option value="week" >Week</option>
        <option value="textarea" >Textarea</option>
    </select>
    
        <label style="display:flex;align-items:center;gap:5px;margin-top:10px;margin-bottom:10px;">'.i18n_r('formCreator/REQUIRED').'?</label>
                       <input name="required-'.$key.'" type="checkbox" '. (isset($value[2]) && $value[2] =='on' ? 'checked':'').'>
    
    </div>



    <script>document.querySelector(`select[name="type-' . $key . '"]`).value = "' . $value[1] . '"</script>


       ';
            };
        }
    }


    function deleteForm($val)
    {
        global $SITEURL;
        global $GSADMIN;
        unlink(GSDATAOTHERPATH . 'formCreator/' . $val . '.json');
        echo "<meta http-equiv='refresh' content='0;url=" . $SITEURL . $GSADMIN . "/load.php?id=formCreator'>";
    }


    function saveForm()
    {

        if (isset($_POST['formname']) && $_POST['formname'] !== '') {

            global $SITEURL;
            global $GSADMIN;

            $ars = [];

            $temp = [];


            foreach ($_POST as $key => $value) {

                if ($key === 'formname' || $key === 'saveform' || $key === 'requiredinput') {
                    continue; // Skip these keys
                };

                $temp[$key] = $value;
            }

            foreach ($temp as $key => $value) {
                $baseKey = preg_replace('/^(type-|label-|required-)/', '', $key);

                if (!isset($ars[$baseKey])) {
                    $ars[$baseKey] = []; 
                }

                $ars[$baseKey][] = $value;
            }

            $json = json_encode($ars, JSON_PRETTY_PRINT);

            $file = file_exists(GSDATAOTHERPATH . 'formCreator/') || mkdir(GSDATAOTHERPATH . 'formCreator/', 0755);

            if ($file) {

                file_put_contents(GSDATAOTHERPATH . 'formCreator/' . @$_POST['formname'] . '.json', $json);
            }

            echo "<meta http-equiv='refresh' content='0;url=" . $SITEURL . $GSADMIN . "/load.php?id=formCreator&editform=" . $_POST['formname'] . "'>";
        }
    }
};
