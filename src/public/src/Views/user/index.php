<?php
$menu = "setting";
$page = "setting-user";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">ผู้ใช้งาน</h4>
      </div>
      <div class="card-body">

        <div class="row justify-content-end mb-2">
          <div class="col-xl-3 mb-2">
            <a href="/user/create" class="btn btn-primary btn-sm btn-block">
              <i class="fas fa-plus pr-2"></i>เพิ่ม
            </a>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-xl-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover user-data">
                <thead>
                  <tr>
                    <th width="10%">สถานะ</th>
                    <th width="10%">สิทธิ์</th>
                    <th width="20%">อีเมล</th>
                    <th width="20%">ชื่อ</th>
                    <th width="20%">นามสกุล</th>
                    <th width="20%">ติดต่อ</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  filter_datatable();

  function filter_datatable() {
    $(".user-data").DataTable({
      serverSide: true,
      searching: true,
      scrollX: true,
      order: false,
      ajax: {
        url: "/user/user-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 1],
        className: "text-center",
      }],
      "oLanguage": {
        "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
        "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
        "sInfoFiltered": "",
        "sSearch": "ค้นหา :",
        "oPaginate": {
          "sFirst": "หน้าแรก",
          "sLast": "หน้าสุดท้าย",
          "sNext": "ถัดไป",
          "sPrevious": "ก่อนหน้า"
        }
      },
    });
  };
</script>