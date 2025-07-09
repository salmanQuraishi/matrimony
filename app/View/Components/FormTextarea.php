<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormTextarea extends Component
{
    public $id, $label, $name, $rows, $value, $placeholder;

    public function __construct(
        $id,
        $label = '',
        $name = '',
        $rows = 3,
        $value = '',
        $placeholder = ''
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->name = $name;
        $this->rows = $rows;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.form-textarea');
    }
}