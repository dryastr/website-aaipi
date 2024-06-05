<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait ModelBootObserver
{
    public static function bootModelBootObserver()
    {
        static::creating(function (Model $model) {
            $columns = Schema::connection($model->getConnectionName())->getColumnListing($model->getTable());
            $auth = auth()->user();
            if ($auth) {
                if (in_array('created_by', $columns)) {
                    $model->created_by = $auth->id;
                }

                if (in_array('created_by_name', $columns)) {
                    $model->created_by_name = $auth->fullname;
                }

                if (in_array('updated_by', $columns)) {
                    $model->updated_by = $auth->id;
                }

                if (in_array('updated_by_name', $columns)) {
                    $model->updated_by_name = $auth->fullname;
                }
            }
        });

        static::updating(function (Model $model) {
            $columns = Schema::connection($model->getConnectionName())->getColumnListing($model->getTable());
            $auth = auth()->user();
            if ($auth) {
                if (in_array('updated_by', $columns)) {
                    $model->updated_by = $auth->id;
                }

                if (in_array('updated_by_name', $columns)) {
                    $model->updated_by_name = $auth->fullname;
                }
            }
        });

        static::deleting(function (Model $model) {
            $columns = Schema::connection($model->getConnectionName())->getColumnListing($model->getTable());
            $auth = auth()->user();
            if ($auth) {
                if (in_array('deleted_by', $columns)) {
                    $model->deleted_by = $auth->user_id;
                }

                if (in_array('deleted_by_name', $columns)) {
                    $model->deleted_by_name = $auth->fullname;
                }
            }
        });
    }
}
