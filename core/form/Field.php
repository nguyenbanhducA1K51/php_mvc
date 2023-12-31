<?php 
namespace app\core\form;
use app\core\Model;
use app\core\form\BaseField;


class Field extends BaseField{

    public function __construct(Model $model,string $attribute){
        $this->type=self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }
    
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput()
    {
        return sprintf(
            '<input type="%s" name="%s"  value= "%s" class="form-control %s">', 
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
        );
    }
    
}
