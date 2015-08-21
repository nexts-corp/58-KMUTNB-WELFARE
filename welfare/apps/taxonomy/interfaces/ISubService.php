<?php

namespace apps\taxonomy\interfaces;

/**
 * @name sub
 * @uri /sub
 * @description ไรวะเนี่ย
 */
interface ISubService {

    /**
     * @name save
     * @uri /save
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean save
     * @description save data to database
     */
    public function save($taxonomy);
    
     /**
     * @name update
     * @uri /update
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean update
     * @description update data to database
     */
    public function update($taxonomy);
    
     /**
     * @name delete
     * @uri /delete
     * @param apps\taxonomy\entity\Taxonomy taxonomy
     * @return boolean delete
     * @description delete data to database
     */
    public function delete($taxonomy);
}
