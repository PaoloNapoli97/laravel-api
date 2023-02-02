<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use app\Models\Type;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\type;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Schema::disableForeignKeyConstraints();
        Project::truncate();
        Schema::enableForeignKeyConstraints();

        for ( $i = 0; $i<12; $i++){
            $type = Type::inRandomOrder()->first();

            $new_project = new Project();
            $new_project->title = $faker->sentence();
            $new_project->content = $faker->text(2000);
            $new_project->slug = Str::slug($new_project->title, '-');
            $new_project->type_id = (rand(1, 7) === 1) ? null : $type->id;
            $new_project->save();
        }
    }
}
