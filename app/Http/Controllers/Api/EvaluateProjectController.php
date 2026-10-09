<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\EvaluationMetricsCategory;
use App\Models\EvaluationMetrics;
use App\Models\DigitalHealthProject;
use App\Models\ActivityLog;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class EvaluateProjectController extends Controller
{
    const NEW_PROJECT = "new";
    const APPROVED_REGISTRATION = "registration approved";
    const REJECTED_REGISTRATION = "registration rejected";
    const APPROVER_REJECTED = "cert competence rejected";
    const REQUEST_APPROVAL = "request cert competence";
    const CERT_COMPETENCE = "cert competence";

    //
    public function index(Request $request){
        $searchParams = $request->all();
        $project_id = Arr::get($searchParams, 'project_id', '');

        $evaluations = EvaluationMetricsCategory::with(['evaluation_metrics' => function ($query) use ($project_id){
            $query->with(['projects' => function ($project) use ($project_id){
                $project->where('digital_health_project_id', $project_id);
            }]);
        }])->get();
        
        return response()->json($evaluations, Response::HTTP_OK);
    }

    public function approve_registration(DigitalHealthProject $project){
        $project->is_registered = true;

        if($project->dhs_implemeted == 'Public'){
            $project->status = static::REQUEST_APPROVAL;
        }else{
            $project->status = static::APPROVED_REGISTRATION;
        }
        
        $project->save();

        ActivityLog::create([
            'type' => 'REG APR',
            'remarks' => sprintf('%s(%d) is approved for registration.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return response()->json($project, Response::HTTP_OK);
    }

    public function cert_competence(DigitalHealthProject $project, Request $request){
        $params = $request->all();

        foreach($params as $evaluation){
            foreach($evaluation['evaluation_metrics'] as $metrics){
                $project->evaluations()->detach(EvaluationMetrics::find($metrics['id']));
                $project->evaluations()->attach(EvaluationMetrics::find($metrics['id']), array(
                    'score' => $metrics["score"],
                ));
            }
        }

        $project->certificates()->create([
            'type'=> 'COMPETENCE',
            'certify_date'=> date('Y-m-d'),
            'user_id'=> Auth::user()->id
        ]);

        $project->status = static::CERT_COMPETENCE;
        $project->published_date = date("Y-m-d");

        $project->save();

        ActivityLog::create([
            'type' => 'COMP CERT',
            'remarks' => sprintf('%s(%d) is certified for competence.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return response()->json($project->certificates, Response::HTTP_OK);
    }

    public function decline_messages(DigitalHealthProject $project){
        $messages = $project->decline_messages()->orderBy('updated_at', 'desc')->get();
        return response()->json($messages, Response::HTTP_OK);
    }

    public function decline_registration(DigitalHealthProject $project, Request $request){
        $params = $request->all();

        $messages = $project->decline_messages()->attach(Auth::user(), [
            'type' => 'REG APR',
            'message'=> $params['message']
        ]);
        $project->is_registered = false;

        $project->status = static::REJECTED_REGISTRATION;
        $project->save();

        ActivityLog::create([
            'type' => 'Reg Decline',
            'remarks' => sprintf('REG for %s(%d) declined.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return $this->decline_messages($project);
    }

    public function decline_cert_comp(DigitalHealthProject $project, Request $request){
        $params = $request->all();

        $messages = $project->decline_messages()->attach(Auth::user(), [
            'type' => 'COMP CERT',
            'message' => $params['message']
        ]);

        $project->status = static::APPROVER_REJECTED;
        $project->published_date = null;
        $project->save();

        ActivityLog::create([
            'type' => 'CERT Decline',
            'remarks' => sprintf('COMP CERT for %s(%d) declined.',$project->name, $project->id),
            'model' => 'DigitalHealthProject',
            'user' => sprintf('%s(%d)', Auth::user()->name, Auth::user()->id)
        ]);

        return $this->decline_messages($project);
    }
}
