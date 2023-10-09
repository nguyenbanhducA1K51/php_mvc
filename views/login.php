<?php 

?>
<h1> Login </h1>

<?php
use app\core\form\Form; ?>
<?php $form = Form::begin('', "post"); ?>
<div class="row">
</div>
<?php
echo $form->field($model, "email");
?>
<?php
echo $form->field($model, "password")->passwordField(); ?>

<div class="mt-3">
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>


<?php Form::end() ?>