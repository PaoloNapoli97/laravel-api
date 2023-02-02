<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Technology::truncate();
        Schema::enableForeignKeyConstraints();

        $technologies = ['wifi', 'optic fiber', 'bio', 'futuristic'];

        foreach($technologies as $technology) {

            $new_technology = new Technology();
            $new_technology->typology = $technology;
            $new_technology->slug = Str::slug($new_technology->typology);
            $new_technology->save();
        }
    }
}
