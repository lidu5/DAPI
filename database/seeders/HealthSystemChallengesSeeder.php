<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HealthSystemChallenge;

class HealthSystemChallengesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $health_system_challenges = [
            [
              "name"=> "Lack of population denominator",
              "category"=> "Information"
            ],
            [
              "name"=> "Delayed reporting of events",
              "category"=> "Information"
            ],
            [
              "name"=> "Lack of quality/reliable data",
              "category"=> "Information"
            ],
            [
              "name"=> "Communication roadblocks",
              "category"=> "Information"
            ],
            [
              "name"=> "Lack of access information or data (including disaggregated data)",
              "category"=> "Information"
            ],
            [
              "name"=> "Insufficient utilization of data and information",
              "category"=> "Information"
            ],
            [
              "name"=> "Lack of unique identifier",
              "category"=> "Information"
            ],
            [
              "name"=> "Insufficient supply of commodities",
              "category"=> "Availability"
            ],
            [
              "name"=> "Insufficient supply of services",
              "category"=> "Availability"
            ],
            [
              "name"=> "Insufficient supply of equipment",
              "category"=> "Availability"
            ],
            [
              "name"=> "Insufficient supply of qualified health workers",
              "category"=> "Availability"
            ],
            [
              "name"=> "Poor patient experience",
              "category"=> "Quality"
            ],
            [
              "name"=> "Insufficient health worker competence",
              "category"=> "Quality"
            ],
            [
              "name"=> "Low quality of health commodities",
              "category"=> "Quality"
            ],
            [
              "name"=> "Low health worker motivation",
              "category"=> "Quality"
            ],
            [
              "name"=> "Insufficient continuity of care",
              "category"=> "Quality"
            ],
            [
              "name"=> "Inadequate supportive supervision",
              "category"=> "Quality"
            ],
            [
              "name"=> "Poor adherence to evidence- based standards, guidelines and protocols",
              "category"=> "Quality"
            ],
            [
              "name"=> "Inadequate identification and management of risks",
              "category"=> "Quality"
            ],
            [
              "name"=> "Lack of alignment with local norms",
              "category"=> "Acceptability"
            ],
            [
              "name"=> "Not addressing individual beliefs and practices",
              "category"=> "Acceptability"
            ],
            [
              "name"=> "Low demand for services",
              "category"=> "Utilization"
            ],
            [
              "name"=> "Geographical inaccessibility",
              "category"=> "Utilization"
            ],
            [
              "name"=> "Low adherence to treatment",
              "category"=> "Utilization"
            ],
            [
              "name"=> "Loss to follow up",
              "category"=> "Utilization"
            ],
            [
              "name"=> "Inadequate workflow management",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Lack of or inappropriate referrals",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Poor planning and coordination",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Delayed provision of care",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Inadequate access to transportation and other health services",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Burden of manual processes",
              "category"=> "Efficiency"
            ],
            [
              "name"=> "Lack of eﬀective and equitable resource allocation",
              "category"=> "Cost"
            ],
            [
              "name"=> "Catastrophic health expenditure",
              "category"=> "Cost"
            ],
            [
              "name"=> "Lack of coordinated payer mechanism",
              "category"=> "Cost"
            ],
            [
              "name"=> "Lack of financial protection for persons",
              "category"=> "Cost"
            ],
            [
              "name"=> "Insufficient person(s) and community engagement",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Unaware of service entitlement",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Absence of community feedback mechanisms",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Lack of transparency in commodity transactions",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Poor accountability between the levels of the health sector",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Inadequate understanding of beneficiary populations",
              "category"=> "Accountability"
            ],
            [
              "name"=> "Inadequate literacy",
              "category"=> "Equity"
            ],
            [
              "name"=> "Inadequate representation",
              "category"=> "Equity"
            ]
        ];

        HealthSystemChallenge::insert($health_system_challenges);
    }
}
