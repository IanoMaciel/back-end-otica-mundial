<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory {

    protected  $materials = [
        'Acetato',
        'Acetato Fechado',
        'Nylon/Metal',
    ];

    protected static  $i = 0;

    public function definition(): array{
        $currentMaterial = $this->materials[static::$i % count($this->materials)];
        static::$i++;
        return [
            'material' => $currentMaterial
        ];
    }

    public function resetBrandSequence(): self {
        static::$i = 0;
        return $this;
    }
}
