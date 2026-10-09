<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DigitalHealthIntervention;

class DigitalHealthInterventionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $digital_health_interventions = [
            [
              "name"=> "Transmit health event alerts to specific population group(s)",
              "type"=> "PERSON",
              "category"=> "Targeted communication to Persons"
            ],
            [
              "name"=> "Transmit targeted health information to person(s) based on health status or demographics",
              "type"=> "PERSON",
              "category"=> "Targeted communication to Persons"
            ],
            [
              "name"=> "Transmit targeted alerts and reminders to person(s)",
              "type"=> "PERSON",
              "category"=> "Targeted communication to Persons"
            ],
            [
              "name"=> "Transmit diagnostics result, or availability of result, to person(s)",
              "type"=> "PERSON",
              "category"=> "Targeted communication to Persons"
            ],
            [
              "name"=> "Transmit untargeted health information to an undefined population",
              "type"=> "PERSON",
              "category"=> "Untargeted communication to Persons"
            ],
            [
              "name"=> "Transmit untargeted health event alerts to undefined group",
              "type"=> "PERSON",
              "category"=> "Untargeted communication to Persons"
            ],
            [
              "name"=> "Peer group for individuals",
              "type"=> "PERSON",
              "category"=> "Person to Person communication"
            ],
            [
              "name"=> "Access by the individual to own medical or summary health records",
              "type"=> "PERSON",
              "category"=> "Personal health tracking"
            ],
            [
              "name"=> "Self monitoring of health or diagnostic data by the individual",
              "type"=> "PERSON",
              "category"=> "Personal health tracking"
            ],
            [
              "name"=> "Active data capture/ documentation by an individual",
              "type"=> "PERSON",
              "category"=> "Personal health tracking"
            ],
            [
              "name"=> "Access by the individual to verifiable documentation of a health event or health status",
              "type"=> "PERSON",
              "category"=> "Personal health tracking"
            ],
            [
              "name"=> "Reporting of health system feedback by persons",
              "type"=> "PERSON",
              "category"=> "Person based reporting"
            ],
            [
              "name"=> "Reporting of public health events by persons",
              "type"=> "PERSON",
              "category"=> "Person based reporting"
            ],
            [
              "name"=> "Look-up of information on health and health services by individuals",
              "type"=> "PERSON",
              "category"=> "On demand communication with persons"
            ],
            [
              "name"=> "Simulated human-like conversations with individual(s)",
              "type"=> "PERSON",
              "category"=> "On demand communication with persons"
            ],
            [
              "name"=> "Transmit or manage out- of-pocket payments by individuals",
              "type"=> "PERSON",
              "category"=> "Person-centred financial transactions"
            ],
            [
              "name"=> "Transmit or manage vouchers to individuals for health services",
              "type"=> "PERSON",
              "category"=> "Person-centred financial transactions"
            ],
            [
              "name"=> "Transmit or manage incentives to individuals for health services",
              "type"=> "PERSON",
              "category"=> "Person-centred financial transactions"
            ],
            [
              "name"=> "Manage provision and withdrawal of consent by individuals",
              "type"=> "PERSON",
              "category"=> "Person-centred consent management"
            ],
            [
              "name"=> "Verify a person’s unique identity",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Identification and registration of persons"
            ],
            [
              "name"=> "Enrol person(s) for health services/clinical care plan",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Identification and registration of persons"
            ],
            [
              "name"=> "Longitudinal tracking of person’s health status and services",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Person-centred health records"
            ],
            [
              "name"=> "Manage person-centred structured clinical records",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Person-centred health records"
            ],
            [
              "name"=> "Manage person-centred unstructured clinical records (e.g. notes, images, documents)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Person-centred health records"
            ],
            [
              "name"=> "Routine health indicator data collection and management",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Person-centred health records"
            ],
            [
              "name"=> "Consultations between remote person and healthcare provider",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Telemedicine"
            ],
            [
              "name"=> "Remote monitoring of person’s health or diagnostic data by provider",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Telemedicine"
            ],
            [
              "name"=> "Transmission of medical data (e.g. images, notes, and videos) to healthcare provider",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Telemedicine"
            ],
            [
              "name"=> "Consultations for case management between healthcare providers",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Telemedicine"
            ],
            [
              "name"=> "Communication from healthcare provider to supervisor(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Communication and performance feedback to healthcare provider(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Transmit routine news and workﬂow notifications to healthcare provider(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Transmit non-routine health event alerts to healthcare provider(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Peer group for healthcare providers",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Generative AI for tailored content creation",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider communication"
            ],
            [
              "name"=> "Coordinate emergency response and transport",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Referral coordination"
            ],
            [
              "name"=> "Manage referrals between points of service within health sector",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Referral coordination"
            ],
            [
              "name"=> "Identify persons in need of services",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Scheduling and activity planning for healthcare providers"
            ],
            [
              "name"=> "Schedule healthcare provider’s activities",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Scheduling and activity planning for healthcare providers"
            ],
            [
              "name"=> "Provide training content to healthcare provider(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider training"
            ],
            [
              "name"=> "Assess capacity of healthcare provider(s)",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider training"
            ],
            [
              "name"=> "Transmit or track prescription orders",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Prescription and medication management"
            ],
            [
              "name"=> "Track individual’s medication consumption",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Prescription and medication management"
            ],
            [
              "name"=> "Report adverse drug eﬀects",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Prescription and medication management"
            ],
            [
              "name"=> "Transmit person’s diagnostic result to healthcare provider",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Laboratory and diagnostics imaging management"
            ],
            [
              "name"=> "Transmit and track diagnostic orders",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Laboratory and diagnostics imaging management"
            ],
            [
              "name"=> "Capture diagnostic results from digital devices",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Laboratory and diagnostics imaging management"
            ],
            [
              "name"=> "Track biological specimens",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Laboratory and diagnostics imaging management"
            ],
            [
              "name"=> "Verify individual’s health coverage and financing scheme membership",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider financial transactions"
            ],
            [
              "name"=> "Receive payments from individuals",
              "type"=> "HEALTHCARE PROVIDERS",
              "category"=> "Healthcare provider financial transactions"
            ],
            [
              "name"=> "List health workforce cadres and related identification information",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Human resource management"
            ],
            [
              "name"=> "Monitor performance of healthcare provider(s)",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Human resource management"
            ],
            [
              "name"=> "Manage registration/ certification of healthcare provider(s)",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Human resource management"
            ],
            [
              "name"=> "Record training credentials of healthcare provider(s)",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Human resource management"
            ],
            [
              "name"=> "Manage health workforce activities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Human resource management"
            ],
            [
              "name"=> "Manage inventory and distribution of health commodities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Notify stock levels of health commodities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Monitor cold-chain sensitive commodities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Register licensed drugs and health commodities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Manage procurement of commodities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Report counterfeit or substandard drugs by persons",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Supply chain management"
            ],
            [
              "name"=> "Notification of public health events from point of diagnosis",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "SPublic health event notification"
            ],
            [
              "name"=> "Notify, register and certify birth event",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Civil Registration and Vital Statistics (CRVS)"
            ],
            [
              "name"=> "Notify, register and certify death event",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Civil Registration and Vital Statistics (CRVS)"
            ],
            [
              "name"=> "Register and verify health coverage scheme membership of persons",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Track and manage insurance billing and claims processes",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Transmit and manage payments to health facilities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Transmit and manage routine payroll payment to healthcare provider(s)",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Transmit or manage financial incentives to healthcare provider(s)",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Manage and plan budget allocations, revenue and expenditures",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Determine level of subsidies for health coverage schemes",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Collect health insurance contributions",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Health system financial management"
            ],
            [
              "name"=> "Monitor status and maintenance of health equipment",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Equipment and asset management"
            ],
            [
              "name"=> "Track regulation and licensing of medical equipment",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Equipment and asset management"
            ],
            [
              "name"=> "List health facilities and related information",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Facility management"
            ],
            [
              "name"=> "Assess health facilities",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Facility management"
            ],
            [
              "name"=> "Register and store current health certificate information",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Person-centred health certificate management"
            ],
            [
              "name"=> "Retrieve and validate current health certificate information",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Person-centred health certificate management"
            ],
            [
              "name"=> "Revoke and update health certificate",
              "type"=> "HEALTH MANAGEMENT AND SUPPORT PERSONNEL",
              "category"=> "Person-centred health certificate management"
            ],
            [
              "name"=> "Form creation for data acquisition",
              "type"=> "DATA SERVICES",
              "category"=> "Data Management"
            ],
            [
              "name"=> "Data storage and aggregation",
              "type"=> "DATA SERVICES",
              "category"=> "Data Management"
            ],
            [
              "name"=> "Data synthesis and visualizations",
              "type"=> "DATA SERVICES",
              "category"=> "Data Management"
            ],
            [
              "name"=> "Automated analysis of data to generate new information or predictions on future events",
              "type"=> "DATA SERVICES",
              "category"=> "Data Management"
            ],
            [
              "name"=> "Parse unstructured data into structured data",
              "type"=> "DATA SERVICES",
              "category"=> "Data coding"
            ],
            [
              "name"=> "Merge, de-duplicate and curate coded datasets or terminologies",
              "type"=> "DATA SERVICES",
              "category"=> "Data coding"
            ],
            [
              "name"=> "Classify disease codes or cause of mortality",
              "type"=> "DATA SERVICES",
              "category"=> "Data coding"
            ],
            [
              "name"=> "Map location of health facilities/structures and households",
              "type"=> "DATA SERVICES",
              "category"=> "Geo spatial information management"
            ],
            [
              "name"=> "Map location of health event",
              "type"=> "DATA SERVICES",
              "category"=> "Geo spatial information management"
            ],
            [
              "name"=> "Map location of persons and settlements",
              "type"=> "DATA SERVICES",
              "category"=> "Geo spatial information management"
            ],
            [
              "name"=> "Map location of healthcare provider(s)",
              "type"=> "DATA SERVICES",
              "category"=> "Geo spatial information management"
            ],
            [
              "name"=> "Map health and health indicator data to geographic data",
              "type"=> "DATA SERVICES",
              "category"=> "Geo spatial information management"
            ],
            [
              "name"=> "Point-to-point data integration",
              "type"=> "DATA SERVICES",
              "category"=> "Data exchange and Interoperability"
            ],
            [
              "name"=> "Standards-compliant interoperability",
              "type"=> "DATA SERVICES",
              "category"=> "Data exchange and Interoperability"
            ],
            [
              "name"=> "Message routing",
              "type"=> "DATA SERVICES",
              "category"=> "Data exchange and Interoperability"
            ],
            [
              "name"=> "Authentication and authorisation",
              "type"=> "DATA SERVICES",
              "category"=> "Data governance compliance"
            ],
            [
              "name"=> "Data privacy protection",
              "type"=> "DATA SERVICES",
              "category"=> "Data governance compliance"
            ],
            [
              "name"=> "Data consent and provenance",
              "type"=> "DATA SERVICES",
              "category"=> "Data governance compliance"
            ],
            [
              "name"=> "Trust architecture",
              "type"=> "DATA SERVICES",
              "category"=> "Data governance compliance"
            ]
        ];
        
        DigitalHealthIntervention::insert($digital_health_interventions);
    }
}
