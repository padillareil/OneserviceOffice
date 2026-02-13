$(document).ready(function(){
    loadCreateAccount();
});


function loadCreateAccount() {
    $.post("dirs/create_account/components/main.php", {
    }, function (data){
        $("#load_createaccount").html(data);
        loadUserAccount(); // load all user accounts
        loadImperialBranch();

    });
}

/*Function show passwor*/
function showPassword() {
    const passwordField = document.getElementById('password');
    const checkbox = document.getElementById('show-password');
    passwordField.type = checkbox.checked ? 'text' : 'password';
}


function createAccount() {
    $("#modal-add-account").modal('show');

  /*  $('#portal_id').val(generatePortalId(12));*/
}



/*load Imperial Branches*/
function loadImperialBranch() {
  $.post("dirs/create_account/actions/get_branch.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#branch").html('<option selected value="">Select Branch</option>');
      branches.forEach(branch => {
        $("#branch").append(
          $("<option>", {
            value: branch.Branch,
            text: branch.Branch
          })
        );
      });
    } else {
      alert($.trim(response.Data));
    }
  });
}

/*Function generate Portal ID Automatic*/
/*function generatePortalId(length = 12) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return result;
}*/


/*Function create account*/
$("#frm-account").submit(function(event) {
        event.preventDefault();
        var Fullname = $("#fullname").val();
        var Position = $("#position").val();
        var Username  = $("#username").val();
        var Password = $("#password").val();
        var Role    = $("#user-role").val();
        var Department = $("#department").val();
        var Branch = $("#branch").val();

        $.post("dirs/create_account/actions/save_account.php", {
            Fullname: Fullname,
            Position: Position,
            Username: Username,
            Password: Password,
            Role: Role,
            Department: Department,
            Branch: Branch
        }, function(data) {
            data = $.trim(data);
            if (data === "OK") {
                loadCreateAccount();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Successfully created.',
                    timer: 2000,
                    showConfirmButton: false
                });
                $("#frm-account")[0].reset();
                $("#modal-add-account").modal('hide');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops',
                    text: data,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });


$("#search-account").on("keydown", function(e) {
    if (e.key === "Enter") {
        loadUserAccount();
    }
});


var CurrentPage = 1;
var pageSize = 100;

function loadUserAccount(page = 1) {
    var Search = $("#search-account").val();
    $.post("dirs/create_account/actions/get_account.php", {
        CurrentPage: page,
        PageSize: pageSize,
        Search: Search
    }, function (data) {

        let response;
        try {
            response = JSON.parse(data);
        } catch (e) {
            toastr.error("Server error.", "Error");
            return;
        }

        if ($.trim(response.isSuccess) === "success") {
            renderAccounts(response.Data);
            CurrentPage = page;
        } else {
            toastr.error($.trim(response.Data), "Error");
        }
    });
}

function renderAccounts(data) {
    const container = $("#load_accounts");
    container.empty();

    if (!data || data.length === 0) {
        container.html(`
            <div class="col-12 text-center text-muted py-4">
                <i class="bi bi-file-earmark-text fs-3"></i><br>
                No Record Found.
            </div>
        `);
        return;
    }

    data.forEach(req => {
        container.append(`
            <div class="col-md-3 col-sm-6 col-12 mb-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success" onclick="loadProfile('${req.Uid}')">
                        <i class="bi bi-person"></i>
                    </span>
                    <div class="info-box-content">
                        
                        <span class="info-box-text">${req.UserFullname}</span>
                        <span class="info-box-number">${req.UserJobPosition}</span>
                        <small>${req.BranchRegion ?? 'Head Office'}</small>
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

// Pagination
$("#btn-preview-rev").on("click", function () {
    if (CurrentPage > 1) {
        loadUserAccount(CurrentPage - 1);
    } else {
        toastr.info("You're already on the first page.");
    }
});

$("#btn-next-rev").on("click", function () {
    loadUserAccount(CurrentPage + 1);
});



function loadProfile(Uid){
    $("#mdl-profile").modal('show');
    $.post("dirs/create_account/actions/get_user.php",{
        Uid : Uid
    },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#usr-fullname").text(response.Data.Fullname);
            $("#usr-position").text(response.Data.Position);
            $("#usr-portalid").text(response.Data.Portal_id);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}
