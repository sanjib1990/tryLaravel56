<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 14/01/18
 * Time: 11:14 AM
 */

namespace App\Contracts;

interface RESTContract
{
    /**
     * List Resource.
     *
     * @param array $data
     * @param bool  $paginate
     *
     * @return mixed
     */
    public function list(array $data = [], bool $paginate = false);

    /**
     * Get a specific resource.
     *
     * @param $identifier
     *
     * @return mixed
     */
    public function getById($identifier);

    /**
     * Find a resource with specific params.
     *
     * @param array $wheres
     *
     * @return mixed
     */
    public function find(array $wheres);

    /**
     * Create/Update Resource.
     *
     * @param array $data
     * @param       $identifier
     *
     * @return mixed
     */
    public function store(array $data, $identifier);

    /**
     * Delete a resource.
     *
     * @param $identifier
     *
     * @return mixed
     */
    public function remove($identifier);
}
