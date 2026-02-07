$(document).ready(function(){
    loadHeadOffice();
});

// document.getElementById("Student_FilterKey").onkeypress = function(event){
//     if (event.keyCode == 13 || event.which == 13){
//         load_student_list();
//     }
// }

function loadHeadOffice() {
    $.post("dirs/ho_office/components/main.php", {
    }, function (data){
        $("#HO_contents").html(data);
        loadDepartments();
    });
}

/*Function to show modal create department*/
function mldDepartment() {
    $("#mdl-add-department").modal('show');
}

/*Load Departments*/
function loadDepartments() {
    $.post("dirs/ho_office/actions/get_department.php", {}, function(data) {
        let response = JSON.parse(data);
        let container = $("#department-list"); 
        container.empty(); 
        if ($.trim(response.isSuccess) === "success") {
            if (response.Data.length === 0) {
                container.html(`<small>No Record Found.</small>`);
                return;
            }
            let html = "";
            response.Data.forEach(function(item) {
                html += `
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" onclick="loadHOMember(${item.DP_code})">${item.DptName}</a>
                    </div>
                `;
            });
            container.html(html);

        } else {
            container.html(`<small>${response.Data}</small>`);
        }
    });
}



function loadHOMember(DP_code) {
    $.post("dirs/ho_office/actions/get_teamleader.php",{
        DP_code : DP_code
        },function(data){
        response = JSON.parse(data);
        if(jQuery.trim(response.isSuccess) == "success"){
            $("#team-leader-name").val(response.Data.Tl_name);
            loadDepartment_Members(response.Data.Dpt_code);
            countMembers(response.Data.Dpt_code);
        }else{
            alert(jQuery.trim(response.Data));
        }
    });
}



/*Function for pagination*/
    var Currentpage = 1;
    var Pagesize = 100;
    var tbody = $("#departentlist-members");
    function loadDepartment_Members(Dpt_code) {
        $.post("dirs/ho_office/actions/get_members.php", {
            Currentpage: Currentpage,
            Pagesize: Pagesize,
            Dpt_code: Dpt_code,
        }, function(data) {
            let response;
            try {
                response = JSON.parse(data);
            } catch (e) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Server error.",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            if ($.trim(response.isSuccess) === "success") {
                members(response.Data);
                Currentpage = Currentpage; 

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: $.trim(response.Data),
                    timer: 2000,
                    showConfirmButton: false
                });

            }

        });
    }
    /* Render Members into Table */
    function members(data) {
        const tbody = $("#departentlist-members");
        tbody.empty();

        if (!data || data.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-people fs-3"></i><br>No Members Found.
                    </td>
                </tr>
            `);
            return;
        }


        data.forEach(req => {
            let statusBadge = "";

            if ($.trim(req.Member_status).toUpperCase() === "ACTIVE") {
                statusBadge = `<span class="badge bg-success">Active</span>`;
            } else {
                statusBadge = `<span class="badge bg-danger">${req.Member_status}</span>`;
            }
            tbody.append(`
                <tr>
                    <td>${req.M_id}</td>
                    <td>${req.Member_name}</td>
                    <td>${req.Member_position}</td>
                    <td>${statusBadge}</td>
                </tr>
            `);
        });
    }
                            // <li><a class="dropdown-item" href="#" oclick="rmvStaff('${req.M_id}')">Remove</a></li>
                    // <td>
                    //     <div class="dropdown">
                    //       <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    //         <i class="bi bi-three-dots"></i>
                    //       </button>
                    //       <ul class="dropdown-menu">
                    //         <li><a class="dropdown-item" href="#" onclick="updStaff('${req.M_id}')">Account Recovery</a></li>
                    //       </ul>
                    //     </div>
                    // </td>

    /*AccountRecovery*/
    function countMembers(Dpt_code){
        $.post("dirs/ho_office/actions/get_countmembers.php",{
            Dpt_code : Dpt_code
        },function(data){
            response = JSON.parse(data);
            if(jQuery.trim(response.isSuccess) == "success"){
                $("#count-members").text(response.Data.TotalWithTL);
            }else{
                alert(jQuery.trim(response.Data));
            }
        });
    }