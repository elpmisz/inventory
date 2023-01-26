<?php

$page = "borrow";
$group = "service";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");

?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ระบบเบิกสินค้าตัวอย่าง</h4>
        </div>
        <div class="card-body">

          <div class="row justify-content-end">
            <div class="col-xl-3 col-md-6 mb-2">
              <a href="/borrow/request" class="btn btn-danger btn-sm w-100">
                <i class="fa fa-plus pe-2"></i>ใช้บริการ
              </a>
            </div>
          </div>

          <div class="card shadow my-2">
            <div class="card-header">
              <h4 class="text-center">รายการสินค้าที่ยังไม่ได้คืน</h4>
            </div>
            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm borrow w-100">
                      <thead>
                        <tr>
                          <th width="50%">อุปกรณ์</th>
                          <th width="10%">จำนวน</th>
                          <th width="10%">หน่วยนับ</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow my-2">
            <div class="card-header">
              <h4 class="text-center">รายการที่รอดำเนินการ</h4>
            </div>
            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm approve w-100">
                      <thead>
                        <tr>
                          <th width="5%">#</th>
                          <th width="20%">ผู้ใช้บริการ</th>
                          <th width="20%">จุดประสงค์</th>
                          <th width="5%">บริการ</th>
                          <th width="30%">อุปกรณ์</th>
                          <th width="10%">วันที่</th>
                          <th width="10%">วันที่ทำรายการ</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card shadow my-2">
            <div class="card-header">
              <h4 class="text-center">รายการขอใช้บริการ</h4>
            </div>
            <div class="card-body">
              <div class="row my-3">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm request w-100">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="20%">จุดประสงค์</th>
                          <th width="10%">บริการ</th>
                          <th width="30%">อุปกรณ์</th>
                          <th width="10%">วันที่</th>
                          <th width="10%">วันที่ทำรายการ</th>
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

    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>