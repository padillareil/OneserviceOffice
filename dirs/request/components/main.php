<input type="hidden" id="important-value">

<div class="row">
	<div class="col-md-3">
		
		<div class="card shadow-sm">
			<div class="card-header">
				<div class="d-flex gap-2 mb-2">
				  <ul class="nav">
				    <li class="nav-item">
				      <a class="nav-link active" aria-current="page" href="#" onclick="load_Requests()">Inbox</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="#" onclick="emailDraft()">Draft</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link" href="#" onclick="loadImportant()">Important</a>
				    </li>
				  </ul>
				</div>
				<input type="search" name="search-email" id="search-email" class="form-control mb-2" placeholder="Search report">
				<div class="row">
					<div class="col-md-6">
						<label class="text-muted" for="created-date">Created Date:</label>
						<input type="date" name="created-date" id="created-date" class="form-control form-control-sm">
					</div>
					<div class="col-md-6">
						<label class="text-muted" for="last-update">Last date updated:</label>
						<input type="date" name="last-update" id="last-update" class="form-control form-control-sm">
					</div>
				</div>
			</div>
			<div class="card-body overflow-auto" style="height: 50vh;">
				<div class="list-group mt-2">
					<div id="load_emails"></div>
				</div>





			</div>
			<div class="card-footer">
				<div class="row justify-content-between">
				    <div class="col-auto">
				      <button class="btn btn-link" type="button" id="btn-preview-rev">Previous </button>
				    </div>
				    <div class="col-auto">
				      <button class="btn btn-link" type="button" id="btn-next-rev">Next</i></button>
				    </div>
				</div>
			</div>
		</div>
	</div>

	<!-- Diplay the composed -->
	<div class="col-md-9">
	  <div class="card overflow-auto" style="min-height: 60vh;">
	    <div class="card-body d-flex justify-content-center align-items-center">
	      	 <!--  <div class="text-center" id="message-empty">
	      	    <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
	      	    <h5 class="text-muted fw-bold mb-1">No Data Available</h5>
	      	    <p class="text-muted small mb-0">There is currently no content to display.</p>
	      	  </div> -->


	        <div class="card card-shadow mb-4 mt-4 w-100 d-none" id="message-content">
	          <div class="card-header bg-gradient-secondary text-white">
	            <div class="d-flex justify-content-between align-items-center">
	              <!-- Left: Title + Company -->
	              <div>
	                <strong>Requisition Slip</strong><br>
	                <small>Imperial Appliance Corporation</small>
	              </div>

	              <!-- Right: Date + Time together -->
	              <div class="text-end">
	                <small id="req-date" class="d-block"></small>
	                <small id="req-time" class="d-block"></small>
	                <small id="edited-status" class="d-none">Edited</small>
	              </div>
	            </div>

	          </div>
	          <div class="card-body" >
	            <div class="email-body">
	              <p>
	               Subject: <span id="request-subject"></span>
	              </p>
	              <p class="fw-semibold" id="user-greetings"></p>
	              <p id="description-body"></p>
	              <p>
	                From,<br>
	                <strong id="user-fullname"></strong>
	                <br>
	                <p id="user-position"></p>
	              </p>
	               <div class="text-center mt-3">
	                 <h4 class="text-dark fw-bold mb-1">TICKET NUMBER</h4>
	                 <p id="ticket-number" class="text-danger display-6"></p>
	               </div>
	            </div>
	          </div>
	          <div class="card-body pt-0 d-flex justify-content-end">
	            <div class="card shadow-sm p-3" style="max-width:500px;">
	              <!-- Title -->
	              <strong class="d-block mb-2">Reviewed by:</strong>

	              <!-- Approver profile -->
	              <div class="d-flex align-items-center mb-2">
	                <img src="assets/image/uploads/noimage.avif" 
	                     class="rounded-circle me-2" 
	                     style="width:40px; height:40px; object-fit:cover;">
	                <div class="fw-semibold">Juan Dela Cruz</div>
	              </div>

	              <!-- Position -->
	              <div class="d-flex mb-1">
	                <span class="me-2 text-muted">Position:</span>
	                <span class="fw-semibold">IT Manager</span>
	              </div>

	              <!-- Date & Time -->
	              <div class="d-flex mb-1 text-muted">
	                <span class="me-2">Date:</span>
	                <span>Jan 2, 2026</span>
	              </div>
	              <div class="d-flex mb-2 text-muted">
	                <span class="me-2">Time:</span>
	                <span>09:14 AM</span>
	              </div>

	              <!-- Status -->
	              <div class="d-flex">
	                <span class="me-2 text-muted">Status:</span>
	                <span class="text-success fw-semibold">Approved</span>
	              </div>

	              <!-- Optional: Users who opened the request -->
	              <div class="mt-3">
	                <small class="text-muted d-block mb-1">Viewed by:</small>
	                <div class="d-flex align-items-center">
	                  <!-- Existing viewers -->
	                  <img src="assets/image/uploads/noimage.avif" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover;" title="April Joy A. Calitina">
	                  <img src="assets/image/uploads/noimage.avif" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover;" title="Regine Joy Galimba">
	                  <img src="assets/image/uploads/noimage.avif" class="rounded-circle me-1" style="width:30px; height:30px; object-fit:cover;" title="Karl Getuya">
	                  
	                  <!-- Add new viewer button -->
	                  <a href="#" class="d-flex justify-content-center align-items-center rounded-circle text-primary"> More
	                  </a>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="card-footer bg-white">
	            <div class="d-flex justify-content-end gap-2">
	              <button class="btn btn-outline-secondary" type="button" onclick="editRequest()">
	                <i class="bi bi-pencil"></i> Edit
	              </button>
	              <button class="btn btn-outline-secondary" type="button" onclick="cloneRequest()">
	                <i class="bi bi-copy"></i> Clone
	              </button>
	              <button class="btn btn-outline-secondary" type="button" onclick="deleteRequest()">
	                <i class="bi bi-trash"></i> Delete
	              </button>
	            </div>
	          </div>
	        </div>
	      </div>	
	     

	    </div>

	   

	  </div>
	</div>



