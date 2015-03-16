<?php namespace Benhawker\Pipedrive\Library;

use Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError;

/**
 * Pipedrive Stages Methods
 *
 * Stage is a logical component of a Pipeline, and essentially a bucket that can hold a number of Deals.
 * In the context of the Pipeline a stage belongs to, it has an order number which defines the order of
 * stages in that Pipeline.
 *
 */
class Stages
{
    /**
     * Hold the pipedrive cURL session
     * @var \Benhawker\Pipedrive\Library\Curl Curl Object
     */
    protected $curl;

    /**
     * Initialise the object load master class
     */
    public function __construct(\Benhawker\Pipedrive\Pipedrive $master)
    {
        //associate curl class
        $this->curl = $master->curl();
    }

    /**
     * Returns all Stages
     *
     * @return array returns details of all stages
     */
    public function getAll($limit)
    {
        return $this->curl->get('stages', array('limit' => $limit));
    }

    /**
     * Returns a Stage
     *
     * @param  int   $id pipedrive stage id
     * @return array returns detials of a stage
     */
    public function getById($id)
    {
        return $this->curl->get('stages/' . $id);
    }
}
