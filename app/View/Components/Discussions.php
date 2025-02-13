<?php

namespace App\View\Components;

use App\Models\Discussion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Discussions extends Component
{
    public $discussions;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->discussions = Discussion::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('discussions.index');
    }
}
