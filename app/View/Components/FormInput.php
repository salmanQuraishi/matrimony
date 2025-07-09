<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public $id, $label, $name, $value, $type, $placeholder;

    public function __construct(
        $id,
        $label = '',
        $name = '',
        $value = '',
        $type = 'text',
        $placeholder = '',
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.form-input');
    }
}