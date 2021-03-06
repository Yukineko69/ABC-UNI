<?php

require_once("admin/model/Data.php");
include("Connect/excel/excel.php");

class ExcelControl {

  // Excel section
  // ================================================================================================================
  // Nhập dữ liệu từ excel vào database
  // Luôn lấy dữ liều từ file "data.xlsx" nằm ở thư mục ngoài cùng
  public function importExcel() {
    $model = new \admin\model\Data();
    $excel = new excel();
    $sinhvien = $excel->ReadExcel('0');
    foreach ($sinhvien as $row){
      $count = $model->addStudent($row[0], $row[1], $row[2], $row[3]);
    }

    $sv_camthi = $excel->ReadExcel('1');
    foreach ($sv_camthi as $row){
      $count = $model->addSv_CamThi($row[0], $row[1], $row[2]);
    }

    $sv_hocphan = $excel->ReadExcel('2');
    foreach($sv_hocphan as $row){
      $count = $model->addSv_HocPhan($row[0], $row[1], $row[2]);
    }

    echo "Import thành công dữ liệu từ excel.";
  }
  // ================================================================================================================
}

?>
