<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    private array $baseClasses = [
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
        'whitespace-nowrap',
        'select-none',
        'appearance-none',
        'rounded',
        'shadow-none'
    ];

    /**
     * @param string $as button|link
     * @param string $variant base|primary|secondary
     */
    public function __construct(
        public string $as = 'button',
        public string $variant = 'base',
        public bool $isDisabled = false
    ) {
    }

    private function getClasses(): array
    {
        $result = $this->baseClasses;

        $variantClasses = match ($this->variant) {
            'base' => ['bg-white', 'border-gray-200', 'text-black'],
            'primary' => ['bg-primary', 'border-transparent', 'text-white'],
            'secondary' => ['bg-secondary', 'border-transparent', 'text-white'],
        };

        $result = array_merge($result, $variantClasses);

        if ($this->isDisabled) {
            $result[] = 'bg-gray-200 border-gray-200 text-gray-500 opacity-50 cursor-not-allowed';
        }

        return $result;
    }

    public function render(): View
    {
        $props = [
            'classes' => implode(' ', $this->getClasses())
        ];

        return view('components.button', $props);
    }
}
