<?php

namespace App\Enums;

enum TaskPeriod: string
{
    case Once = 'once';
    case Daily = 'daily';
    case Weekly = 'weekly';
    case Monthly = 'monthly';

    public function label(): string
    {
        return match ($this) {
            self::Once => 'Sekali',
            self::Daily => 'Harian',
            self::Weekly => 'Mingguan',
            self::Monthly => 'Bulanan',
        };
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function options(): array
    {
        return array_map(
            fn (self $period): array => [
                'value' => $period->value,
                'label' => $period->label(),
            ],
            self::cases()
        );
    }
}
