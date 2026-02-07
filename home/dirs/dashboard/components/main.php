<ul class="nav nav-tabs mt-2" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active fs-6" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab">
      New ticket view
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button class="nav-link fs-6" id="open-tab" data-bs-toggle="tab" data-bs-target="#open" type="button" role="tab">
      Open Tickets
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button class="nav-link fs-6" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
      All Tickets
    </button>
  </li>
</ul>



<div class="tab-content mt-3">
  <div class="tab-pane fade show active" id="new" role="tabpanel">
    <?php include 'newtickets.php';  ?>
  </div>

  <div class="tab-pane fade" id="open" role="tabpanel">
    <?php include 'opentickets.php';  ?>
  </div>

  <div class="tab-pane fade" id="all" role="tabpanel">
    <?php include 'alltickets.php';  ?>
  </div>
</div>




<input type="text" id="ticket-id">