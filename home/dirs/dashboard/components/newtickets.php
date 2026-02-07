<div class="card shadow-sm mt-2 ">
	<div class="card-body">
		<div class="mt-2 mb-2">
			<input type="search" name="search-ticket" id="search-ticket" class="form-control col-md-3" placeholder="Search">
		</div>
		<div class="table-responsive overflow-auto" style="height: 60vh;">
			<table class="table table-lg table-borderless table-hover">
			  <thead>
			    <tr>
			      <th  class="text-primary">ACTION</th>
			      <th  class="text-primary">TICKET NUMBER</th>
			      <th  class="text-primary">CLIENT</th>
			      <th  class="text-primary">BRANCH</th>
			      <th  class="text-primary">LAST UPDATED</th>
			      <th  class="text-primary">TIME REQUESTED</th>
			      <th class="text-primary">TIME AGO</th>
			      <th class="text-center text-primary">LEVEL</th>
			    </tr>
			  </thead>
			  <tbody id="load_new_tickets">


			  </tbody>
			</table>
		</div>
	</div>
	<div class="card-footer">
		
		      <button class="btn btn-link" type="button" id="btn-preview-rev">Previous </button>
		   
		      <button class="btn btn-link" type="button" id="btn-next-rev">Next</i></button>
	</div>
</div>





<script>
	$("#search-ticket").on("keydown", function(e) {
	    if (e.key === "Enter") {
	        loadRequest();
	    }
	});

	    var CurrentPage = 1;
	    var PageSize = 20;
	    var tbody = $("#load_new_tickets");

	    function loadRequest(CurrentPage = 1, status = null) {

	    var  Search = $("#search-ticket").val();

	    $.post("dirs/dashboard/actions/get_newticket.php", {
	        CurrentPage: CurrentPage,
	        PageSize: PageSize,
	        Search : Search, 
	       /* Category : Category,*/
	    }, function(data) {
	        let response;
	        try {
	            response = JSON.parse(data);
	        } catch (e) {
	            console.log("Server error.");
	            return;
	        }

	        if ($.trim(response.isSuccess) === "success") {
	            loadNewTickets(response.Data);
	            currentPage = CurrentPage;
	        } else {
	            console.log($.trim(response.Data));
	        }
	    });
	}

	/* Render Blocked Accounts into Table */
	function loadNewTickets(data) {
	    const tbody = $("#load_new_tickets"); 
	    tbody.empty();

	    if (!data || data.length === 0) {
	        tbody.html(`
	            <tr>
	                <td colspan="8" class="text-center text-muted py-4">
	                    <i class="bi bi-file-earmark-text fs-3"></i><br>No Record Found.
	                </td>
	            </tr>
	        `);
	        return;
	    }

	    data.forEach(req => {
	       if (req.levl === 'Medium') {
	           levelBadge = `<span class="badge badge-info">MEDIUM</span>`;
	       } else if (req.levl === 'High') {
	           levelBadge = `<span class="badge badge-danger">HIGH</span>`;
	       } else {
	           levelBadge = `<span class="badge badge-success">LOW</span>`;
	       }

	       tbody.append(`
	           <tr ondblclick="loadEw()">
	               <th class="t-action">
	                   <button class="btn btn-success" type="button" onclick="acceptRequest('${req.Req_id}')">Accept</button>
	                   <button class="btn btn-danger" type="button"  onclick="rejectRequest('${req.Req_id}')">Reject</button>
	               </th>
	               <td>
	       				<button class="btn btn-light" type="button" onclick="copyTktNumber('${req.TicketNum}',this)"><i class="bi bi-copy"></i>	${req.TicketNum}</button>

	               </td>
	               <td>${req.Fullname}</td>
	               <td>${req.Branch}</td>
	               <td>${req.Creation}</td>
	               <td>${req.TimeCreation}</td>
	               <td>${req.DocDateAgo}</td>
	               <td class="text-center">${levelBadge}</td>
	           </tr>
	       `);
	   });
	}


	/* Pagination + Fetch Blocked Accounts */
	$("#btn-preview-rev").on("click", function() {
	    if (currentPage > 1) {
	        loadRequest(currentPage - 1);
	    } else {
	        toastr.info("You're already on the first page.");
	    }
	});


	$("#btn-next-rev").on("click", function() {
	    loadRequest(currentPage + 1);
	});



	/*function copy ticket number*/
	function copyTktNumber(ticketNum, button) {
	    navigator.clipboard.writeText(ticketNum)
	        .then(() => {
	            const tooltip = new bootstrap.Tooltip(button, {
	                title: 'Copied!',
	                placement: 'left',
	                trigger: 'manual'
	            });

	            tooltip.show();
	            setTimeout(() => tooltip.dispose(), 1200);
	        })
	        .catch(err => console.error('Failed to copy:', err));
	}



function loadEw() {
	$("#modal-view-request").modal('show');
}


</script>