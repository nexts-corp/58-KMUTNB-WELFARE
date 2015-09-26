<?php

namespace apps\common\interfaces;

/**
 * @name common
 * @uri /common
 * @description ไรวะเนี่ย
 */
interface ICommonService {

    /**
     * @name date2str
     * @uri /date2str
     * @param datetime date
     * @param string format
     * @param string operation
     * @return string date
     * @description save data to database
     */
    public function date2str($date,$format,$operation);

}
