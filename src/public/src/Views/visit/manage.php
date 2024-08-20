<?php
$menu = "service";
$page = "service-visit";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">จัดการ</h4>
      </div>
      <div class="card-body">

        <div class="row mb-2">
          <div class="col-xl-12">
            <div class="table-responsive">
              <table class="table table-bordered table-hover manage-data">
                <thead>
                  <tr>
                    <th width="10%">#</th>
                    <th width="10%">ผู้ทำรายการ</th>
                    <th width="10%">วัถตุประสงค์</th>
                    <th width="10%">ลูกค้า</th>
                    <th width="10%">บริษัท</th>
                    <th width="10%">โครงการ</th>
                    <th width="30%">รายละเอียด</th>
                    <th width="10%">วันที่แจ้ง</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

        <div class="row mb-2 justify-content-center">
          <div class="col-xl-3">
            <a href="/visit" class="btn btn-danger btn-sm btn-block">
              <i class="fas fa-arrow-left pr-2"></i>กลับ
            </a>
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
    $(".manage-data").DataTable({
      serverSide: true,
      searching: true,
      scrollX: true,
      order: [],
      ajax: {
        url: "/visit/manage-data",
        type: "POST",
      },
      columnDefs: [{
        targets: [0, 2],
        className: "text-center",
      }, {
        targets: [1, 3, 4, 5, 6, 7],
        className: "text-left",
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

  $(document).on("click", ".btn-delete", function(e) {
    let id = ($(this).prop("id") ? $(this).prop("id") : "");

    e.preventDefault();
    Swal.fire({
      title: "ยืนยันที่จะทำรายการ?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ปิด",
    }).then((result) => {
      if (result.value) {
        axios.post("/visit/delete", {
          id: id
        }).then((res) => {
          let result = res.data;
          if (parseInt(result) === 200) {
            Swal.fire({
              title: "ดำเนินการเรียบร้อย!",
              icon: "success"
            }).then((result) => {
              if (result.value) {
                location.reload();
              } else {
                return false;
              }
            })
          } else {
            location.reload();
          }
        }).catch((error) => {
          console.log(error);
        });
      } else {
        return false;
      }
    })
  });
</script>