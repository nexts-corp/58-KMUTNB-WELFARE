<?php

namespace apps\basics\interfaces;

/**
 * @name IAcademicService
 * @uri /academic
 * @description จัดการ เพิ่ม/ลบ/แก้ไข ตำแหน่งทางวิชาการบุคคลากร
 */
interface IAcademicService {

    /**
     * @name save
     * @uri /save
     * @param apps\common\entity\AcademicsType data []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มตำแหน่งทางวิชาการของบุคคลากร 
     */
    public function save($data);

    /**
     * @name update
     * @uri /update
     * @param apps\common\entity\AcademicsType data Description
     * @return boolean update Description
     * @description แก้ไขตำแหน่งทางวิชาการของบุคคลากร  
     */
    public function update($data);
     
    /**
     * @name delete
     * @uri /delete
     * @param String id Description
     * @return string deleteAcademic Description
     * @description ลบตำแหน่งทางวิชาการของบุคคลากร 
     */
    public function delete($id);
    
}
