<?php

use app\core\form\TextareaField;
?>
<h1> Contact us </h1>
<?php  
use app\models\ContactForm;
use app\core\form\Form;
$form = Form::begin('','post')?>

<?php  echo $form->field($model,'subject')?>
<?php  echo $form ->field ($model,'email')?>
<?php echo new TextareaField($model, 'body') ?>
<button type="submit" class="btn btn-primary mt-3"> Submit</button>
<?php Form::end()?>
