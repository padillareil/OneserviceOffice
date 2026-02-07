<div class="d-flex align-items-center gap-2">
	<button class="btn btn-success" type="button" onclick="mdladdService()"><i class="bi bi-plus-lg"></i>	Create Post</button>
	<input type="search" name="search-services" id="search-services" class="form-control ms-auto col-2" placeholder="Search">
</div>

<div id="load_Services"></div>

<script src="dirs/services/script/services.js"></script>



<input type="hidden" name="service_id" id="service_id"> <!-- service id base on the used -->

<?php include'modal.php';  ?>