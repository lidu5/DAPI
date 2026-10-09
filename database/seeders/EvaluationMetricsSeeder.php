<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EvaluationMetricsCategory;
use App\Models\EvaluationMetrics;

class EvaluationMetricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $evaluation_metrics = [
            [
                "elements" => "Response time",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Performance")->first()->id
            ],
            [
                "elements" => "Concurrent user load",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Performance")->first()->id
            ],
            [
                "elements" => "Resource Consumption Vs the specification",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Performance")->first()->id
            ],
            [
                "elements" => "Network Through Output",
                "weight" => 2,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Performance")->first()->id
            ],
            [
                "elements" => "Error Rate",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Performance")->first()->id
            ],
            [
                "elements" => "Messaging/Data Exchange",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Interoperability")->first()->id
            ],
            [
                "elements" => "Standards Compliance",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Interoperability")->first()->id
            ],
            [
                "elements" => "FHIR Compliance",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Interoperability")->first()->id
            ],
            [
                "elements" => "API Availability",
                "weight" => 6,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Interoperability")->first()->id
            ],
            [
                "elements" => "Localization(Language)",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Accessibility")->first()->id
            ],
            [
                "elements" => "Disability and Gender inclusiveness",
                "weight" => 2,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Accessibility")->first()->id
            ],
            [
                "elements" => "Ethiopian Calendar Support",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Accessibility")->first()->id
            ],
            [
                "elements" => "Responsive Design",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Accessibility")->first()->id
            ],
            [
                "elements" => "Horizontal Scalability",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Scalability")->first()->id
            ],
            [
                "elements" => "Database Scalability",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Scalability")->first()->id
            ],
            [
                "elements" => "Functionality(modular) scalability",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Scalability")->first()->id
            ],
            [
                "elements" => "Activity/Auditing Log",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Security")->first()->id
            ],
            [
                "elements" => "Authentication",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Security")->first()->id
            ],
            [
                "elements" => "Authorization",
                "weight" => 5,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Security")->first()->id
            ],
            [
                "elements" => "Encryption",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Security")->first()->id
            ],
            [
                "elements" => "OpenSource/ Community Support",
                "weight" => 6,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Sustainability")->first()->id
            ],
            [
                "elements" => "Resource required",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Sustainability")->first()->id
            ],
            [
                "elements" => "Maintainability",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Sustainability")->first()->id
            ],
            [
                "elements" => "Source code",
                "weight" => 6,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Sustainability")->first()->id
            ],
            [
                "elements" => "Platform Compatibility",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Technology")->first()->id
            ],
            [
                "elements" => "Recently and Stable Version support",
                "weight" => 3,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Technology")->first()->id
            ],
            [
                "elements" => "Offline support",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Technology")->first()->id
            ],
            [
                "elements" => "SRS, Design and Architecture  Documentation",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Documentation Quality test")->first()->id
            ],
            [
                "elements" => "Developer manual & API reference",
                "weight" => 4,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Documentation Quality test")->first()->id
            ],
            [
                "elements" => "Installation",
                "weight" => 2,
                "evaluation_metrics_category_id" => EvaluationMetricsCategory::where("name", "Documentation Quality test")->first()->id
            ]
        ];

        EvaluationMetrics::insert($evaluation_metrics);
    }
}
