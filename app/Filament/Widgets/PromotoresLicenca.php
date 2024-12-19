<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PromotoresLicenca extends ChartWidget
{
    protected static ?string $heading = 'Promotores Licença';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Promotores',
                    'data' => [10, 20, 30, 40, 50],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
