$(document).ready(function(){
    load_WorkAssignments();
});


function load_WorkAssignments() {
    $.post("dirs/workassignment/components/main.php", {
    }, function (data){
        $("#load_WorkAssignments").html(data);
        loadImperialAppliancesBranch();
        loadDepartmentStaff();
    });
}


/*Function set assingment Staff to other Branch*/
function mdlSetAsssignment() {
    $("#mdl-set-branch-assignment").modal('show');
}

/*load Imperial Branches*/
function loadImperialAppliancesBranch() {
  $.post("dirs/workassignment/actions/get_branches.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
      const branches = response.Data;
      $("#iap-branch").html('<option selected value="">All</option>');
      branches.forEach(branch => {
        $("#iap-branch").append(
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

/*load Department Staff*/
function loadDepartmentStaff() {
  $.post("dirs/workassignment/actions/get_staff.php", {}, function(data) {
    const response = JSON.parse(data);
    if ($.trim(response.isSuccess) === "success") {
        $("#user-id").val(response.Data.Uid);
      const branches = response.Data;
      $("#staff-name").html('<option selected value="">All</option>');
      branches.forEach(staff => {
        $("#staff-name").append(
          $("<option>", {
            value: staff.Fullname,
            text: staff.Fullname
          })
        );
      });
    } else {
      alert($.trim(response.Data));
    }
  });
}