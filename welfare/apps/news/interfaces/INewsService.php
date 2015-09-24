<?php
namespace apps\news\interfaces;
/**
 * @name news
 * @uri /manage
 * @description จัดการกลุ่มสมาชิก
 */
interface INewsService {

      /**
     * @name save
     * @uri /save
     * @param apps\news\entity\News news []
     * @return boolean save [return ture or false if don't ]
     * @description เพิ่มข่าว
     */
    public function save($news);
}
