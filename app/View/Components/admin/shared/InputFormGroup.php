<?php

namespace App\View\Components\Admin\Shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputFormGroup extends Component
{
    public $label;

    public $name;

    public $value;

    public $errorKey;

    public $type;

    public function __construct($label, $name, $value = '', $errorKey = null, $type = 'text')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = old($name, $value);
        $this->errorKey = $errorKey ?? $name;
        $this->type = $type;
    }

    public function render(): View|Closure|string
    {
        return view('components.Admin.Shared.input-form-group');
    }
}
