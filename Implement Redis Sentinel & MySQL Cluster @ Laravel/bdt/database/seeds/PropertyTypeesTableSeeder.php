<?php

use Illuminate\Database\Seeder;

class PropertyTypeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyTypees = [
        	'Rumah', 'Apartemen', 'Tanah', 'Ruko', 'Gudang', 'Kost'
        ];

        \DB::table('property_typees')->truncate();

        foreach ($propertyTypees as $key => $property_type) {
          \App\Models\PropertyType::create([
            'name' => $property_type
          ]);
        }
    }
}
