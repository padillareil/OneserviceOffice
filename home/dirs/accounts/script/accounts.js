$(document).ready(function(){
    loadAccounts();
});


function loadAccounts() {
    $.post("dirs/accounts/components/main.php", {
    }, function (data){
        $("#loadAccounts").html(data);
        loadStaffAccounts();
    });
}


function mdladdAccount() {
    $("#mdl-add-account").modal('show');
}


/*Search post*/
$("#search-account").on("keydown", function(e) {
    if (e.key === "Enter") {
        loadStaffAccounts();
    }
});


    var currentPage = 1;
    var pageSize = 20;
    var totalPages = 1;
    var display = $("#load_accounts");

    function loadStaffAccounts(page = 1) {
        var Search = $("#search-account").val();
        $.post("dirs/accounts/actions/get_accounts.php", {
            CurrentPage: page,
            PageSize: pageSize,
            Search: Search
        }, function(data) {
            var response;
            try {
                response = JSON.parse(data);
            } catch (e) {
                toastr.error("Server error.", "Error");
                return;
            }
            if ($.trim(response.isSuccess) === "success") {
                displayUserAccounts(response.Data);
                currentPage = page;

                if (response.Data && response.Data.length > 0) {
                    totalPages = parseInt(response.Data[0].TotalPages);
                } else {
                    totalPages = 1;
                }
                buildPageNumbers();      
                updatePaginationUI();   
            }
             else {
                toastr.error($.trim(response.Data), "Error");
            }
        });
    }


    /* Render Blocked Accounts into Table */
    function displayUserAccounts(data) {
        const display = $("#load_accounts");
        display.empty();

        if (!data || data.length === 0) {
            display.html(`
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-file-earmark-text fs-3"></i><br>
                    No Services Found.
                </div>
            `);
            return;
        }

        data.forEach(req => {
            display.append(`
                <div class="col-md-3 col-sm-6 col-12 mb-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary" onclick="loadProfile('${req.Uid}')">
                            <i class="bi bi-person"></i>
                        </span>
                        <div class="info-box-content">
                            
                            <span class="info-box-text">${req.Fullname}</span>
                            <span class="info-box-number">${req.Position}</span>
                            <small>${req.Department ?? 'Head Office'}</small>
                        </div>
                        <div class="justify-content-end d-flex">
                            <div class="dropdown">
                              <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="accountEdit('${req.Uid}')">Edit (Under Repair)</a></li>
                                <li><a class="dropdown-item" href="#" onclick="accountBlock('${req.Uid}')">Block (Under Repair)</a></li>
                                <li><a class="dropdown-item" href="#" onclick="accountEnable('${req.Uid}')">Enable (Under Repair)</a></li>
                                <li><a class="dropdown-item" href="#" onclick="accountRecover('${req.Uid}')">Recover (Under Repair)</a></li>
                              </ul>
                            </div>
                        </div>

                    </div>
                </div>
                `);
            });
        }


    /* Pagination + Fetch Blocked Accounts */
    $("#btn-preview").on("click", function(e) {
        e.preventDefault();

        if (currentPage > 1) {
            loadStaffAccounts(currentPage - 1);
        }
    });

    $("#btn-next").on("click", function(e) {
        e.preventDefault();

        if (currentPage < totalPages) {
            loadStaffAccounts(currentPage + 1);
        }
    });

    $("#pagination").on("click", ".page-number a", function(e) {
        e.preventDefault();
        var page = parseInt($(this).data("page"));
        loadPostService(page);
    });

    /*Function to count page number page 1 of and so on*/
    function updatePaginationUI() {
        $("#page-info").text("Page " + currentPage + " of " + totalPages);
        if (currentPage <= 1) {
            $("#li-prev").addClass("disabled");
        } else {
            $("#li-prev").removeClass("disabled");
        }
        if (currentPage >= totalPages) {
            $("#li-next").addClass("disabled");
        } else {
            $("#li-next").removeClass("disabled");
        }
    }

    /*Function to build list of pagination*/
    function buildPageNumbers() {
        $("#pagination li.page-number").remove(); // remove old numbers
        var prevLi = $("#btn-preview").parent();
        for (var i = 1; i <= totalPages; i++) {
            var activeClass = (i === currentPage) ? "active" : "";
            var li = `
                <li class="page-item page-number ${activeClass}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
            $(li).insertAfter(prevLi);
            prevLi = prevLi.next();
        }
    }
