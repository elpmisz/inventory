<?php
$page = "item";
$group = "report";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>

    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">ข้อมูลอุปกรณ์</h4>
        </div>
        <div class="card-body">

          <div class="col-xl-3 col-md-6 mb-2">
            <a href="javascript:void(0)" class="btn btn-success btn-sm w-100 btn_form">
              <i class="fa fa-file-alt pe-2"></i>ฟอร์มอุปกรณ์
            </a>
          </div>

        </div>
      </div>
    </div>

  </div>
</main>


<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>