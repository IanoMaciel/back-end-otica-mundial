<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TypeLensFactory extends Factory {
    protected  $typeLens = [
        'Visão Simples',
	    'Multifocal',
	    'Bifocal',
	    'Visão Simples Pronta',
	    'Visão Simples Surfaçada',
    ];

    protected static  $i = 0;

    public function definition(): array {
        $currentTypeLens = $this->typeLens[static::$i % count($this->typeLens)];
        static::$i++;
        return [
            'type_lens' => $currentTypeLens,
        ];
    }
}
