<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DigitalHealthProjectFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'is_registered' => $this->is_registered,
            'budget' => $this->budget,
            'objective' => $this->objective,
            'legal_document' => !empty($this->legal_document) ? asset('storage/legal_doc/'.$this->legal_document) : null,
            'summary' => $this->summary,
            'organization' => $this->organization_unit,
            'golive_date' => $this->golive_date,
            'license' => $this->license,
            'documentation_link' => $this->code_documentation,
            'documentation_link' => $this->documentation_link,
            'wiki_page' => $this->wiki_page_link,
            'git_link' => $this->git_link,
            'applications' => $this->applications,
            'operating_systems' => $this->operating_systems,
            'tech_stacks' => $this->tech_stacks,
            'languages' => $this->languages,
            'frameworks' => $this->frameworks,
            'databases' => $this->databases,
            'standards' => $this->standards,
            'components' => $this->components,
            'application_types' => $this->application_types,
            'has_api_support' => $this->has_api_support,
            'is_api_published' => $this->is_api_published,
            'data_is_sent_to_moh' => $this->data_is_sent_to_moh,
            'focus_areas' => $this->focus_areas,
            'challenges' => $this->challenges,
            'partners' => $this->partners,
            'implementing_partners' => $this->implementing_partners,
            'moh_contribution' => $this->moh_contribution,
            'project_website_link' => $this->project_website_link,
            'business_model' => $this->business_model,
            'funding_sources' => $this->funding_sources,
            'keywords' => $this->keywords,
            'category_of_evidence' => $this->category_of_evidence,
            'publications' => $this->publications,
            'key_challenges_recommendations' => $this->key_challenges_recommendations,
            'ownership_type' => $this->ownership_type,
            'owner' => $this->government_office,
            'current_status' => $this->current_status,
            'current_version' => $this->current_version,
            'deployment_locations' => $this->deployment_locations,
            'geographic_scopes' => $this->geographic_scope,
            'coverages' => CoverageResource::collection($this->coverages),
            'activities' => $this->softwares,
            'resources' => DigitalHealthProjectResourcesResource::collection($this->resources),
            'logo' => !empty($this->logo) ? asset('storage/logo/'.$this->logo) : null,
            'bandwidth' => $this->bandwidth,
            'supports' => $this->maintenance_support_provider,
            'implement_locations' => $this->implement_locations,
            'data_collected_locations' => $this->data_collected_locations,
            'targeted_users' => $this->targeted_users,
            'has_impact_evaluation' => $this->has_impact_evaluation,
            'impact_evaluation' => !empty($this->impact_evaluation) ? asset('storage/impact_evaluation/'.$this->impact_evaluation) : null,
            'retire' => $this->retire,
            'status' => $this->status,
            'status_before_archival' => $this->status_before_archival,
            'published_date' => $this->published_date,
            'user_id' => $this->user_id,
            'decline_messages' => $this->decline_messages,
            'facility_types' => $this->facility_types,
            'certificates' => $this->certificates,
            'other_typeof_applications' => $this->other_typeof_applications,
            'other_operating_systems' => $this->other_operating_systems,
            'other_databases' => $this->other_databases,
            'other_frameworks' => $this->other_frameworks,
            'third_party_tools' => $this->third_party_tools,
            'is_openapi' => $this->is_openapi,
            'api_documentation_link' => $this->api_documentation_link,
            'dhs_implemeted' => $this->dhs_implemeted,
            'national_scopes' => $this->national_scopes,
            'fhir_compliant'=>$this->fhir_compliant,
            'osi_licenses'=>$this->osi_licenses,
            'views' => $this->views
        ];
    }
}
