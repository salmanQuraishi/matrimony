<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusSelect extends Component
{
    public $id;
    public $name;
    public $selected;

    public function __construct($id = 'Status', $name = 'status', $selected = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.status-select');
    }
}