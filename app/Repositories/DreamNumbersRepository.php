<?php
/**
 * Created by PhpStorm.
 * User: anhnguyen
 * Date: 6/12/18
 * Time: 9:10 AM
 */

namespace App\Repositories;

use App\Models\DreamNumber;

class DreamNumbersRepository
{
    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Create a new instance.
     *
     * @param  \App\Models\DreamNumber $dreamNumber
     */
    public function __construct(DreamNumber $dreamNumber)
    {
        $this->model = $dreamNumber;
    }


    /**
     * Create a query for dream numbers.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryActiveOrderByDate()
    {
        return $this->model
            ->select('*')
            ->whereStatus(true)
            ->latest();
    }

    /**
     * Get active posts collection paginated.
     *
     * @param  int $nbrPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDate($nbrPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbrPages);
    }

    /**
     * Get all posts collection paginated.
     *
     * @param  int $nbrPages
     * @param  array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($nbrPages, $parameters)
    {
        return $this->model->orderBy($parameters['order'], $parameters['direction'])
            ->when($parameters['status'], function ($query) {
                $query->whereStatus(true);
            })->paginate($nbrPages);
    }

    /**
     * Get dream numbers with search.
     *
     * @param  int $n
     * @param  string $search
     * @param  string $type
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($n, $search, $type = 'all')
    {
        if ($type == 'all') {
            return $this->queryActiveOrderByDate()
                ->where(function ($q) use ($search) {
                    $q->where('dream_content', 'like', "%$search%")
                        ->orWhere('result_dream', 'like', "%$search%");
                })->paginate($n);
        } else {
            return $this->queryActiveOrderByDate()
                ->where(function ($q) use ($search, $type) {
                    $q->where($type, 'like', "%$search%");
                })->paginate($n);
        }
    }
}