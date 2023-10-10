<?php
namespace app\core\form;

use app\core\Model;
abstract class BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput();
    
    public function __toString()
    {
        $sentence= sprintf(
            ' <div class="form-group">
        <label>%s</label>
                %s
            <div class="invalid-feedback">
            %s 
            </div>
        </div>'
            ,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
        
        return $sentence;

    }

    

}?>