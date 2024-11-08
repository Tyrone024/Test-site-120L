<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BodyContent extends Component
{
    public $workspaces;
    public $userspaces;
    /**
     * Create a new component instance.
     */
    public function __construct($workspaces, $userspaces)
    {
        $this->workspaces = $workspaces;
        $this->userspaces = $userspaces;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.body-content');
    }
}
