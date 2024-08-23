<div class="w3-parent">

    <h3>Form Creator <?php echo i18n_r('formCreator/LIST');?> 💌</h3>

    <a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=formCreator&addnewform'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black"><?php echo i18n_r('formCreator/ADD_NEW');?></a>
    <a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=formCreator&settings'; ?>" style="text-decoration:none !important;" class=" w3-button w3-black w3-margin-bottom w3-hover-black"><?php echo i18n_r('formCreator/SETTINGS');?></a>


    <ul class="w3-ul w3-border" style="margin:0;padding:0;">


        <?php foreach (glob(GSDATAOTHERPATH . 'formCreator/*.json') as $file): ?>


            <?php if (pathinfo($file)['filename'] !== 'settings'): ?>

                <li style="display:flex;justify-content:space-between;margin:align-items:center;">
                    <h6 style="font-weight:bold;"> <?php echo pathinfo($file)['filename']; ?> </h6>

                    <p style="margin-top:8px;display:block;font-size:0.9rem;color:#333;">&lt;?php showFormCreator('<?php echo pathinfo($file)['filename']; ?>');?></p>

                    <div class="link">
                        <a href="?id=formCreator&editform=<?php echo pathinfo($file)['filename']; ?>" class="w3-button  w3-black w3-button w3-tiny w3-hover-black" style="text-decoration:none !important;"><?php echo i18n_r('formCreator/EDIT');?></a>
                        <a href="?id=formCreator&delete=<?php echo pathinfo($file)['filename']; ?>" class="w3-button w3-red w3-button w3-tiny w3-hover-black" onclick="confirm('<?php echo i18n_r('formCreator/QUESTION');?>')" style="text-decoration:none !important;"><?php echo i18n_r('formCreator/DELETE');?></a>
                    </div>
                </li>

            <?php endif; ?>

        <?php endforeach; ?>

    </ul>

</div>