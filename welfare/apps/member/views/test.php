<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author สิทธิพร
 */
class test {

    //put your code here

    public function test($member) {
        $en = array("member", "salary", "contact", "work");

        for ($i = 0; $i < count($en); $i++) {
            $class = ucfirst($en[$i]);
            if ($i == 0) {
                ${$en[$i]} = $this->getValue(new $class(), $member->$en[$i]);
                ${$en[$i]}->memberId = $member->memberId;
                ${$en[$i] . "Class"} = new $class();
                ${$en[$i] . "Class"}->memberId = $member->memberId;
                ${$en[$i] . "Old"} = $this->datacontext->getObject(${$en[$i] . "Class"});
            } else {
                unset($member->$en[$i]);
                ${$en[$i] . "Class"} = new $class();
                ${$en[$i] . "Class"}->memberId = $member->memberId;
                ${$en[$i] . "Old"} = $this->datacontext->getObject(${$en[$i] . "Class"});
            }
            saveHistory(${$en[$i]}, ${$en[$i] . "Old"}, $en[$i]);
        }

//        $salary = $this->getValue(new Salary(), $member->salary);
//        $contact = $this->getValue(new Contact(), $member->contact);
//        $work = $this->getValue(new Work(), $member->work);
//
//        unset($member->salary);
//        unset($member->contact);
//        unset($member->work);
//
        $salary->memberId = $member->memberId;
        $contact->memberId = $member->memberId;
        $work->memberId = $member->memberId;
        $salaryOld = $this->datacontext->getObject(new \apps\member\entity\Salary(), $param)[0];
        $contactOld = $this->datacontext->getObject(new \apps\member\entity\Salary(), $param)[0]; //contact
        $workOld = $this->datacontext->getObject(new \apps\member\entity\Salary(), $param)[0]; //work
        $memberOld = $this->datacontext->getObject(new \apps\member\entity\Salary(), $param)[0]; //member

//        saveHistory($member, $memberOld, "member");
//        saveHistory($work, $workOld, "work");
//        saveHistory($contact, $contactOld, "contact");
//        saveHistory($salary, $salaryOld, "salary");
    }

    function saveHistory($dataNew, $dataOld, $entity) {
        foreach ($dataNew as $fieldNew => $valueNew) {
            if ($valueNew != null) {
                foreach ($dataOld as $filedOld => $valueOld) {
                    if ($fieldNew == $filedOld) {
                        if ($valueNew != $valueOld || $fieldNew != "memberId") {
                            $history = new History();
                            $history->memberId = $data->memberId;
                            $history->entityChange = $entity;
                            $history->fieldChange = $filedOld;
                            if (is_a($valueOld, "DateTime")) { //if value is DateTime
//                            if ($filedOld == "workStartDate" || $filedOld == "workEndDate" || $filedOld == "dob") {
                                $history->valueOld = $valueOld->format('Y-m-d');
                                $history->valueNew = $valueNew->format('Y-m-d');
                                $this->datacontext->saveObject($history);
                            } elseif ($filedOld != "userTypeId") {
                                $history->valueOld = $valueOld;
                                $history->valueNew = $valueNew;
                                $this->datacontext->saveObject($history);
                            }
                        }
                    }
                }
            }
        }
    }

}
