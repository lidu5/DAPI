<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HealthFocusArea;

class HealthFocusAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $health_focus_areas = [
            [
              "name"=> "Adolescents and sexual and reproductive health"
            ],
            [
              "name"=> "Adolescents and violence"
            ],
            [
              "name"=> "Life-skills training"
            ],
            [
              "name"=> "Other adolescent and youth health"
            ],
            [
              "name"=> "School-based health programs"
            ],
            [
              "name"=> "Youth friendly services"
            ],
            [
              "name"=> "Civil registration and vital statistics"
            ],
            [
              "name"=> "Other civil registration and vital statistics"
            ],
            [
              "name"=> "Registration of clients and demographic information"
            ],
            [
              "name"=> "Blood Safety"
            ],
            [
              "name"=> "Immunizations"
            ],
            [
              "name"=> "Infection Prevention Control"
            ],
            [
              "name"=> "Other cross cutting"
            ],
            [
              "name"=> "Preparedness"
            ],
            [
              "name"=> "Surveillance"
            ],
            [
              "name"=> "Chemical safety"
            ],
            [
              "name"=> "Climate change impact on health"
            ],
            [
              "name"=> "Indoor air pollution"
            ],
            [
              "name"=> "Natural disaster risk mitigation and response"
            ],
            [
              "name"=> "Other Environmental"
            ],
            [
              "name"=> "Outdoor air pollution"
            ],
            [
              "name"=> "Water treatment (see also under Water Sanitation and Hygiene (WASH)"
            ],
            [
              "name"=> "Communicable diseases in humanitarian settings"
            ],
            [
              "name"=> "Migrant populations"
            ],
            [
              "name"=> "Other humanitarian health"
            ],
            [
              "name"=> "Sexual and Reproductive health in humanitarian settings"
            ],
            [
              "name"=> "COVID-19"
            ],
            [
              "name"=> "Ebola Viral Disease (EVD)"
            ],
            [
              "name"=> "Hepatitis"
            ],
            [
              "name"=> "Influenza"
            ],
            [
              "name"=> "Measles"
            ],
            [
              "name"=> "Meningitis"
            ],
            [
              "name"=> "Other hemorrhagic fever (e.g. Lassa fever)"
            ],
            [
              "name"=> "Other infectious diseases (non-vector borne)"
            ],
            [
              "name"=> "Pneumonia"
            ],
            [
              "name"=> "Polio"
            ],
            [
              "name"=> "Tuberculosis"
            ],
            [
              "name"=> "Burns"
            ],
            [
              "name"=> "Drowning"
            ],
            [
              "name"=> "Falls"
            ],
            [
              "name"=> "Occupational health"
            ],
            [
              "name"=> "Other injury prevention and management"
            ],
            [
              "name"=> "Poisonings"
            ],
            [
              "name"=> "Road traffic injuries"
            ],
            [
              "name"=> "Suicide"
            ],
            [
              "name"=> "Birth preparedness"
            ],
            [
              "name"=> "Elimination of Mother to Child Transmission (eMTCT) of HIV/AIDs and Syphilis (EMTCT/PMTCT)"
            ],
            [
              "name"=> "Intrapartum care (labor and delivery)"
            ],
            [
              "name"=> "Maternal Vaccination / Immunization"
            ],
            [
              "name"=> "Other maternal health"
            ],
            [
              "name"=> "Postpartum care"
            ],
            [
              "name"=> "Pregnancy/antenatal care"
            ],
            [
              "name"=> "Chagas"
            ],
            [
              "name"=> "Dengue"
            ],
            [
              "name"=> "Dracunculiasis (guinea-worm disease)"
            ],
            [
              "name"=> "Echinococcosis"
            ],
            [
              "name"=> "Foodborne trematodiases"
            ],
            [
              "name"=> "Human African trypanosomiasis (sleeping sickness)"
            ],
            [
              "name"=> "Leishmaniases"
            ],
            [
              "name"=> "Leprosy"
            ],
            [
              "name"=> "Lymphatic filariasis"
            ],
            [
              "name"=> "Mycetoma"
            ],
            [
              "name"=> "Onchocerciasis (river blindness)"
            ],
            [
              "name"=> "Other neglected tropical diseases"
            ],
            [
              "name"=> "Rabies"
            ],
            [
              "name"=> "Residual spraying"
            ],
            [
              "name"=> "Schistosomiasis (bilharziasis)"
            ],
            [
              "name"=> "Soil-transmitted helminthiasis (e.g. whipworm, hookworms, roundworms)"
            ],
            [
              "name"=> "Trachoma"
            ],
            [
              "name"=> "Breastfeeding"
            ],
            [
              "name"=> "Child abuse"
            ],
            [
              "name"=> "Child growth and development"
            ],
            [
              "name"=> "Childhood vaccinations / immunization"
            ],
            [
              "name"=> "Infant/child nutrition and micronutrient deficiency"
            ],
            [
              "name"=> "Integrated Management of Newborn and Childhood Infections (IMNCI)"
            ],
            [
              "name"=> "Malformations/birth defects"
            ],
            [
              "name"=> "Other newborn and child health"
            ],
            [
              "name"=> "Postnatal/newborn care"
            ],
            [
              "name"=> "Alcohol use"
            ],
            [
              "name"=> "Cancer"
            ],
            [
              "name"=> "Cardiovascular disease"
            ],
            [
              "name"=> "Diabetes"
            ],
            [
              "name"=> "Hypertension"
            ],
            [
              "name"=> "Oral health"
            ],
            [
              "name"=> "Other non-communicable diseases"
            ],
            [
              "name"=> "Substance abuse"
            ],
            [
              "name"=> "Tobacco use"
            ],
            [
              "name"=> "Diet"
            ],
            [
              "name"=> "Malnutrition"
            ],
            [
              "name"=> "Metabolic and endocrine disorders"
            ],
            [
              "name"=> "Micronutrient deficiency"
            ],
            [
              "name"=> "Obesity"
            ],
            [
              "name"=> "Other nutrition and metabolic disorders"
            ],
            [
              "name"=> "Diseases of the digestive system"
            ],
            [
              "name"=> "Diseases of the ear and hearing loss"
            ],
            [
              "name"=> "Diseases of the eye and vision loss (e.g. cataracts, vision loss)"
            ],
            [
              "name"=> "Diseases of the kidney and the urinary system"
            ],
            [
              "name"=> "Diseases of the musculoskeletal system and connective tissue"
            ],
            [
              "name"=> "Diseases of the nervous system (e.g. epilepsy, cerebral palsy)"
            ],
            [
              "name"=> "Diseases of the respiratory system (e.g. asthma, COPD)"
            ],
            [
              "name"=> "Diseases of the skin and subcutaneous tissue (e.g. dermatitis, hair loss)"
            ],
            [
              "name"=> "Learning and Developmental Disabilities"
            ],
            [
              "name"=> "Other chronic conditions and disabilities"
            ],
            [
              "name"=> "Sexual and reproductive health"
            ],
            [
              "name"=> "Comprehensive sexuality education"
            ],
            [
              "name"=> "Contraception/family planning"
            ],
            [
              "name"=> "Female genital mutilation"
            ],
            [
              "name"=> "HIV/AIDS"
            ],
            [
              "name"=> "Human papillomavirus (HPV) and cervical cancer"
            ],
            [
              "name"=> "Infertility"
            ],
            [
              "name"=> "Other sexual and reproductive health"
            ],
            [
              "name"=> "Safe abortion care"
            ],
            [
              "name"=> "Sexually Transmitted Infections (STIs)"
            ],
            [
              "name"=> "Vector-borne diseases (not listed under Neglected Tropical Diseases (NTDs)"
            ],
            [
              "name"=> "Chikungunya"
            ],
            [
              "name"=> "Japanese encephalitis"
            ],
            [
              "name"=> "Malaria"
            ],
            [
              "name"=> "Other vector borne"
            ],
            [
              "name"=> "Rickettsiosis"
            ],
            [
              "name"=> "Rift Valley fever"
            ],
            [
              "name"=> "Sandfly fever (phlebotomus fever)"
            ],
            [
              "name"=> "West Nile fever"
            ],
            [
              "name"=> "Yellow fever"
            ],
            [
              "name"=> "Zika"
            ],
            [
              "name"=> "Violence"
            ],
            [
              "name"=> "Emotional violence"
            ],
            [
              "name"=> "Other violence"
            ],
            [
              "name"=> "Physical violence"
            ],
            [
              "name"=> "Sexual violence"
            ],
            [
              "name"=> "Water Sanitation and Hygiene (WASH)"
            ],
            [
              "name"=> "Handwashing"
            ],
            [
              "name"=> "Hygiene education"
            ],
            [
              "name"=> "Management of diarrheal diseases"
            ],
            [
              "name"=> "Other WASH"
            ],
            [
              "name"=> "Water treatment"
            ],
            [
              "name"=> "Wellness and Mental Health"
            ],
            [
              "name"=> "Ageing"
            ],
            [
              "name"=> "Mental health"
            ],
            [
              "name"=> "Other wellness and mental health"
            ],
            [
              "name"=> "Physical Activity"
            ]
        ];

        HealthFocusArea::insert($health_focus_areas);
    }
}
