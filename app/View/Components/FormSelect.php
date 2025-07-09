<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelect extends Component
{
    public $label;
    public $id;
    public $name;
    public $options;
    public $selected;

    public function __construct($label = 'Large Select', $id = 'largeSelect', $name = 'largeSelect', $options = [], $selected = null)
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.form-select');
    }
}