<?php
namespace app\core\form;
use app\core\form\BaseField;
use app\core\Model;

class TextareaField extends BaseField
{
    public function __construct(Model $model, string $attribute)
    {

        parent::__construct($model, $attribute);
    }
public function renderInput(){
    
        return sprintf(
            '<textarea  name="%s" class="form-control%s">  %s </textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->model->{$this->attribute},
        );
}

}?>