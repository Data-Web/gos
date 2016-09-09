<?php

namespace App\Jobs\Role;

use App\Jobs\Job;
use Illuminate\Database\Eloquent\Model;

class UpdateRole extends Job
{
    protected $attributes;

    protected $entity;

    public function __construct(Model $entity, array $attributes)
    {
        $this->attributes = $attributes;
        $this->entity = $entity;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->entity->update($this->attributes);

        if (isset($this->attributes['permissions_checked']) && count($this->attributes['permissions_checked'])) {
            $this->entity->permissions()->sync($this->attributes['permissions_checked']);
        }
    }
}