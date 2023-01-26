<?php

$page = "users";
$group = "system";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");

if ($user['user_level'] === 1) {
  header("Location: /error");
}
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ข้อมูลผู้ใช้งาน</h4>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-success shadow py-2 count" id="1">
                <div class="card-body">
                  <h3 class="text-end"><?php echo (isset($count['total']) ? $count['total'] : 0) ?></h3>
                  <h5 class="text-end">ผู้ใช้งาน</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-warning shadow py-2 count" id="2">
                <div class="card-body">
                  <h3 class="text-end"><?php echo (isset($count['total']) ? $count['district'] : 0) ?></h3>
                  <h5 class="text-end">ผู้ดูแลระบบ</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-primary shadow py-2 count" id="3">
                <div class="card-body">
                  <h3 class="text-end"><?php echo (isset($count['total']) ? $count['province'] : 0) ?></h3>
                  <h5 class="text-end">ใช้งาน</h5>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-2">
              <div class="card text-bg-danger shadow py-2 count" id="4">
                <div class="card-body">
                  <h3 class="text-end"><?php echo (isset($count['total']) ? $count['admin'] : 0) ?></h3>
                  <h5 class="text-end">ระงับการใช้งาน</h5>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_excel">
                <i class="fa fa-file-alt pe-2"></i>รายงาน
              </a>
            </div>

            <div class="col-xl-3 col-md-6 offset-xl-3 mb-2">
              <select class="form-select form-select-sm w-100 zone_filter" data-placeholder="-- เลือก --"></select>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
              <a href="/users/create" class="btn btn-danger btn-sm w-100">
                <i class="fa fa-plus pe-2"></i>เพิ่ม
              </a>
            </div>
          </div>

          <div class="row my-3">
            <div class="col-xl-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm data w-100">
                  <thead>
                    <tr>
                      <th width="10%">#</th>
                      <th width="10%">รหัส</th>
                      <th width="20%">ชื่อหน่วยงาน</th>
                      <th width="20%">จังหวัด</th>
                      <th width="10%">เขต</th>
                      <th width="10%">ระดับ</th>
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
</main>

<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>