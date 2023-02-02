<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Type::truncate();
        Schema::enableForeignKeyConstraints();

        $types = [
            'Business implementation',
            'Foundational (business improvement)',
            'IT infrastructure improvement',
            'Product development (IT)',
            'Product development (non-IT)',
            'Physical engineering/construction',
            'Physical infrastructure improvement',
            'Procurement',
            'Regulatory/compliance',
            'Research and Development (R&D)',
            'Service development',
            'Transformation/reengineering'
        ];

        foreach($types as $type) {

            $new_type = new Type();
            $new_type->develop = $type;
            $new_type->slug = Str::slug($new_type->develop);
            $new_type->save();
        }
    }
}
