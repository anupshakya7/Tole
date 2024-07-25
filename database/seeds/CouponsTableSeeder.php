<?php

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
			'code'=>'ABC213',
			'type'=>'fixed',
			'value'=>30
		]);
		
		 Coupon::create([
			'code'=>'DEF456',
			'type'=>'fixed',
			'value'=>30
		]);
    }
}
