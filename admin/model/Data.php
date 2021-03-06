<?php

namespace admin\model;
use core\data\model\PDOData;

require_once("core/data/PDOData.php");

class Data {
  public function __contruct() {

  }

  // Student section
  // ================================================================================================================
  // Lấy danh sách tất cả sinh viên
  public function getStudentList() {
    $db = new PDOData();
    $data = $db->doQuery("
      select user_id, username, fullname
      from user
      where isAdmin = 0
      order by fullname asc;
    ");

    return $data;
  }
  // Thêm sinh viên vào bảng user
  public function addStudent($user_id, $username, $password, $fullname) {
    $db = new PDOData();
    $hashed = hash("sha256", $password);
    $count = $db->doPrepareSql("
      insert into user (user_id, username, password, fullname)
      values (?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
			username = ?, password = ?, fullname = ?;
    ", array($user_id, $username, $hashed, $fullname, $username, $hashed, $fullname));

    return $count;
  }
  // Sửa thông tin sinh viên
  public function modifyStudent($user_id, $username, $password, $fullname) {
    $db = new PDOData();
    $hashed = hash("sha256", $password);
    $count = $db->doPrepareSql("
      update user
      set username = ?, password = ?, fullname = ?
      where user_id = ?;
    ", array($username, $hashed, $fullname, $user_id));

    return $count;
  }
  // Xóa sinh viên
  public function deleteStudent($user_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      delete from user
      where user_id = ?;
    ", array($user_id));

    return $count;
  }
  // Lấy ra danh sách sinh viên thuộc môn học có id=$hocphan_id
  public function getStudentByCourse($hocphan_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
    select skh.*, u.username, u.fullname, h.ten_mon_hoc
    from sv_kythi_hocphan skh
    inner join user u
    on skh.sv_id = u.user_id
    inner join hocphan h
    on skh.hocphan_id = h.hocphan_id
    where skh.hocphan_id = ?;
    ", array($hocphan_id));

    return $data;
  }
  // Lấy ra danh sách sinh viên thuộc ca thi
  public function getStudentByExam($cathi, $ngaythi, $room_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
    select  sc.sv_id, u.username, u.fullname,
            k.kythi_id, k.ten_ky_thi,
            sc.cathi_id, c.cathi, c.ngaythi,
            r.room_id, r.room_name,
            h.hocphan_id, h.ten_mon_hoc
    from sv_cathi sc
    inner join cathi c
    on sc.cathi_id = c.cathi_id
    inner join user u
    on sc.sv_id = u.user_id
    inner join room r
    on c.room_id = r.room_id
    inner join hocphan h
    on c.hocphan_id = h.hocphan_id
    inner join kythi k
    on c.kythi_id = k.kythi_id
    where c.cathi = ? and c.ngaythi = ? and r.room_id = ?
    order by c.cathi, c.ngaythi, r.room_id;
    ", array($cathi, $ngaythi, $room_id));

    return $data;
  }

  // ================================================================================================================


  // Course section
  // ================================================================================================================
  // Lấy danh sách tất cả môn học
  public function getCourseList() {
    $db = new PDOData();
    $data = $db->doQuery("
      select h.*, u.fullname
      from hocphan h
      inner join user u
      on u.user_id = h.teacher_id
      order by h.hocphan_id desc;
    ");

    return $data;
  }
  // Thêm môn học
  public function addCourse($hocphan_id, $ten_mon_hoc, $teacher_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      insert into hocphan (hocphan_id, ten_mon_hoc, teacher_id)
      values (?, ?, ?);
    ", array($hocphan_id, $ten_mon_hoc, $teacher_id));

    return $count;
  }
  // Sửa thông tin môn học
  public function modifyCourse($hocphan_id, $ten_mon_hoc, $teacher_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      update hocphan
      set ten_mon_hoc = ?, teacher_id = ?
      where hocphan_id = ?;
    ", array($ten_mon_hoc, $teacher_id, $hocphan_id));

    return $count;
  }
  // Xóa môn học
  public function deleteCourse($course_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      delete from hocphan
      where hocphan_id = ?;
    ", array($course_id));

    return $count;
  }

  public function getCourseName($hocphan_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
      select *
      from hocphan
      where hocphan_id = ?
    ", array($hocphan_id));

    return $data;
  }
  // ================================================================================================================

  // Room section
  // ================================================================================================================

  public function getRoomList() {
    $db = new PDOData();
    $data = $db->doQuery("
    select *
    from room
    order by room_id asc;
    ");

    return $data;
  }

  public function addRoom($room_id, $room_name, $max_slot) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
    insert into room (room_id, room_name, max_slot)
    values (?, ?, ?);
    ", array($room_id, $room_name, $max_slot));

    return $count;
  }

  public function modifyRoom($room_id, $room_name, $max_slot) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
    update room
    set room_name = ?, max_slot = ?
    where room_id = ?;
    ", array($room_name, $max_slot, $room_id));

    return $count;
  }

  public function deleteRoom($room_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
    delete from room
    where room_id = ?;
    ", array($room_id));

    return $count;
  }

  // ================================================================================================================


  // Semester section
  // ================================================================================================================

  public function getSemesterList() {
    $db = new PDOData();
    $data = $db->doQuery("
      select *
      from kythi
      order by kythi_id desc;
    ");

    return $data;
  }

  public function addSemester($kythi_id, $ten_ky_thi) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      insert into kythi (kythi_id, ten_ky_thi)
      values (?, ?);
    ", array($kythi_id, $ten_ky_thi));

    return $count;
  }

  public function modifySemester($kythi_id, $ten_ky_thi) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      update kythi
      set ten_ky_thi = ?
      where kythi_id = ?;
    ", array($ten_ky_thi, $kythi_id));

    return $count;
  }

  public function deleteSemester($semester_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      delete from kythi
      where kythi_id = ?;
    ", array($semester_id));

    return $count;
  }

  // ================================================================================================================


  // Exam section
  // ================================================================================================================
  // Lấy danh sách ca thi trong một kì thi
  public function getExamListBySemester($kythi_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
      select ct.*, kt.ten_ky_thi, hp.ten_mon_hoc, r.room_name
      from cathi ct
      inner join kythi kt
      on kt.kythi_id = ct.kythi_id
      inner join hocphan hp
      on hp.hocphan_id = ct.hocphan_id
      inner join room r
      on r.room_id = ct.room_id
      where ct.kythi_id = ?
      order by ct.cathi_id;
    ", array($kythi_id));

    return $data;
  }

  public function getSemesterName($kythi_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
      select *
      from kythi
      where kythi_id = ?
    ", array($kythi_id));

    return $data;
  }

  public function addExam($exam_id, $room_id, $hocphan_id, $kythi_id, $ngaythi, $cathi) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      insert into cathi (cathi_id, room_id, hocphan_id, kythi_id, ngaythi, cathi)
      values (?, ?, ?, ?, ?, ?);
    ", array($exam_id, $room_id, $hocphan_id, $kythi_id, $ngaythi, $cathi));

    return $count;
  }

  public function modifyExam($exam_id, $room_id, $hocphan_id, $kythi_id, $ngaythi, $cathi) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      update cathi
      set room_id = ?, hocphan_id = ?, kythi_id = ?, ngaythi = ?, cathi = ?
      where cathi_id = ?;
    ", array($room_id, $hocphan_id, $kythi_id, $ngaythi, $cathi, $exam_id));

    return $count;
  }

  public function deleteExam($exam_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      delete from cathi
      where cathi_id = ?;
    ", array($exam_id));

    return $count;
  }
  // Tìm ra các bộ (ngày thi, ca thi, phòng thi) unique
  public function groupBy_CaThi_NgayThi_PhongThi($kythi_id) {
    $db = new PDOData();
    $data = $db->doPreparedQuery("
      select  k.kythi_id, k.ten_ky_thi,
              sc.cathi_id, c.cathi, c.ngaythi,
              r.room_id, r.room_name
      from sv_cathi sc
      inner join cathi c
      on sc.cathi_id = c.cathi_id
      inner join room r
      on c.room_id = r.room_id
      inner join kythi k
      on c.kythi_id = k.kythi_id
      where k.kythi_id = ?
      group by c.ngaythi, c.cathi, r.room_id
      order by c.ngaythi, c.cathi, r.room_id;
    ", array($kythi_id));

    return $data;
  }

  // ================================================================================================================


  // Excel import section
  // ================================================================================================================
  // Thêm sinh viên bị cấm thi vào db
  public function addSv_CamThi($sv_id, $kythi_id, $hocphan_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      update sv_kythi_hocphan
      set banned = 1
      where sv_id = ? and kythi_id = ? and hocphan_id = ?;
    ", array($sv_id, $kythi_id, $hocphan_id));

    return $count;
  }

  // Thêm học phần một sinh viên học trong kỳ
  public function addSv_HocPhan($sv_id, $kythi_id, $hocphan_id) {
    $db = new PDOData();
    $count = $db->doPrepareSql("
      insert into sv_kythi_hocphan (sv_id, kythi_id, hocphan_id)
      values (?, ?, ?);
    ", array($sv_id, $kythi_id, $hocphan_id));

    return $count;
  }

}
