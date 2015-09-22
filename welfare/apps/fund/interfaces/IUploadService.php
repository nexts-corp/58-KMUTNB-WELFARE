<?php

namespace apps\fund\interfaces;

/**
 * @name upload
 * @uri /upload
 * @description อัพโหลดเอกสาร
 */
interface IUploadService {

    
    /**
     * @name employee
     * @uri /employee
     * @param file file
     * @return string upload
     * @description อัพโหลดไฟล์ csv
     */
    public function employee($file);
    
    /**
     * @name extra
     * @uri /extra
     * @param file file
     * @return string upload
     * @description อัพโหลดไฟล์ csv
     */
    public function extra($file);

    
    
}
