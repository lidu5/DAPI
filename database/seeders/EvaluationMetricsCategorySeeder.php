<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EvaluationMetricsCategory;

class EvaluationMetricsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $evaluation_metrics_categories = [
            [
                "name"=> "Performance",
                "weight"=>15
            ],
            [
                "name"=> "Interoperability",
                "weight"=>15
            ],
            [
                "name"=> "Accessibility",
                "weight"=>13
            ],
            [
                "name"=> "Scalability",
                "weight"=>9
            ],
            [
                "name"=> "Security",
                "weight"=>15
            ],
            [
                "name"=> "Sustainability",
                "weight"=>13
            ],
            [
                "name"=> "Technology",
                "weight"=>10
            ],
            [
                "name"=> "Documentation Quality test",
                "weight"=>10
            ]
        ];

        EvaluationMetricsCategory::insert($evaluation_metrics_categories);

    }
}
