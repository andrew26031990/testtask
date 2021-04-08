<?php

namespace App\Repositories;

use App\Models\Authors;
use App\Repositories\BaseRepository;

/**
 * Class AuthorsRepository
 * @package App\Repositories
 * @version April 8, 2021, 7:24 am UTC
*/

class AuthorsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Authors::class;
    }
}
