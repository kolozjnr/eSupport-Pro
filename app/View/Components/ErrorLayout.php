<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ErrorLayout extends Component
{
    public $title;
    public $code;
    public $iconClass;
    public $icon;
    public $errorTitle;
    public $message;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = 'Error',
        $code = '500',
        $iconClass = 'error-default',
        $icon = '?',
        $errorTitle = 'Something went wrong',
        $message = 'We encountered an unexpected error. Please try again later.'
    ) {
        $this->title = $title;
        $this->code = $code;
        $this->iconClass = $iconClass;
        $this->icon = $icon;
        $this->errorTitle = $errorTitle;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.error-layout');
    }
}