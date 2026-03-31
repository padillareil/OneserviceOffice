<div class="card shadow-sm" style="height: 80vh;">
	<div class="card-header bg-primary-subtle">
	    <small class="text-muted d-block mb-2">Look Up Ticket</small>
	    <div class="d-flex flex-wrap align-items-end gap-3">
	        <div>
	            <label for="search-ticketnumber" class="form-label small">Search Ticket</label>
	            <input type="text" name="search-ticketnumber" id="search-ticketnumber" class="form-control form-control-sm">
	        </div>
	        <div>
	            <label for="branch" class="form-label small">Branch</label>
	            <select class="form-select form-select-sm" id="branch">
	            	<option value="" selected>Branch</option>
	            </select>	
	        </div>
	        <div>
	            <label for="date-from" class="form-label small">Date From</label>
	            <input type="date" name="date-from" id="date-from" class="form-control form-control-sm">
	        </div>
	        <div>
	            <label for="date-to" class="form-label small">Date To</label>
	            <input type="date" name="date-to" id="date-to" class="form-control form-control-sm">
	        </div>
	        <div>
	            <button class="btn btn-sm btn-success" type="button" onclick="loadFindTicket()">
	                Generate
	            </button>
	        </div>
	        <div>
	            <button class="btn btn-sm btn-primary" type="button" onclick="load_Ticket_lookUp()">
	                Refresh
	            </button>
	        </div>
	    </div>
	</div>
	<div class="card-body">
		 <div class="table-responsive overscroll-auto" style="height: 55vh;">
		    <table class="table table-bordered table-hover">
		      <thead>
		        <tr class="table-info">
		          <th class="sticky-top">Ticket No.</th>
		          <th class="sticky-top">Branch</th>
		          <th class="sticky-top">Client</th>
		          <th class="sticky-top">Service Type</th>
		          <th class="sticky-top text-center">Date Created</th>
		          <th class="sticky-top text-center">Approver</th>
		          <th class="sticky-top text-center">Document Date</th>
		        </tr>
		      </thead>
		      <tbody id="display_all_tickets">
		        <tr>
		          <td colspan="7" class="text-center py-5">
		            <div class="d-flex flex-column align-items-center text-muted">
		              <div class="mb-3" style="font-size: 40px; opacity: .35;">
		                <i class="fa fa-file"></i>
		              </div>
		              <div class="fw-semibold">Generate to show Tickets.</div>
		              <div class="small opacity-75">
		                Please generate if no available tickets displayed.
		              </div>
		            </div>
		          </td>
		        </tr>
		      </tbody>
		    </table>
		</div>
	</div>
	<div class="card-footer">
	  <nav>
	      <ul class="pagination" id="pagination">
	          <li class="page-item">
	              <a class="page-link" href="#" id="btn-preview">Previous</a> <!-- Page list number -->
	          </li>
	          <li class="page-item">
	              <a class="page-link" href="#" id="btn-next">Next</a>
	          </li>
	      </ul>
	  </nav>
	  <div id="page-info" class="mt-3 small text-muted">  <!-- Page number counting -->
	  </div>
	</div>
</div>


<script>



	  /* Pagination + Fetch Blocked Accounts */
	  $("#btn-preview").on("click", function(e) {
	      e.preventDefault();

	      if (currentPage > 1) {
	          loadFindTicket(currentPage - 1);
	      }
	  });

	/*Function load all important tags tickets*/
	  $("#btn-next").on("click", function(e) {
	      e.preventDefault();

	      if (currentPage < totalPages) {
	          loadFindTicket(currentPage + 1);
	      }
	  });
</script>