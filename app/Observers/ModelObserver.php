<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * The model that watched the database tables for changes, and logs appropriately
 *
 * @TODO: Change the user in ->causedBy() to reflect the auth user
 */
class ModelObserver {
    public function creating(Model $model): Model {
        if (!isset($model->created_by)) {
            $model->setAttribute('created_by', 1);
        }

        return $model;
    }

    public function created(Model $model): void {

        activity('db-operations')
            ->performedOn($model)
            ->causedBy(User::find(1))
            ->log('created');
    }

    public function updating(Model $model): Model {
        $model->setAttribute('updated_by', 1);
        return $model;
    }

    public function updated(Model $model): void {
        activity('db-operations')
            ->performedOn($model)
            ->causedBy(User::find(1))
            ->withProperty('old', $model->getOriginal())
            ->log('updated');
    }

    public function deleted(Model $model): void {

        $model->setAttribute('deleted_by', 1);
        $model->save();

        activity('db-operations')
            ->performedOn($model)
            ->causedBy(User::find(1))
            ->log('deleted');
    }
}
