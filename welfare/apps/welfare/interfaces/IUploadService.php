<?php

namespace apps\welfare\interfaces;

/**
 * @name upload
 * @uri /upload
 * @description อัพโหลดเอกสาร
 */
interface IUploadService {

    
    /**
     * @name welfare
     * @uri /welfare
     * @param file file
     * @return string upload
     * @description อัพโหลดไฟล์ csv
     */
    public function welfare($file);

    
    
}
