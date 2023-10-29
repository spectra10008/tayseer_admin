<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WebsiteVisitor>
 */
class WebsiteVisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-160 day');
        return [
            'ip_address' => $this->faker->localIpv4,
            'visit_date'=>$date,
            'created_at'=>$date,
		    'updated_at'=>$date
        ];
    }
}
