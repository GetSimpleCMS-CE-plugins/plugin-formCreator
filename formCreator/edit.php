<h3><?php echo i18n_r('formCreator/CREATEEDITFORM');?></h3>
<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=formCreator'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black"><?php echo i18n_r('formCreator/BACKTOLIST');?></a>


<div class="w3-black ">
    <input name="nameform" required placeholder="<?php echo i18n_r('formCreator/PLACEHOLDERINFO');?>"

        <?php if (isset($_GET['editform'])) {
            echo 'value="' . $_GET['editform'] . '"';
        }; ?>

        onchange="processInput()" style="width:100%;padding:10px;box-sizing:border-box;margin-bottom:5px;">

</div>

<div class="w3-panel w3-border  w3-blue-grey w3-padding">

    <label class="w3-text-white" for=""><?php echo i18n_r('formCreator/LABELTYPE');?></label>
    <input type="text" class="labelinput w3-border" required style="width:100%;padding:5px;background:#fff;margin-top:5px;">


    <label class="w3-text-white" for=""><?php echo i18n_r('formCreator/INPUTTYPE');?></label>
    <select class="typeinput w3-border" style="width:100%;padding:5px;background:#fff;margin-top:5px;">
        <option value="checkbox">Checkbox</option>
        <option value="color">Color</option>
        <option value="date">Date</option>
        <option value="datetime-local">Datetime Local</option>
        <option value="email">Email</option>
        <option value="month">Month</option>
        <option value="number">Number</option>
        <option value="password">Password</option>
        <option value="radio">Radio</option>
        <option value="range">Range</option>
        <option value="tel">Telephone</option>
        <option value="text">Text</option>
        <option value="time">Time</option>
        <option value="week">Week</option>
        <option value="textarea">Textarea</option>

    </select>

    <label class="w3-text-white" for="" style="display:flex;align-items:center;gap:5px;margin-top:10px;"><?php echo i18n_r('formCreator/REQUIRED');?> ?  <input type="checkbox" class="requiredinput"></label>

   

    <button class="addtoinput w3-button w3-green w3-margin-top w3-margin-bottom w3-hover-black"><?php echo i18n_r('formCreator/ADDTOFORM');?></button>

</div>


<form method="POST" class="formcreatorform" id="formcreatorform">


    <input type="hidden" name="formname" required placeholder="form name"


        style="width:100%;padding:10px;box-sizing:border-box;margin-bottom:5px;">


    <?php

    if (isset($_GET['editform'])) {
        $formClass->editform($_GET['editform']);
    }; ?>


    <input type="submit" name="saveform" value="<?php echo i18n_r('formCreator/SAVEFORM');?>" class="saveform w3-button w3-green w3-hover-green">
</form>



<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>


<script>
    const addToInput = document.querySelector('.addtoinput');
    const formCreatorForm = document.querySelector('.formcreatorform .saveform');


    function encodeBase64(text) {
        return btoa(unescape(encodeURIComponent(text)));
    }



    function processInput() {
        const inputField = document.getElementById('username');
        let value = inputField.value;
        // Convert to lowercase
        value = value.toLowerCase();
        // Remove spaces
        value = value.replace(/\s+/g, '');
        // Update input field with modified value
        inputField.value = value;
    }

    addToInput.addEventListener('click', (e) => {
        e.preventDefault();

        let labelInput = document.querySelector('.labelinput').value;
        let typeInput = document.querySelector('.typeinput').value;

        let timestamp = new Date().toISOString();
        let encodedTimestamp = encodeBase64(timestamp);

        let hash = encodedTimestamp;

        if(document.querySelector('.requiredinput').checked){
            requiredInput = 'on';
        }else{
            requiredInput ='';
        }


        if (labelInput.trim() !== '') {
            formCreatorForm.insertAdjacentHTML('beforebegin', `
        
       
        <div class="w3-border w3-panel w3-light-grey w3-padding-16" style="position:relative;padding-top:30px !important;">
                   <button onclick="event.preventDefault();this.parentElement.remove()" class="w3-btn w3-hover-black w3-red closethis" style="position:absolute;top:0;right:0;">X</button>
                 
    <label>Label</label>
    
           <input type="text" name="label-${hash}" value="${labelInput}" style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
         
   
         
         <label>Type</label>
      <select name="type-${hash}" style="width:100%; margin:10px 0;background:#fff;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
            <option value="checkbox" ${typeInput == 'checkbox' ? 'selected':''}>Checkbox</option>
           <option value="color" ${typeInput == 'color' ? 'selected':''}>Color</option>
           <option value="date" ${typeInput == 'date' ? 'selected':''}>Date</option>
           <option value="datetime-local" ${typeInput == 'datetime-local' ? 'selected':''}>Datetime Local</option>
           <option value="email" ${typeInput == 'email' ? 'selected':''}>Email</option>
           <option value="hidden" ${typeInput == 'hidden' ? 'selected':''}>Hidden</option>
           <option value="month" ${typeInput == 'month' ? 'selected':''}>Month</option>
           <option value="number" ${typeInput == 'number' ? 'selected':''}>Number</option>
           <option value="password" ${typeInput == 'password' ? 'selected':''}>Password</option>
           <option value="radio" ${typeInput == 'radio' ? 'selected':''}>Radio</option>
           <option value="range" ${typeInput == 'range' ? 'selected':''}>Range</option>
           <option value="tel" ${typeInput == 'tel' ? 'selected':''}>Telephone</option>
           <option value="text" ${typeInput == 'text' ? 'selected':''}>Text</option>
           <option value="time" ${typeInput == 'time' ? 'selected':''}>Time</option>
            <option value="week" ${typeInput == 'week' ? 'selected':''}>Week</option>
           <option value="textarea" ${typeInput == 'textarea' ? 'selected':''}>Textarea</option>
       </select>
   
   
                  <label style="display:flex;align-items:center;gap:5px;margin-top:10px;margin-bottom:10px;"><?php echo i18n_r('formCreator/REQUIRED');?>?</label>
                       <input name="required-${hash}" type="checkbox" ${requiredInput == "on" ? "checked": "" }>
       </div>
   
        
   
         `);

        } else {
            alert('<?php echo i18n_r('formCreator/LABELEMPTY');?>');
        };



    })


    var el = document.getElementById('formcreatorform');
    var sortable = Sortable.create(el, {
        animation: 200,
        group: 'w3-panel',
        handle: '.w3-panel'
    });



    document.querySelector("input[name='formname']").value = document.querySelector('input[name="nameform"]').value;


    document.querySelector('input[name="nameform"]').addEventListener('input', x => {
        document.querySelector("input[name='formname']").value = document.querySelector('input[name="nameform"]').value;
    })
</script>


<?php

if (isset($_POST['saveform'])) {

    $formClass->saveForm();
};

?>