<?php
$menu = "service";
$page = "service-visit";
include_once(__DIR__ . "/../layout/header.php");
$param = (isset($params) ? explode("/", $params) : die(header("Location: /error")));
$uuid = (isset($param[0]) ? $param[0] : die(header("Location: /error")));

use App\Classes\Visit;

$VISIT = new Visit();
$row = $VISIT->request_view([$uuid]);
?>

<div class="row">
  <div class="col-xl-12">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="text-center">รายละเอียด</h4>
      </div>
      <div class="card-body">
        <form action="/visit/update" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-3 offset-xl-1 col-form-label">ID</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['id'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2" style="display: none;">
            <label class="col-xl-3 offset-xl-1 col-form-label">UUID</label>
            <div class="col-xl-4">
              <input type="text" class="form-control form-control-sm" name="uuid" value="<?php echo $row['uuid'] ?>" readonly>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ผู้ทำรายการ</label>
            <div class="col-xl-3 text-underline">
              <?php echo $row['fullname'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ประเภทลูกค้า</label>
            <div class="col-xl-3 text-underline">
              <?php echo $row['type_name'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">ชื่อลูกค้า</label>
            <div class="col-xl-3 text-underline">
              <?php echo $row['customer_user'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">บริษัท</label>
            <div class="col-xl-4 text-underline">
              <?php echo $row['customer_name'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">เบอร์ติดต่อ</label>
            <div class="col-xl-3 text-underline">
              <?php echo $row['customer_contact'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">โครงการ</label>
            <div class="col-xl-4 text-underline">
              <?php echo $row['customer_project'] ?>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">วัถตุประสงค์</label>
            <div class="col-xl-6">
              <div class="row">
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="1" name="reason" id="present" <?php echo (intval($row['reason']) === 1 ? "checked" : "") ?> required>
                    <label class="form-check-label" for="present">
                      <span class="text-success">นำเสนอ</span>
                    </label>
                  </div>
                </div>
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="reason" id="meeting" <?php echo (intval($row['reason']) === 2 ? "checked" : "") ?> required>
                    <label class="form-check-label" for="meeting">
                      <span class="text-danger">คุยงาน</span>
                    </label>
                  </div>
                </div>
                <div class="col-xl-3">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="reason" id="quotation" <?php echo (intval($row['reason']) === 3 ? "checked" : "") ?> required>
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
                    <input class="form-check-input" type="radio" value="1" name="opportunity" id="10" <?php echo (intval($row['opportunity']) === 1 ? "checked" : "") ?>>
                    <label class="form-check-label" for="10">
                      <span class="text-danger">10%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="2" name="opportunity" id="30" <?php echo (intval($row['opportunity']) === 2 ? "checked" : "") ?>>
                    <label class="form-check-label" for="30">
                      <span class="text-warning">30%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="3" name="opportunity" id="50" <?php echo (intval($row['opportunity']) === 3 ? "checked" : "") ?>>
                    <label class="form-check-label" for="50">
                      <span class="text-info">50%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="4" name="opportunity" id="70" <?php echo (intval($row['opportunity']) === 4 ? "checked" : "") ?>>
                    <label class="form-check-label" for="70">
                      <span class="text-primary">70%</span>
                    </label>
                  </div>
                </div>
                <div class="col">
                  <div class="form-check pt-2">
                    <input class="form-check-input" type="radio" value="5" name="opportunity" id="100" <?php echo (intval($row['opportunity']) === 5 ? "checked" : "") ?>>
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
              <textarea class="form-control form-control-sm" name="remark" rows="7" required><?php echo $row['remark'] ?></textarea>
              <div class="invalid-feedback">
                กรุณากรอกข้อมูล!!
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-xl-3 offset-xl-1 col-form-label">แผนที่</label>
            <div class="col-xl-7">
              <iframe width="600" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $row['latitude'] . "," . $row['longitude'] ?>&hl=es;z=8&amp;output=embed"></iframe>
            </div>
          </div>

          <div class="row mb-2 justify-content-center">
            <div class="col-xl-3 mb-2">
              <button type="submit" class="btn btn-success btn-sm btn-block">
                <i class="fas fa-check pr-2"></i>ยืนยัน
              </button>
            </div>
            <div class="col-xl-3 mb-2">
              <a href="/visit/manage" class="btn btn-danger btn-sm btn-block">
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