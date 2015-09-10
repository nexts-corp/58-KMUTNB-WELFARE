<?php

namespace apps\retire\interfaces;

/**
 * @name retire
 * @uri /retire
 * @description จัดการข้อมูลผู้เกษียนอายุราชการ
 */
interface IRetireService {

    /**
     * @name preview
     * @uri /preview
     * @param string retireYear
     * @return string preview
     * @description test
     */
    public function preview($retireYear);
}
