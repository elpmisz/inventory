<?php

$page = "borrow";
$group = "service";

include_once(__DIR__ . "/../../includes/header.php");
include_once(__DIR__ . "/../../includes/sidebar.php");

$param = (isset($params) ? explode("/", $params) : "");
$request_id = (!empty($param[0]) ? $param[0] : "");

$row = $Borrows->request_fetch([$request_id]);
$items = ($row['type_id'] === 1
  ? $Borrows->item_fetch([$row['zone_id'], $request_id], $row['user_id'])
  : $Borrows->item_return_fetch([$row['user_id']], $request_id));
$count_location = $Borrows->count_location([$request_id]);
?>

<main id="main" class="main">
  <div class="row justify-content-center">
    <?php include_once(__DIR__ . "/../../includes/alert.php"); ?>
    <div class="col-xl-12">
      <div class="card shadow">
        <div class="card-header">
          <h4 class="text-center">รายละเอียด</h4>
        </div>
        <div class="card-body">
          <form action="/borrow/approve" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">รายการ</label>
              <div class="col-xl-2 col-md-8">
                <input type="text" class="form-control form-control-sm" name="id" value="<?php echo $row['request_id'] ?>" readonly>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">หน่วยงาน</label>
              <div class="col-xl-6 col-md-8">
                <input type="text" class="form-control form-control-sm" value="<?php echo $row['user_name'] ?>" readonly>
              </div>
            </div>
            <div class="row mb-2" style="display: none;">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">บริการ</label>
              <div class="col-xl-2 col-md-8">
                <input type="text" class="form-control form-control-sm" name="type" value="<?php echo $row['type_id'] ?>" readonly>
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">บริการ</label>
              <div class="col-xl-2 col-md-8">
                <input type="text" class="form-control form-control-sm" value="<?php echo $row['type_name'] ?>" readonly>
              </div>
            </div>

            <?php if ($row['type_id'] === 1) : ?>
              <div class="row mb-2">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่ ยืม</label>
                <div class="col-xl-4 col-md-4 ">
                  <input type="text" class="form-control form-control-sm" value="<?php echo $row['date_borrow'] ?>" readonly>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['type_id'] === 2) : ?>
              <div class="row mb-2 div_return">
                <label class="col-xl-4 col-md-4 col-form-label text-xl-end">วันที่ คืน</label>
                <div class="col-xl-4 col-md-4 ">
                  <input type="text" class="form-control form-control-sm" value="<?php echo $row['date_return'] ?>" readonly>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end"><?php echo ($row['type_id'] === 1 ? "จุดประสงค์การยืม" : "รายละเอียดเพิ่มเติม") ?></label>
              <div class="col-xl-6 col-md-8">
                <textarea class="form-control form-control-sm" rows="3" readonly><?php echo $row['text'] ?></textarea>
              </div>
            </div>

            <?php if ($row['type_id'] === 1 && $count_location > 0) : ?>
              <div class="row mb-2">
                <div class="col-12">
                  <div id="map" style="width: 100%; height: 400px;"></div>
                </div>
              </div>
            <?php endif ?>

            <?php if ($row['type_id'] === 1) : ?>
              <div class="row mb-2">
                <div class="col-xl-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                      <thead>
                        <tr>
                          <th width="5%">#</th>
                          <th width="30%">อุปกรณ์</th>
                          <th width="10%">จำนวน (ที่มี)</th>
                          <th width="10%">จำนวน (ขอยืม)</th>
                          <th width="10%">จำนวน (ให้ยืม)</th>
                          <th width="5%">หน่วยนับ</th>
                          <th width="15%">เพิ่มเติม</th>
                          <th width="15%">หมายเหตุ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($items as $key => $item) :
                          $key++;
                          $balance = $Borrows->item_balance([$user['zone_id'], $item['item_id']]);
                          $stock = $item['stock'] - $balance;
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $key ?></td>
                            <td><?php echo $item['item_name'] . " - " . $item['item_id'] ?></td>
                            <td class="text-center"><?php echo $stock ?></td>
                            <td class="text-center"><?php echo $item['request_amount'] ?></td>
                            <td class="text-center">
                              <input type="hidden" class="form-control form-control-sm text-center" name="item__id[]" value="<?php echo $item['request_id'] ?>" readonly>
                              <input type="number" class="form-control form-control-sm text-center amount" name="item__confirm[]" value="<?php echo $item['request_amount'] ?>" min="1" max="<?php echo $stock ?>">
                            </td>
                            <td class="text-center"><?php echo $item['item_unit'] ?></td>
                            <td><?php echo $item['request_text'] ?></td>
                            <td>
                              <input type="text" class="form-control form-control-sm" name="item__remark[]">
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <?php if ($row['type_id'] === 2) : ?>
              <div class="row mb-2 div_return">
                <div class="col-sm-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm w-100">
                      <thead>
                        <tr>
                          <th width="10%">#</th>
                          <th width="30%">อุปกรณ์</th>
                          <th width="10%">จำนวน (ยืม)</th>
                          <th width="10%">จำนวน (คืน)</th>
                          <th width="10%">หน่วยนับ</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($items as $key => $item) :
                          $key++;
                        ?>
                          <tr>
                            <td class="text-center"><?php echo $key ?></td>
                            <td><?php echo $item['item_name'] ?></td>
                            <td class="text-center"><?php echo $item['balance'] ?></td>
                            <td>
                              <input type="hidden" class="form-control form-control-sm text-center" name="borrow_id[]" value="<?php echo $item['item_id'] ?>">
                              <input type="number" class="form-control form-control-sm text-center" name="borrow_amount[]" value="<?php echo $item['item_return'] ?>" <?php echo ($row['type_id'] === 2 ? 'min="1"' : "")  ?> max="<?php echo $item['balance'] ?>">
                            </td>
                            <td class="text-center"><?php echo $item['item_unit'] ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="row mb-2">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end">สถานะ</label>
              <div class="col-xl-8 col-md-8">
                <div class="form-check form-check-inline pt-2">
                  <input class="form-check-input" type="radio" name="status" id="active" value="3">
                  <label class="form-check-label text-success" for="active">ผ่านการอนุมัติ</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="inactive" value="4">
                  <label class="form-check-label text-danger" for="inactive">ไม่ผ่านการอนุมัติ</label>
                </div>
              </div>
            </div>

            <div class="row mb-2 div_text">
              <label class="col-xl-4 col-md-4 col-form-label text-xl-end text"></label>
              <div class="col-xl-6 col-md-8">
                <textarea class="form-control form-control-sm" name="text" rows="3" required></textarea>
              </div>
            </div>

            <div class="row justify-content-center mb-2">
              <div class="col-xl-3 col-md-6">
                <button type="submit" class="btn btn-success btn-sm w-100">
                  <i class="fas fa-check pe-2"></i>ยืนยัน
                </button>
              </div>
              <div class="col-xl-3 col-md-6">
                <a href="/borrow" class="btn btn-danger btn-sm w-100">
                  <i class="fa fa-arrow-left pe-2"></i>กลับหน้าหลัก
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include_once(__DIR__ . "/../../includes/footer.php");
?>
<?php if ($row['type_id'] === 1 && $count_location > 0) : ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaCQJfnRNiel1cPN93BlAzFP3uQset6hs&callback=initMap" async defer></script>
  <script>
    function initMap() {

      <?php
      $location = $Borrows->json_location([$row['request_id']]);
      echo "let lat = {$location['latitude']};";
      echo "let long = {$location['longitude']};";
      ?>

      const info = new google.maps.InfoWindow();
      const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: new google.maps.LatLng(parseFloat(lat), parseFloat(long))
      });

      <?php
      $json = $Borrows->json_fetch_item([$row['request_id']]);
      echo "let location = {$json};";
      ?>

      function placeMarker(loc) {
        const marker = new google.maps.Marker({
          position: new google.maps.LatLng(parseFloat(loc.latitude), parseFloat(loc.longitude)),
          map: map,
        });

        google.maps.event.addListener(marker, "click", function() {
          info.close();
          info.setContent(
            `<h5>${loc.user_name}</h5>` +
            `<h6>อุปกรณ์: ${loc.item_name}<br>` +
            `วันที่ยืม: ${loc.start}<br>` +
            `วันที่คืน: ${loc.end}<br>` +
            `จุดประสงค์: ${loc.request_text}</h6>`
          );
          info.open(map, marker)
        });
      }

      location.forEach(placeMarker);
    }
  </script>
<?php endif ?>
<script>
  $(".div_text").hide();
  $(document).on("click", "input[name='status']", function() {
    let status = parseInt($(this).val());
    $(".div_text").show();
    $("textarea[name='text']").val("");
    if (status === 3) {
      $(".text").text("รายละเอียดเพิ่มเติม");
    } else {
      $(".text").text("เหตุผล");
    }
  });
</script>