<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\City;
class CitySeeder extends Seeder { public function run():void{foreach(['Fès','Taza','Casablanca','Rabat','Marrakech','Tangier','Agadir','Meknès','Oujda'] as $name) City::firstOrCreate(['name'=>$name]);} }
