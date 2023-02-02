<?php

namespace Database\Factories\Crghome\Shop;

use Crghome\Shop\Models\Shop\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $parentId = rand(0,1) > 0.8 ? Category::all()->random()->id : null;
        $name = $this->faker->unique->text(35);
        return [
            'category_id' => $parentId,
            'name' => $name,
            'alias' => Str::slug($name),
            'path' => Str::slug($name),
            'dateBeginPub' => now(),
            'order' => 999,
        ];
    }
}
