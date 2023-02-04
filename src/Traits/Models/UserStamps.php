<?php
namespace Crghome\Shop\Traits\Models;
use Illuminate\Support\Facades\Auth;

trait UserStamps
{
    public static function bootUserStamps(){
        // parent::boot();
        // first we tell the model what to do on a creating event
        static::creating(function($modelName=''){
            $createdByColumnName = 'created_user_id';
            $modelName->$createdByColumnName = Auth::id();
        });

        // // then we tell the model what to do on an updating event
        static::updating(function($modelName=''){
            $updatedByColumnName = 'updated_user_id';
            $modelName->$updatedByColumnName = Auth::id();
        });    
    }
}