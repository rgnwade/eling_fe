<?php

namespace Modules\Core\Http\Traits;
use Modules\Core\Entities\Log;
use Auth;

trait LogTrait
{

   public function createlog($model, $action, $request)
    {
        $function = new \ReflectionClass($model);
        $log = new Log;
        $log->action = $action;
        $log->entity_id =  $model->id;
        $log->entity_name =  $function->getShortName();
        $log->user_id = Auth::user()->id;
        $log->ip = $request->ip();
        $log->save();
    }

    public function createDestroyLog($model, $action, $request, $ids)
    {
        $function = new \ReflectionClass($model);
        $log = new Log;
        $log->action = $action;
        $log->entity_id =  $ids;
        $log->entity_name =  $function->getShortName();
        $log->user_id = Auth::user()->id;
        $log->ip = $request->ip();
        $log->save();
    }

     public function createDefaultLog($model_id, $model_name, $action, $request)
    {
        $log = new Log;
        $log->action = $action;
        $log->entity_id =  $model_name;
        $log->entity_name = $model_id;
        $log->user_id = Auth::user()->id;
        $log->ip = $request->ip();
        $log->save();
    }


}
