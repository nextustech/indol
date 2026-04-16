<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Slider as SliderModel;

class slider extends Component
{
    public $sliders;

     public function __construct()
    {
        $this->sliders = SliderModel::where('status',1)
                    ->orderBy('order')
                    ->get();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.slider');
    }
}
