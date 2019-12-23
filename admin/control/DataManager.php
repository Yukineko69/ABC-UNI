<?php

namespace admin\control;
use core\util\Util;

require_once("admin/model/Data.php");
require_once("admin/view/DataView.php");
require_once("core/util/Util.php");

class DataManager {
  public function __contruct() {

  }

  // Student section
  // ================================================================================================================

  public function showStudentList() {
    $model = new \admin\model\Data();

    if (isset($_POST["std_added"])){
      $user_id = Util::clean($_POST["user_id"], 20);
      $username = Util::clean($_POST["username"], 100);
      $password = Util::clean($_POST["password"], 100);
      $fullname = Util::clean($_POST["fullname"], 100);
      $count = $model->addStudent($user_id, $username, $password, $fullname);

      if ($count == 0){
        $message = "Them sinh vien khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Them sinh vien thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/student");
    }
    if (isset($_POST["std_modified"])){
      $user_id = Util::clean($_POST["user_id"], 20);
      $username = Util::clean($_POST["username"], 100);
      $password = Util::clean($_POST["password"], 100);
      $fullname = Util::clean($_POST["fullname"], 100);
      $count = $model->modifyStudent($user_id, $username, $password, $fullname);

      if ($count == 0){
        $message = "Sua sinh vien khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Sua sinh vien thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/student");
    }
    if (isset($_GET["std_deleted"])){
      $count = $model->deleteStudent($_GET["user_id"]);

      if ($count == 0){
        $message = "Xoa sinh vien khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Xoa sinh vien thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/student");
    }

    $data = $model->getStudentList();
    $view = new \admin\view\DataView($data);

    echo $view->studentListView();

  }
  // ================================================================================================================


