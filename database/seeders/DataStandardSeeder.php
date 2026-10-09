<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DataStandard;

class DataStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data_standards = [
            [
              "name"=> "Extension and advisory services",
              "description"=> "The Aggregate Data Exchange (ADX) Profile supports interoperable public health reporting of aggregate health data.",
              "category"=> "Health Data Exchange Standards"
            ],

            [
              "name"=> "Financial services",
              "description"=> "Clinical Document Architecture (CDA) is a set of standards that describe the structure and semantics of clinical data in XML (Extensible Markup Language) for easy exchange.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "Pricing and marketing",
              "description"=> "The Care Services Discovery (CSD) registry contains information about health organizations, facilities, services and providers",
              "category"=> "Health Data Exchange Standards"
            ],

            [
              "name"=> "Deliver timely interventions",
              "description"=> "The Fast Healthcare Interoperability Resources (FHIR) standard is a set of rules and specifications for exchanging electronic health care data.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "Track and trace inputs",
              "description"=> "The Care Services Discovery (CSD) registry contains information about health organizations, facilities, services and providers",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "HL7 v2",
              "description"=> "Health Level Seven Version 2 (HL7 v2) is a widely implemented messaging standard that allows the exchange of clinical data between systems.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "HL7 v3",
              "description"=> "Health Level Seven Version 3 (HL7 v3) is an XML-based document markup standard that specifies the structure and logic of 'clinical documents' for the purpose of exchange between healthcare providers and patients.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "MHD - Mobile Access to Health Documents",
              "description"=> "The Mobile access to Health Documents (MHD) Profile defines one standardized interface to health document sharing for use by mobile devices.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "PDQ or PDQm - (Mobile) Patient Demographics Query",
              "description"=> "Patient Demographics Query (PDQ) provides a query to a central patient information server and retrieve a patient’s demographic and visit information. In Patient Demographics Matching, the Patient Demographics Supplier provides a service to the Patient Demographics Consumer in finding a 'best fit' list of possible patient identities that match the demographics information contained in the query parameters.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "SVS - Sharing Value Sets",
              "description"=> "Sharing Value Sets (SVS) provides a means through which healthcare systems producing clinical or administrative data, can receive a common, uniform nomenclature managed centrally.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "XDS - Cross-Enterprise Document Sharing",
              "description"=> "Cross Enterprise Document Sharing (XDS) is a system of standards for cataloguing and sharing patient records across health institutions.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "XUA - Cross-Enterprise User Assertion",
              "description"=> "The Cross-Enterprise User Assertion Profile (XUA) provides a means to communicate across cross applications by authenticating users, applications or systems.",
              "category"=> "Health Data Exchange Standards"
            ],
            [
              "name"=> "CIEL",
              "description"=> "Concepts for Integrated Epidemiology and Linkage (CIEL) is a health data standardization initiative that focuses on creating and maintaining standardized codes and concepts for health-related data.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "CPT",
              "description"=> "Current Procedural Terminology (CPT) serves as a standardized system for reporting medical procedures and services provided by healthcare professionals.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "ICD-10",
              "description"=> "International Classification of Diseases, 10th Revision (ICD10) is international standard for coding and classification of diseases and health conditions.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "ICD-11",
              "description"=> "International Classification of Diseases, 11th Revision (ICD11) is international standard for coding and classification of diseases and health conditions.",
              "category"=> "Health Data Standardization"
            ],

            [
              "name"=> "LOINC",
              "description"=> "Logical Observation Identifiers Names and Codes (LOINC) is a health data standard that focuses on the identification and exchange of clinical laboratory and other medical observations.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "RxNORM",
              "description"=> "Prescription Norms (RxNorm) is a standardized terminology for medications which provides a structured system for representing and exchanging drug-related information, including medication names, ingredients, strengths, dosages, and other related concepts.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "SNOMED",
              "description"=> "Systematized Nomenclature of Medicine (SNOMED) is a comprehensive and internationally recognized health data standard used for clinical terminology and coding in healthcare systems.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "UCUM",
              "description"=> "UCUM (Unified Code for Units of Measure) is a health data standard that provides a unified and standardized approach for representing and exchanging units of measure in healthcare.",
              "category"=> "Health Data Standardization"
            ],
            [
              "name"=> "ISCO 08",
              "description"=> "International Standard Classification of Occupations, 8th edition (ISCO-8) is a classification system to categorize and standardize occupational information.",
              "category"=> "Demographic Data Standardization"
            ],
            [
              "name"=> "ISCO 88",
              "description"=> "International Standard Classification of Occupations, 1988 edition (ISCO-88) is an older classification system to categorize and standardize occupational information.",
              "category"=> "Demographic Data Standardization"
            ],
            [
              "name"=> "ISO 3166",
              "description"=> "International Organization for Standardization-3166 (ISO-3166) is a standard that defines codes for identifying countries and their subdivisions.",
              "category"=> "Demographic Data Standardization"
            ],
            [
              "name"=> "ANTA - Audit Trail and Node Authentication",
              "description"=> "The Audit Trail and Node Authentication (ATNA) Integration Profile establishes security measures which, together with the Security Policy and Procedures, provide patient information confidentiality, data integrity and user accountability.",
              "category"=> "Security & Privacy Standards"
            ],
            [
              "name"=> "BPPC - Basic Patient Privacy Consents",
              "description"=> "Basic Patient Privacy Consents (BPPC) provides a mechanism to record the patient privacy consent(s) and a method for Content Consumers to use to enforce the privacy consent appropriate to the use.",
              "category"=> "Security & Privacy Standards"
            ],
            [
              "name"=> "PII",
              "description"=> "PII (Personally Identifiable Information) standards dictate how the PII like person’s name, address, social security number, biometric records, etc. must be treated.",
              "category"=> "Security & Privacy Standards"
            ],

            [
              "name"=> "PIX or PIXm - (Mobile) Patient Identifier Cross Reference",
              "description"=> "(mobile) Patient Identifier Cross-referencing (PIX) supports the cross-referencing of patient identifiers from multiple Patient Identifier Domains.",
              "category"=> "Security & Privacy Standards"
            ],
            [
              "name"=> "GML Geography Markup Language",
              "description"=> "Geography Markup Language (GML) is an XML-based standard for encoding and exchange of geographic data.",
              "category"=> "Technical Standards"
            ],
            [
              "name"=> "GS1",
              "description"=> "Global System of Standards (GS1) enable the accurate and consistent identification, capture, and sharing of information about products, locations, assets, and other entities.",
              "category"=> "Technical Standards"
            ],
            [
              "name"=> "JSON",
              "description"=> "JSON (JavaScript Object Notation, is an open standard file format and data interchange format that uses human-readable text to store and transmit data objects consisting of attribute-value pairs and arrays (or other serializable values).",
              "category"=> "Technical Standards"
            ],
            [
              "name"=> "mACM - Mobile Alert Communication Management",
              "description"=> "Mobile Alert Communication Management (mACM) provides the infrastructural components needed to send short, unstructured text alerts to human recipients and can record the outcomes of any human interactions upon receipt of the alert.",
              "category"=> "Technical Standards"
            ],
            [
              "name"=> "SDMX - Statistical Data and Metadata Exchange",
              "description"=> "Statistical Data and Metadata Exchange (SDMX) is a standard for exchanging statistical data and metadata.",
              "category"=> "Technical Standards"
            ],
            [
              "name"=> "XForms",
              "description"=> "XHTML Forms(xForms) is a markup language standard for creating web forms with advanced features and functionality",
              "category"=> "Technical Standards"
            ],
        ];

        DataStandard::insert($data_standards);
    }
}
