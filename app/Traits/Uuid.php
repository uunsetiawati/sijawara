<?php

namespace App\Traits;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uuid = Generator::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public static function findByUuid($uuid, ...$with)
    {
        if(count($with) >= 1) {
            return static::with($with)->where('uuid', '=', $uuid)->first();
        }
        return static::where('uuid', '=', $uuid)->first();
    }
}