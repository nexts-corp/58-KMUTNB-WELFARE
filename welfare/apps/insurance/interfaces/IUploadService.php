<?php

namespace apps\insurance\interfaces;

/**
 * @name upload
 * @uri /upload
 * @description อัพโหลดเอกสาร
 */
interface IUploadService {

    
    /**
     * @name sso
     * @uri /sso
     * @param file file
     * @return string sso
     * @description อัพโหลดไฟล์ csv
     */
    public function sso($file);

    
    
}
