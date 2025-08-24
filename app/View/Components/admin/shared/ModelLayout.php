<?php

namespace App\View\Components\Admin\Shared;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModelLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $id = 'model-box', public string $title = 'Model Title')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.Admin.Shared.model-layout');
    }
}
