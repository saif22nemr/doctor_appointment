<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $patients = Patient::all();
        return [
            //
            'title' => $this->faker->title(),
            'date' => date('Y-m-d'),
            'time' => date('H:i'),
            'patient_id' => $patients->random(1)->first()->id,
            'status' => 1,
            'patient_status' => 0
        ];
    }
}
