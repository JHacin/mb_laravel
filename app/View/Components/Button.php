<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Button extends Component
{
    /**
     * @param string $as button|link
     * @param string $variant base|primary|secondary
     * @param bool $isDisabled
     * @param string $icon [font-awesome class]
     * @param string $iconPosition start
     */
    public function __construct(
        public string $as = 'button',
        public string $variant = 'base',
        public bool $isDisabled = false,
        public string $icon = '',
        public string $iconPosition = 'start',
    ) {
    }

    public function generateAttributes(ComponentAttributeBag $attributes): ComponentAttributeBag
    {
        // cannot set disabled as falsy in HTML, so we only set it if isDisabled is true.
        if ($this->isDisabled) {
            $attributes = $attributes->merge(['disabled' => '', 'aria-disabled' => true]);
        }

        // button type has some of its own defaults
        if ($this->as === 'button') {
            $attributes = $attributes->merge(['type' => 'submit']);
        }

        // don't want empty href to cause page reload on click
        if (!$attributes['href']) {
            $attributes = $attributes->except('href');
        }

        return $attributes->merge(['class' => $this->generateClasses()]);
    }

    private function generateClasses(): string
    {
        $baseClasses = [
            'relative',
            'border',
            'text-center',
            'text-base',
            'leading-normal',
            'cursor-pointer',
            'inline-flex',
            'justify-center',
            'items-center',
            'align-top',
            'py-2',
            'px-3',
            'space-x-2',
            'whitespace-nowrap',
            'select-none',
            'appearance-none',
            'rounded',
            'shadow-none',
            'disabled:bg-gray-200',
            'disabled:border-gray-200',
            'disabled:text-gray-500',
            'disabled:opacity-50',
            'disabled:cursor-not-allowed'
        ];

        $colorVariantClasses = match ($this->variant) {
            'base' => ['bg-white', 'border-gray-200', 'text-black'],
            'primary' => ['bg-primary', 'border-transparent', 'text-white'],
            'secondary' => ['bg-secondary', 'border-transparent', 'text-white'],
        };

        return implode(' ', array_merge($baseClasses, $colorVariantClasses));
    }

    public function render(): View
    {
        return view('components.button');
    }
}
