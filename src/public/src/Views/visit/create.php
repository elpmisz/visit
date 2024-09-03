<?php
$menu = "service";
$page = "service-visit";
include_once(__DIR__ . "/../layout/header.php");
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">เพิ่ม</h4>
      </div>
      <div class="card-body">
        <form action="/visit/create" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-3 offset-xl-1 col-form-label">USER</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="user_id" value="<?php echo $user_id ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ผู้ทำรายการ</label>
            <div class="col-xl-4 text-underline">
              <?php echo $fullname ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ประเภทลูกค้า</label>
            <div class="col-xl-6">
              <div class="row">
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="1" name="type" id="new" required>
                    <label class="form-check-label" for="new">
                      <span class="text-success">ลูกค้าใหม่</span>
                    </label>
                  </div>
                </div>
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="type" id="old" required>
                    <label class="form-check-label" for="old">
                      <span class="text-danger">ลูกค้าเก่า</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="new-customer">
            <div class="row mb-2">
              <label class="col-xl-3 offset-xl-1 col-form-label">ชื่อลูกค้า</label>
              <div class="col-xl-4">
                <input type="text" class="form-control form-control-sm customer-input" name="customer_user">
                <div class="invalid-feedback">
                  กรุณากรอกข้อมูล!!
                </div>
              </div>
            </div>
          </div>
          <div class="old-customer">
            <div class="row mb-2">
              <label class="col-xl-3 offset-xl-1 col-form-label">รายชื่อลูกค้า</label>
              <div class="col-xl-4">
                <select class="form-control form-control-sm customer-select" name="customer_id"></select>
                <div class="invalid-feedback">
                  กรุณากรอกข้อมูล!!
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">บริษัท</label>
            <div class="col-xl-6">
              <input type="text" class="form-control form-control-sm" name="customer_name" required>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">เบอร์ติดต่อ</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="customer_contact" required>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">โครงการ</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="customer_project" required>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">วัถตุประสงค์</label>
            <div class="col-xl-6">
              <div class="row">
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="1" name="reason" id="present" required>
                    <label class="form-check-label" for="present">
                      <span class="text-success">นำเสนอ</span>
                    </label>
                  </div>
                </div>
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="reason" id="meeting" required>
                    <label class="form-check-label" for="meeting">
                      <span class="text-danger">คุยงาน</span>
                    </label>
                  </div>
                </div>
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="reason" id="quotation" required>
                    <label class="form-check-label" for="quotation">
                      <span class="text-primary">เสนอราคา</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">Sales Opportunity</label>
            <div class="col-xl-8">
              <div class="row">
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="1" name="opportunity" id="10">
                    <label class="form-check-label" for="10">
                      <span class="text-danger">10%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="opportunity" id="30">
                    <label class="form-check-label" for="30">
                      <span class="text-warning">30%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="3" name="opportunity" id="50">
                    <label class="form-check-label" for="50">
                      <span class="text-info">50%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="4" name="opportunity" id="70">
                    <label class="form-check-label" for="70">
                      <span class="text-primary">70%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="5" name="opportunity" id="100">
                    <label class="form-check-label" for="100">
                      <span class="text-success">100%</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">รายละเอียดเพิ่มเติม</label>
            <div class="col-xl-6">
              <textarea class="form-control form-control-sm" name="remark" rows="7" required></textarea>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-3 offset-xl-1 col-form-label">latitude</label>
            <div class="col-xl-6">
              <input type="text" class="form-control form-control-sm" name="latitude" readonly>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-3 offset-xl-1 col-form-label">longitue</label>
            <div class="col-xl-6">
              <input type="text" class="form-control form-control-sm" name="longitude" readonly>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>

          <div class="row mb-2 justify-content-center">
            <div class="col-xl-3 mb-2">
              <button type="submit" class="btn btn-success btn-sm btn-block">
                <i class="fas fa-check pr-2"></i>ยืนยัน
              </button>
            </div>
            <div class="col-xl-3 mb-2">
              <a href="/visit" class="btn btn-danger btn-sm btn-block">
                <i class="fas fa-arrow-left pr-2"></i>กลับ
              </a>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<?php include_once(__DIR__ . "/../layout/footer.php"); ?>
<script>
  $(".new-customer, .old-customer").hide();
  $(document).on("click", "input[name='type']", function() {
    let type = ($(this).val() ? parseInt($(this).val()) : "");
    $(".customer-select").empty();
    $("input[name='customer_name']").val("").prop("readonly", false);
    $("input[name='customer_contact']").val("").prop("readonly", false);
    $("input[name='customer_project']").val("").prop("readonly", false);
    if (type === 1) {
      $(".new-customer").show();
      $(".old-customer").hide();
      $(".customer-select").prop("required", false);
      $(".customer-input").prop("required", true);
    } else {
      $(".new-customer").hide();
      $(".old-customer").show();
      $(".customer-select").prop("required", true);
      $(".customer-input").prop("required", false);
    }
  });

  $(document).on("change", ".customer-select", function() {
    let customer = ($(this).val() ? $(this).val() : "");
    if (customer) {
      axios.post("/visit/customer-detail", {
          customer: customer
        })
        .then((res) => {
          let result = res.data;
          $("input[name='customer_name']").val(result.name).prop("readonly", true);
          $("input[name='customer_contact']").val(result.contact).prop("readonly", true);
          $("input[name='customer_project']").val(result.project).prop("readonly", true);
        }).catch((error) => {
          console.log(error);
        });
    }
  });

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;
      $("input[name='latitude']").val(latitude);
      $("input[name='longitude']").val(longitude);
    });
  } else {
    console.log("Geolocation is not supported by this browser.");
  }

  $(".customer-select").select2({
    placeholder: "-- เลือก --",
    allowClear: true,
    width: "100%",
    ajax: {
      url: "/visit/customer-select",
      method: "POST",
      dataType: "json",
      delay: 100,
      processResults: function(data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
</script>