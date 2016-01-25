<?php namespace Benhawker\Pipedrive\Library;

use Benhawker\Pipedrive\Exceptions\PipedriveMissingFieldError;

/**
 * Pipedrive Deals Methods
 *
 * Deals represent ongoing, lost or won sales to an Organization or to a Person.
 * Each deal has a monetary value and must be placed in a Stage. Deals can be
 * owned by a User, and followed by one or many Users. Each Deal consists of
 * standard data fields but can also contain a number of custom fields. The
 * custom fields can be recognized by long hashes as keys. These hashes can be
 * mapped against DealField.key. The corresponding label for each such custom
 * field can be obtained from DealField.name.
 *
 */
class Deals
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
     * Delete a Deal
     *
     * @param  int   $id pipedrive deal id
     * @return array
     */
    public function delete($id)
    {
        return $this->curl->delete('deals/'. $id);
    }

    /**
     * Returns all Deals
     *
     * @return array returns details of all deals
     */
    public function getAll($limit, $start = 0)
    {
        return $this->curl->get('deals', array('limit' => $limit, 'start' => $start));
    }

    /**
     * Returns a deal
     *
     * @param  int   $id pipedrive deals id
     * @return array returns details of a deal
     */
    public function getById($id)
    {
        return $this->curl->get('deals/' . $id);
    }

    /**
     * Returns a deal / deals
     *
     * @param  string $name pipedrive deals title
     * @return array  returns details of a deal
     */
    public function getByName($name, $personId=null, $orgId=null)
    {
        $params = array('term' => $name);
        if($personId) {
            $params['person_id'] = $personId;
        }
        if($orgId) {
            $params['org_id'] = $orgId;
        }
        return $this->curl->get('deals/find', $params);
    }

    /**
     * Adds a deal
     *
     * @param  array $data deal details
     * @return array returns details of the deal
     */
    public function add(array $data)
    {
        //if there is no title set throw error as it is a required field
        if (!isset($data['title'])) {
            throw new PipedriveMissingFieldError('You must include a "title" feild when inserting a deal');
        }

        return $this->curl->post('deals', $data);
    }

    /**
     * Updates a deal
     *
     * @param  int   $dealId pipedrive deal Id
     * @param  array $data   new details of deal
     * @return array returns details of a deal
     */
    public function update($dealId, array $data = array())
    {
        return $this->curl->put('deals/' . $dealId, $data);
    }

    /**
     * Moves deal to a new stage
     *
     * @param  int   $dealId  deal id
     * @param  int   $stageId stage id
     * @return array returns details of the deal
     */
    public function moveStage($dealId, $stageId)
    {
        return $this->curl->put('deals/' . $dealId, array('stage_id' => $stageId));
    }

    /**
     * Get activities associated with a deal
     *
     * @param  int   $dealId  deal id
     * @return array return a list
     */
    public function getActivities($dealId)
    {
        return $this->curl->get('deals/' . $dealId .'/activities');
    }

}
