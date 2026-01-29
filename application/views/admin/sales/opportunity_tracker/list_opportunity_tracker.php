<?php  init_header(); ?>
<style>._status{cursor: pointer;}
   th, td {
   white-space: nowrap !important;
   }
   .btn-sm{
      background: whitesmoke !important;
      border: 1px solid #959595 !important;
      /*color: red !important;*/
   }

     .select2-selection{
    height: 37px !important;
    
  }
  .no_margin_bottom{
   margin-bottom: 0rem !important;
   }
   .dataTables_filter{
       margin-top:0px !important;
   }
   
   .dataTables_length{
       margin-top:0px !important;
   }
    label{
       margin-bottom: 0.2rem;
    }
    .text_wrap{
         word-wrap: break-word !important;
    }
    td{
        word-wrap: break-word !important;
    }
    .select2-selection--single{
      height: 27px !important;
    }
    .status_size{
      font-size:15px;
    }
</style>


<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-5">
                  <h4 class="card-title">Opportunity Tracker</h4>
               </div>
               <div class="col-md-7 align-self-center text-right d-none d-md-block">
                  <a class="btn btn-info btn-theme opp_tracker_modal" data-toggle="modal" data-target="#opp_tracker_modal" ><i class="fa fa-plus-circle"></i>Add Opportunity</a>
               </div>

            </div>


            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-3"></div>
                     <!-- select dropdown start-->
                     <div class="col-md-2">
                        <label>Customer Name</label>
                        <select class="form-control select2 did-floating-select customerid"  id="customerid"   name="cust_idd" value="" onchange="opp_tracker_filter()">
                           <option value="all" selected>All</option>

                        </select>


                     </div>
                     <div class="col-md-2">
                        <label>Plant Name</label>
                        <select class="form-control select2 did-floating-select plant_name_idd"  id="plant_id"   name="plant_idd" value="" onchange="opp_tracker_filter()">
                           <option value="all" selected>All</option>
                        </select>
                     </div>


                     <div class="col-md-2">
                        <label>Status</label>
                        <select class="form-control select2 did-floating-select status_id"  id="status_id"   name="status_id" value="" onchange="opp_tracker_filter()">
                           <option value="all">All</option>
                           <option value="<?= OPPORTUNITY_STATUS_INPROCESS ?>">In-Process</option>
                           <option value="<?= OPPORTUNITY_STATUS_COMPLETE ?>">Complete</option>
                        </select>
                     </div>

                     <!-- end -->
                     <div class="col-md-3 text-right"></div>

                  </div>
               </div>    
            </div>

            <div class="row" style="margin-top:5px">

               <div class="col-md-3"></div>

               <div class="col-md-6 text-center d-none d-md-block">
                  <button class="status_size in_process" style="background: #ff9041;color:whitesmoke;border:#48bc97 1px solid;display: none;"><b>In-process :- &nbsp;&nbsp;<span class="total_count"></span></b>
                  </button>
                  
                  <button class="status_size complete" style="background: #48bc97;color:whitesmoke;border: #48bc97 1px solid;display: none;"><b>Complete :- &nbsp;&nbsp;<span class="total_count"></span></b>
                  </button>

                  <button class="status_size all_count" style="background: #ffffff;border: #48bc97 1px solid;"><b>All Opportunity :- &nbsp;&nbsp;<span class="total_count"></span></b>
                  </button>
               </div>

                <div class="col-md-3 text-right d-none d-md-block">
                <!--   <button class="status_size " style="background: #ffffff;border: #48bc97 1px solid;"><b>All Opportunity :- &nbsp;&nbsp;<span class=""><?= $total_status_cnt;?></span></b>
                  </button> -->


                  <button class="status_size " style="background: #ff9041;color:whitesmoke;border:#48bc97 1px solid;"><b>In-process :- &nbsp;&nbsp;<span class=""><?= $inprocess_status_cnt;?></span></b>
                  </button>
                  
                  <button class="status_size " style="background: #48bc97;color:whitesmoke;border: #48bc97 1px solid;"><b>Complete :- &nbsp;&nbsp;<span class=""><?= $complete_status_cnt;?></span></b>
                  </button>

                </div>
            </div>




            <div class="table-responsive">
               <table id="tbl_opp_tracker" class="table display table-bordered text-center" width="100%">
               </table>
            </div>
           
         </div>
      </div>
   </div>
</div>
<div id="opp_tracker_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_opp_tracker"></div>
      </div>
   </div>
</div>

<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/sales/opportunity_tracker.js"></script>

 <script> 
        $('.status_id').on('change', function () { 
         var status = $('.status_id').val();
            
            if (status == <?= OPPORTUNITY_STATUS_INPROCESS ?>) { 
               $('.in_process').show(); 
               $('.complete').hide(); 
               $('.all_count').hide(); 
            } 
            else if (status == <?= OPPORTUNITY_STATUS_COMPLETE ?>) { 
               $('.in_process').hide(); 
               $('.complete').show(); 
               $('.all_count').hide();
            }else {
               $('.in_process').hide(); 
               $('.complete').hide(); 
               $('.all_count').show();
            } 
            
        }); 





        
    </script> 

