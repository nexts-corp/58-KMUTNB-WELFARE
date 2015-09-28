<?php

namespace apps\common\service;

use th\co\bpg\cde\core\CServiceBase;
use th\co\bpg\cde\data\CDataContext;
use apps\common\interfaces\ICommonService;

class CommonService extends CServiceBase implements ICommonService {

    public $datacontext;

    function __construct() {
        $this->datacontext = new CDataContext();
    }

    public function str2date($date, $format, $operation = "") {
        if ($format == "Y-m-d") {
            $date = explode("-", $date);
            if ($operation == "+") {
                $date[0] = (int) $date[0] + 543;
            } elseif ($operation == "-") {
                $date[0] = (int) $date[0] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2];
        } elseif ($format == "d-m-Y") {
            $date = explode("-", $date);
            if ($operation == "+") {
                $date[2] = (int) $date[2] + 543;
            } elseif ($operation == "-") {
                $date[2] = (int) $date[2] - 543;
            }
            $date = $date[2] . "-" . $date[1] . "-" . $date[0];
        } elseif ($format == "Y-m-d H:i:s") {
            $datetime = explode(" ", $date);
            $date = explode("-", $datetime[0]);
            if ($operation == "+") {
                $date[0] = (int) $date[0] + 543;
            } elseif ($operation == "-") {
                $date[0] = (int) $date[0] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2] . " " . $datetime[1];
        } elseif ($format == "d-m-Y H:i:s") {
            $datetime = explode(" ", $date);
            $date = explode("-", $datetime[0]);
            if ($operation == "+") {
                $date[2] = (int) $date[2] + 543;
            } elseif ($operation == "-") {
                $date[2] = (int) $date[2] - 543;
            }
            $date = $date[2] . "-" . $date[1] . "-" . $date[0] . " " . $datetime[1];
        }
        return new \DateTime($date);
    }

    public function date2str($date, $format, $operation = "") {
        $date = $date->format($format);
        if ($format == "Y-m-d") {
            $date = explode("-", $date);
            if ($operation == "+") {
                $date[0] = (int) $date[0] + 543;
            } elseif ($operation == "-") {
                $date[0] = (int) $date[0] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2];
        } elseif ($format == "d-m-Y") {
            $date = explode("-", $date);
            if ($operation == "+") {
                $date[2] = (int) $date[2] + 543;
            } elseif ($operation == "-") {
                $date[2] = (int) $date[2] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2];
        } elseif ($format == "Y-m-d H:i:s") {
            $datetime = explode(" ", $date);
            $date = explode("-", $datetime[0]);
            if ($operation == "+") {
                $date[0] = (int) $date[0] + 543;
            } elseif ($operation == "-") {
                $date[0] = (int) $date[0] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2] . " " . $datetime[1];
        } elseif ($format == "d-m-Y H:i:s") {
            $datetime = explode(" ", $date);
            $date = explode("-", $datetime[0]);
            if ($operation == "+") {
                $date[2] = (int) $date[2] + 543;
            } elseif ($operation == "-") {
                $date[2] = (int) $date[2] - 543;
            }
            $date = $date[0] . "-" . $date[1] . "-" . $date[2] . " " . $datetime[1];
        }
        return $date;
    }

    public function afterGet($object, $remove = array()) {
        $rowNo = 1;
        if (count($object) > 1 || is_array($object)) {
            foreach ($object as $key => $data) {
                $object[$key]->rowNo = $rowNo++;
                foreach ($data as $field => $value) {
                    if (in_array($field, $remove)) {
                        unset($object[$key]->$field);
                    } else {
                        if (is_a($value, "DateTime")) {
                            $object[$key]->$field = $this->date2str($value, "d-m-Y", "+");
                        }
                    }
                }
            }
        } else {
            $object->rowNo = $rowNo++;
            foreach ($object as $field => $value) {
                if (in_array($field, $remove)) {
                    //   if ($field == "dateCreated" || $field == "dateUpdated" || $field == "createBy" || $field == "updateBy") {
                    unset($object->$field);
                } else {
                    if (is_a($value, "DateTime")) {
                        $object->$field = $this->date2str($value, "d-m-Y", "+");
                    }
                }
            }
        }
        return $object;
    }

}
