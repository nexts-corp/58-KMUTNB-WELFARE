$.extend(true, $.fn.dataTable.defaults, {
    "destroy": true,                 
    "iDisplayLength": 50,
    "oLanguage": {
        "sInfo": "<span style='font-size: 120%;'>รายการที่ _START_ ถึง _END_ จาก <span style='color: blue;'>_TOTAL_</span> รายการ</span>",
        "sInfoEmpty": "",
        "sInfoFiltered" : "(จากทั้งหมด _MAX_ รายการ)",
        "sEmptyTable": "ไม่มีข้อมูล",
        "sLengthMenu": "_MENU_ รายการต่อหน้า",
        "sSearch": "ค้นหา : "
    }
});
