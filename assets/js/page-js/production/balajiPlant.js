

// function filter_indent() {
//   var type = $("#type").val();
//   var indentid = $("#indentid").val();
//   var data = {
//     type: type,
//     indentid: indentid,
//   };
//   listbladeindent(data);
// }
// $(document).ready(function () {
//     var bladeindent = ""; // Initialize variable
//     $("#details").hide();
  
//     function listReceivedOrders() {
      
//         const dummyData = [
//             {
//                 Sr_No: 1,
//                 Order_Number: "ORD001",
//                 Indent_Number: "IND001",
//                 Date: "2024-06-28",
//                 Client_Name: "Client A",
//                 Plant_Name: "Plant X",
//                 Blade_Qty: '<span class="label label-success">100</span>',
//                 Received_Qty: '<span class="label custome-received">90</span>', 
//                 Action: '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>',
//             },
//             {
//                 Sr_No: 2,
//                 Order_Number: "ORD002",
//                 Indent_Number: "IND002",
//                 Date: "2024-06-27",
//                 Client_Name: "Client B",
//                 Plant_Name: "Plant Y",
//                 Blade_Qty: '<span class="label label-success">150</span>',
//                 Received_Qty: '<span class="label custome-received">120</span>', 
//                 Action: '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>',
//             },
//             {
//                 Sr_No: 3,
//                 Order_Number: "ORD003",
//                 Indent_Number: "IND003",
//                 Date: "2024-06-26",
//                 Client_Name: "Client C",
//                 Plant_Name: "Plant Z",
//                 Blade_Qty: '<span class="label label-success">200</span>',
//                 Received_Qty: '<span class="label custome-received">180</span>', 
//                 Action: '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>',
//             },
//             {
//                 Sr_No: 4,
//                 Order_Number: "ORD004",
//                 Indent_Number: "IND004",
//                 Date: "2024-06-25",
//                 Client_Name: "Client D",
//                 Plant_Name: "Plant W",
//                 Blade_Qty: '<span class="label label-success">120</span>',
//                 Received_Qty: '<span class="label custome-received">100</span>', 
//                 Action: '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>',
//             },
//             {
//                 Sr_No: 5,
//                 Order_Number: "ORD005",
//                 Indent_Number: "IND005",
//                 Date: "2024-06-24",
//                 Client_Name: "Client E",
//                 Plant_Name: "Plant V",
//                 Blade_Qty: '<span class="label label-success">180</span>',
//                 Received_Qty:  '<span class="label custome-received">160</span>', 
//                 Action: '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>',
//             },
//         ];
        
      
  
//       bladeindent = $("#tblBalajiPlant").DataTable({
//         dom: 'fl<"topbutton">tip',
//         oLanguage: {
//           sProcessing: '<div class="dt-loader"></div>',
//         },
//         processing: true,
//         searching: true,
//         destroy: true,
//         pageLength: 25,
//         order: [[1, "asc"]],
//         data: dummyData,
//         columnDefs: [{ responsivePriority: 1, targets: 7 }],
//         columns: [
//           {
//             data: "Sr_No",
//             width: "10%",
//             title: "Sr. No.",
//             orderable: false,
//             render: function (data, type, row, meta) {
//               return `<span>${data}</span> <i class="fas fa-plus-circle plus-icon" data-index="${meta.row}"></i>`;
//             },
//           },
//           { data: "Indent_Number", width: "15%", title: "Indent No" },
//           { data: "Order_Number", width: "15%", title: "Order No" },
//           { data: "Date", width: "15%", title: "Date" },
//           { data: "Client_Name", width: "20%", title: "Customer Name"},
//           { data: "Plant_Name", width: "30%", title: "Plant Name" },
//           { data: "Blade_Qty", width: "10%", title: "Blade Qty." },
//           { data: "Received_Qty", width: "10%", title: "Received Qty" }, // New column for Received Qty
//           {
//             data: "Action",
//             width: "15%",
//             title: "Action",
//             orderable: false,
//             className: "text-center",
//           },
//         ],
//       });
  
