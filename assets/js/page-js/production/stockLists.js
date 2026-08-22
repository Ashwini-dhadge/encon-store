// function filter_indent() {
//   var type = $("#type").val();
//   var indentid = $("#indentid").val();
//   var data = {
//     type: type,
//     indentid: indentid,
//   };
//   listbladeindent(data);
// }
$(document).ready(function () {
    var bladeindent = ""; // Initialize variable
    $("#details").hide();
  
    function listReceivedOrders() {
      
      const dummyData = [
        {
            Sr_No: 1,
            Order_No: "ORD001",
            Plant_Name: "Plant X",
            Stock_Qty: '<span class="label label-success">100</span>',
            Mould_Size: "Mould A",
            Blade_Size_mm: "250",
            Blade_Punching_Number: "Punch001",
            A_Tip_mm: "5",
            Color: "Red",
            Action: '<a href="' + base_url + 'admin/production/Indent/view_indent_blade/IND005" class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></a>',
        },
        {
            Sr_No: 2,
            Order_No: "ORD002",
            Plant_Name: "Plant Y",
            Stock_Qty: '<span class="label label-success">150</span>',
            Mould_Size: "Mould B",
            Blade_Size_mm: "300",
            Blade_Punching_Number: "Punch002",
            A_Tip_mm: "6",
            Color: "Blue",
            Action: '<a href="' + base_url + 'admin/production/Indent/view_indent_blade/IND005" class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></a>',
        },
        {
            Sr_No: 3,
            Order_No: "ORD003",
            Plant_Name: "Plant Z",
            Stock_Qty: '<span class="label label-success">200</span>',
            Mould_Size: "Mould C",
            Blade_Size_mm: "280",
            Blade_Punching_Number: "Punch003",
            A_Tip_mm: "5.5",
            Color: "Green",
            Action: '<a href="' + base_url + 'admin/production/Indent/view_indent_blade/IND005" class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></a>',
        },
        {
            Sr_No: 4,
            Order_No: "ORD004",
            Plant_Name: "Plant W",
            Stock_Qty: '<span class="label label-success">120</span>',
            Mould_Size: "Mould D",
            Blade_Size_mm: "260",
            Blade_Punching_Number: "Punch004",
            A_Tip_mm: "4.5",
            Color: "Yellow",
            Action: '<a href="' + base_url + 'admin/production/Indent/view_indent_blade/IND005" class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></a>',
        },
        {
            Sr_No: 5,
            Order_No: "ORD005",
            Plant_Name: "Plant V",
            Stock_Qty: '<span class="label label-success">180</span>',
            Mould_Size: "Mould E",
            Blade_Size_mm: "270",
            Blade_Punching_Number: "Punch005",
            A_Tip_mm: "5.2",
            Color: "Orange",
            Action: '<a href="' + base_url + 'admin/production/Indent/view_indent_blade/IND005" class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></a>',
        },
    ];
    
      // let createdCount = dummyData.length;
  
      // document.getElementById(
      //   "created-stage"
      // ).innerHTML = `<div><i class="fas fa-user"></i></div> Created (${createdCount})`;
  
      bladeindent = $("#tblStock").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
          sProcessing: '<div class="dt-loader"></div>',
        },
        processing: true,
        destroy: true,
        searching: true,
        pageLength: 25,
        order: [[1, "asc"]],
        data: dummyData,
        columnDefs: [{ responsivePriority: 1, targets: 7 }],
        columns: [
          {
              data: "Sr_No",
              width: "10%",
              title: "Sr. No.",
              orderable: false,
              render: function (data, type, row, meta) {
                  return `<span>${data}</span> <i class="fas fa-plus-circle plus-icon" data-index="${meta.row}"></i>`;
              },
          },
          { data: "Order_No", width: "15%", title: "Order No" },
          { data: "Plant_Name", width: "15%", title: "Plant Name" },
          { data: "Stock_Qty", width: "15%", title: "Stock Qty" },
          { data: "Mould_Size", width: "15%", title: "Mould Size" },
          { data: "Blade_Size_mm", width: "15%", title: "Blade Size (mm)" },
          { data: "Blade_Punching_Number", width: "15%", title: "Blade Punching Number" },
          { data: "A_Tip_mm", width: "15%", title: "A Tip (mm)" },
          { data: "Color", width: "15%", title: "Color" },
          {
              data: "Action",
              width: "10%",
              title: "Action",
              orderable: false,
              className: "text-center",
              render: function (data) {
                  return data; // Assuming "Action" already contains the button HTML
              },
          },
      ],
      
      });
  
      $("#tblStock").on("click", ".plus-icon", function () {
        $("#details").show();
        var rowIndex = $(this).data("index");
        var row = bladeindent.row(rowIndex).data();
        var bladeQty = row.Blade_Qty;
        var receivedQty = row.Received_Qty;
        var Indent_Number = row.Indent_Number;
  
        // $("#b_qt").text(bladeQty);
        // $("#received_qty").text(receivedQty); 
        $("#indent_no").text(Indent_Number); 

        $(".create").hide();
        $(".hand").hide();
        $(".position").hide();
        $(".remark").hide();
        $(".added_by").hide();
        $("#select_stage").change(function () {
          let stage = $("#select_stage").val();
          if (stage == "Created") {
            $(".position").hide();
            $(".hand").hide();
            $(".create").show();
            $(".remark").show();
            $(".added_by").show();
          } else if (stage == "Hand") {
            $(".create").hide();
            $(".position").hide();
            $(".hand").show();
            $(".remark").show();
            $(".added_by").show();
          } else if (stage == "Position") {
            $(".hand").hide();
            $(".create").hide();
            $(".position").show();
            $(".remark").show();
            $(".added_by").show();
          }
        });
      });
    }
  
    listReceivedOrders();
  });
  
  
  // $(document).ready(function () {
  //   filter_indent();
  // });
  