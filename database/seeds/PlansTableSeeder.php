<?php

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = new Plan();
        $plan->name = 'Monthly';
        $plan->amount = 400;
        $plan->duration = 1;
        $plan->save();

        $plan = new Plan();
        $plan->name = 'Quarterly';
        $plan->amount = 500;
        $plan->duration = 4;
        $plan->save();
    }
}