<!-- This input fields use for handling edit/delete and clone -->
	<input type="text" name="request-id" id="request-id">









<!--</div>
	<div class="card-body d-flex flex-column justify-content-center align-items-center text-center h-100">
	    <i class="bi bi-inbox fs-1 text-muted mb-1"></i>
	    <h5 class="text-muted fw-bold">No Data Available</h5>
	    <p class="text-muted small">There is currently no content to display.</p>
	 </div>
		</div> -->


<!-- <div class="card mb-3" style="max-width: 700px;">
  <div class="row g-0 align-items-start">
    <div class="col">
      <div class="card-body">
        <h6 class="card-subtitle text-muted mb-2">To: IT Department</h6>	
        <h5 class="card-title mb-3">Subject: System Access Request</h5>
        <textarea class="form-control mb-3" readonly>
			Detailed description of the request goes here. 
			Can span multiple lines and include notes or instructions.
        </textarea>
        <div class="mb-1">
          <label class="form-label fw-bold">Attachments:</label>
          <ul class="list-unstyled mb-0">
            <li><a href="#" class="text-decoration-none"><i class="bi bi-paperclip me-2"></i>document.pdf</a></li>
            <li><a href="#" class="text-decoration-none"><i class="bi bi-paperclip me-2"></i>image.png</a></li>
          </ul>
        </div>
        <small class="text-muted">Submitted at: 09:10 AM, 12-29-2025</small>
      </div>
    </div>
  </div>
</div>
 -->

<script>
	/*Filter key for date range*/
	$("#created-date, #last-update").on("keydown", function (e) {
	    if (e.key === "Enter") {
	        loadMails();
	    }
	});

	$("#search-email").on("keydown", function(e) {
	    if (e.key === "Enter") {
	        loadMails();
	    }
	});

	// Pagination
	$("#btn-preview-rev").on("click", function () {
	    if (CurrentPage > 1) {
	        loadMails(CurrentPage - 1);
	    } 
	});

	$("#btn-next-rev").on("click", function () {
	    loadMails(CurrentPage + 1);
	});

</script>




