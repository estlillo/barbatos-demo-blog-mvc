<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2Multiple extends Component
{
    public $options;
    public $selected;
    public $name;
    public $label;
    public $placeholder;
    public $tags;
    public $id;
    public $valueField;
    public $textField;
    public $class;

    public function __construct(
        $options = [],
        $selected = [],
        $name = 'items',
        $label = null,
        $placeholder = 'Selecciona una o más opciones',
        $tags = false,
        $id = null,
        $valueField = 'id',
        $textField = 'name',
        $class = ''
    ) {
        $this->options = $options;
        $this->selected = $selected;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->tags = $tags;
        $this->id = $id ?? 'select2-' . uniqid();
        $this->valueField = $valueField;
        $this->textField = $textField;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.select2-multiple');
    }
}