  // Course section
  // ================================================================================================================
  public function showCourseList() {
    $model = new \admin\model\Data();

    if (isset($_GET["hocphan_id"])){
      $this->showStudentByCourse();
    }
    else {
      if (isset($_POST["course_added"])){
        $course_id = Util::clean($_POST["course_id"], 20);
        $course_name = Util::clean($_POST["course_name"], 100);
        $teacher_id = Util::clean($_POST["teacher_id"], 20);
        $count = $model->addCourse($course_id, $course_name, $teacher_id);

        if ($count == 0){
          $message = "Them mon hoc khong thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
          $message = "Them mon hoc thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }

        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/monhoc");
      }
      if (isset($_POST["course_modified"])){
        $course_id = Util::clean($_POST["course_id"], 20);
        $course_name = Util::clean($_POST["course_name"], 100);
        $teacher_id = Util::clean($_POST["teacher_id"], 20);
        $count = $model->modifyCourse($course_id, $course_name, $teacher_id);

        if ($count == 0){
          $message = "Sua mon hoc khong thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
          $message = "Sua mon hoc thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }

        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/monhoc");
      }
      if (isset($_GET["course_deleted"])){
        $count = $model->deleteCourse($_GET["course_id"]);
        header("Location: http://localhost:8080/ABC-UNI/admin/monhoc");
      }

      $data = $model->getCourseList();
      $view = new \admin\view\DataView($data);

      echo $view->courseListView();
    }
  }

  public function showStudentByCourse() {
    $model = new \admin\model\Data();
    $data = $model->getStudentByCourse($_GET["hocphan_id"]);
    $semester_name = $model->getCourseName($_GET["hocphan_id"])[0]["ten_mon_hoc"];
    echo $semester_name . '<br />';

    $view = new \admin\view\DataView($data);
    echo $view->studentByCourseView();
  }
  // ================================================================================================================

  // Room section
  // ================================================================================================================
  public function showRoomList() {
    $model = new \admin\model\Data();

    if (isset($_POST["room_added"])){
      $room_id = Util::clean($_POST["room_id"], 20);
      $room_name = Util::clean($_POST["room_name"], 100);
      $max_slot = Util::clean($_POST["max_slot"], 20);
      $count = $model->addRoom($room_id, $room_name, $max_slot);

      if ($count == 0){
        $message = "Them phong may khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Them phong may thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/phongmay");
    }
    if (isset($_POST["room_modified"])){
      $room_id = Util::clean($_POST["room_id"], 20);
      $room_name = Util::clean($_POST["room_name"], 100);
      $max_slot = Util::clean($_POST["max_slot"], 20);
      $count = $model->modifyRoom($room_id, $room_name, $max_slot);

      if ($count == 0){
        $message = "Sua phong may khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Sua phong may thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/phongmay");
    }
    if (isset($_GET["room_deleted"])){
      $count = $model->deleteRoom($_GET["room_id"]);
      header("Location: http://localhost:8080/ABC-UNI/admin/phongmay");
    }

    $data = $model->getRoomList();
    $view = new \admin\view\DataView($data);

    echo $view->roomListView();
  }

  // ================================================================================================================


  // Semester section
  // ================================================================================================================
  public function showSemesterList() {
    $model = new \admin\model\Data();

    if (isset($_GET["kythi_id"]) && $_GET["kythi_id"] != ""){
      $this->showExamListBySemester();
    }
    else {
      if (isset($_POST["semester_added"])){
        $semester_id = Util::clean($_POST["semester_id"], 20);
        $semester_name = Util::clean($_POST["semester_name"], 100);
        $count = $model->addSemester($semester_id, $semester_name);

        if ($count == 0){
          $message = "Them ky thi khong thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
          $message = "Them ky thi thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }

        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/kythi");
      }
      if (isset($_POST["semester_modified"])){
        $semester_id = Util::clean($_POST["semester_id"], 20);
        $semester_name = Util::clean($_POST["semester_name"], 100);
        $count = $model->modifySemester($semester_id, $semester_name);

        if ($count == 0){
          $message = "Them ky thi khong thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
          $message = "Them ky thi thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }

        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/kythi");
      }
      if (isset($_GET["semester_deleted"])){
        $count = $model->deleteSemester($_GET["semester_id"]);
        header("Location: http://localhost:8080/ABC-UNI/admin/kythi");
      }

      $data = $model->getSemesterList();
      $view = new \admin\view\DataView($data);

      echo $view->semesterListView();
    }
  }
  // ================================================================================================================


  // Exam section
  // ================================================================================================================
  public function showExamListBySemester() {
    $model = new \admin\model\Data();
    $data = $model->getExamListBySemester($_GET["kythi_id"]);
    $semester_name = $model->getSemesterName($_GET["kythi_id"])[0]["ten_ky_thi"];
    echo '<h2 class="text-center">'.$semester_name.'</h2>' . '<br />';

    if (isset($_POST["exam_added"])){
      $exam_id = Util::clean($_POST["exam_id"], 20);
      $room_id = Util::clean($_POST["room_id"], 20);
      $course_id = Util::clean($_POST["course_id"], 20);
      $ngaythi = Util::clean($_POST["ngaythi"], 20);
      $cathi = Util::clean($_POST["cathi"], 20);

      $isDate = TRUE;
      $dateArr = explode("-", $ngaythi);
      if (count($dateArr) != 3){
        $isDate = FALSE;
      }
      else {
        $day = $dateArr[2];
        $month = $dateArr[1];
        $year = $dateArr[0];
        $isDate = checkdate($month, $day, $year);
      }

      if (!$isDate) {
        $message = "Ngay thi khong dung format xin hay nhap lai.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/kythi/id=".$_GET["kythi_id"]."");
      }
      else {
        $count = $model->addExam($exam_id, $room_id, $course_id, $_GET["kythi_id"], $ngaythi, $cathi);

        if ($count == 0){
          $message = "Them ca thi khong thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
          $message = "Them ca thi thanh cong";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }

        header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/kythi/id=".$_GET["kythi_id"]."");
        // header("Location: http://localhost:8080/ABC-UNI/admin/kythi/id=".$_GET["kythi_id"]."");
      }      
    }
    if (isset($_POST["exam_modified"])){
      $exam_id = Util::clean($_POST["exam_id"], 20);
      $room_id = Util::clean($_POST["room_id"], 20);
      $course_id = Util::clean($_POST["course_id"], 20);
      $ngaythi = Util::clean($_POST["ngaythi"], 20);
      $cathi = Util::clean($_POST["cathi"], 20);
      $count = $model->modifyExam($exam_id, $room_id, $course_id, $_GET["kythi_id"], $ngaythi, $cathi);

      if ($count == 0){
        $message = "Sua ca thi khong thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else {
        $message = "Sua ca thi thanh cong";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }

      header("refresh:1;url=http://localhost:8080/ABC-UNI/admin/kythi/id=".$_GET["kythi_id"]."");
    }
    if (isset($_GET["exam_deleted"])){
      $count = $model->deleteExam($_GET["exam_id"]);
      header("Location: http://localhost:8080/ABC-UNI/admin/kythi/id=".$_GET["kythi_id"]."");
    }


    if (isset($_GET["getAll"])){
      $examGroup = $model->groupBy_CaThi_NgayThi_PhongThi($_GET["kythi_id"]);
      foreach ($examGroup as $group){
        $stdList = $model->getStudentByExam($group["cathi"], $group["ngaythi"], $group["room_id"]);
        $view = new \admin\view\DataView($stdList);
        echo $view->studentByExamView();
      }
    }
    else {
      $view = new \admin\view\DataView($data);
      echo $view->examListView();
    }
  }
  // ================================================================================================================


}