//       $("#tblBalajiPlant").on("click", ".plus-icon", function () {
//         $("#details").show();
//         var rowIndex = $(this).data("index");
//         var row = bladeindent.row(rowIndex).data();
//         var bladeQty = row.Blade_Qty;
//         var receivedQty = row.Received_Qty;
//         var Order_Number = row.Order_Number;
  
//         $("#b_qt").text(bladeQty);
//         $("#received_qty").text(receivedQty); 
//         $("#indent_no").text(Order_Number); 
  
//         $(".create").hide();
//         $(".hand").hide();
//         $(".position").hide();
//         $(".remark").hide();
//         $(".added_by").hide();
//         $("#select_stage").change(function () {
//           let stage = $("#select_stage").val();
//           if (stage == "Created") {
//             $(".position").hide();
//             $(".hand").hide();
//             $(".create").show();
//             $(".remark").show();
//             $(".added_by").show();
//           } else if (stage == "Hand") {
//             $(".create").hide();
//             $(".position").hide();
//             $(".hand").show();
//             $(".remark").show();
//             $(".added_by").show();
//           } else if (stage == "Position") {
//             $(".hand").hide();
//             $(".create").hide();
//             $(".position").show();
//             $(".remark").show();
//             $(".added_by").show();
//           }
//         });
//       });
//     }
  
//     listReceivedOrders();
//   });
  
$(document).ready(function () {
    var bladeindent = ""; // Initialize variable
    $("#details").hide();

    function listReceivedOrders() {
        const dummyData = [
            {
                Sr_No: 1,
                Indent_Number: "IND001",
                Created: "2024-06-28",
                Blade_in_Hand: '<span class="label label-success">100</span>',
                Blade_Position: '<span class="label custome-received">90</span>',
            },
            {
                Sr_No: 2,
                Indent_Number: "IND002",
                Created: "2024-06-27",
                Blade_in_Hand: '<span class="label label-success">150</span>',
                Blade_Position: '<span class="label custome-received">120</span>',
            },
            {
                Sr_No: 3,
                Indent_Number: "IND003",
                Created: "2024-06-26",
                Blade_in_Hand: '<span class="label label-success">200</span>',
                Blade_Position: '<span class="label custome-received">180</span>',
            },
            {
                Sr_No: 4,
                Indent_Number: "IND004",
                Created: "2024-06-25",
                Blade_in_Hand: '<span class="label label-success">120</span>',
                Blade_Position: '<span class="label custome-received">100</span>',
            },
            {
                Sr_No: 5,
                Indent_Number: "IND005",
                Created: "2024-06-24",
                Blade_in_Hand: '<span class="label label-success">180</span>',
                Blade_Position: '<span class="label custome-received">160</span>',
            },
        ];

        bladeindent = $("#tblBalajiPlant").DataTable({
            dom: 'fl<"topbutton">tip',
            oLanguage: {
                sProcessing: '<div class="dt-loader"></div>',
            },
            processing: true,
            searching: true,
            destroy: true,
            pageLength: 25,
            order: [[2, "asc"]], // Sort by the 'Created' column (index 2) by default
            data: dummyData,
            columnDefs: [{ responsivePriority: 1, targets: 6 }], // Adjusted for 6 columns
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
                { data: "Indent_Number", width: "15%", title: "Indent No" },
                { data: "Created", width: "15%", title: "Created" },
                { data: "Blade_in_Hand", width: "20%", title: "Blade in Hand" },
                { data: "Blade_Position", width: "20%", title: "Blade Position" },
                {
                    data: null,
                    width: "10%",
                    title: "Action",
                    orderable: false,
                    render: function (data, type, row) {
                        return '<button class="btn btn-primary btn-sm" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                    },
                    className: "text-center",
                },
            ],
        });

        $("#tblBalajiPlant").on("click", ".plus-icon", function () {
            $("#details").show();
            var rowIndex = $(this).data("index");
            var row = bladeindent.row(rowIndex).data();
            var bladeQty = row.Blade_in_Hand;
            var receivedQty = row.Blade_Position;
            var Indent_Number = row.Indent_Number;

            // $("#b_qt").html(bladeQty);
            // $("#received_qty").html(receivedQty);
            $("#indent_no").html(Indent_Number);

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
  