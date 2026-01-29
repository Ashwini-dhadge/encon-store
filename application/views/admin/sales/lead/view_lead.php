<?php  init_header(); ?>
<link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet">
<style>._status{cursor: pointer;}
   th, td {
   /*      font-size: 34px;*/
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
   /*  label{
   margin-bottom: 0.2rem;
   }*/
   .text_wrap{
   word-wrap: break-word !important;
   }
   td{
   word-wrap: break-word !important;
   }
   /*24-01*/
   b,strong, p.text-muted{
   color:#455a64 !important;
   }
   .sl-date{
   font-size: 14px !important;
   color:#455a64 !important;
   }
   hr{
   margin-top:5px;
   margin-bottom:5px;
   }
   .slleft{
   margin-left: -85px !important;
   height: 20px;
   background: #48bc97;
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
                  <h6 class="card-title"><strong>Lead Information</strong></h6>
                  <input type="hidden" name="id" id="id" value="<?= isset($id)? $id : '' ?>">
                  <input type="hidden" name="id" id="id" value="<?= isset($follow_up[0]['id'])?  $follow_up[0]['id'] : '' ?>">
                 
               </div>
               <div class="col-md-7 text-right m-b-10">
                  <a class="btn btn-primary waves-effect waves-light btn-sm lead_follow_up_modal "data-toggle="tooltip" onclick="lead_follow_up_modal()" style="font-size:13px;background:#F0F0F0;color: gray;"  data-id="<?= $id;?>"><i class="fa fa-plus-circle"></i>Add Follow Up</a>
               </div>
               <div class="col-lg-12 col-xlg-12 col-md-12">
                  <div class="card" style="font-size:13px">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item">
                           <?php
                              $is_follwuo_add = $this->session->flashdata('is_follwuo_add');
                              if(isset($is_follwuo_add) && $is_follwuo_add==1){
                                  $is_follwuo_add=1;
                              }else{
                                   $is_follwuo_add=0;
                              }
                              ?>
                           <a class="nav-link <?= ($is_follwuo_add==0)?'active':''; ?>" data-toggle="tab" href="#profile" role="tab" style="padding: 0px 20px;">
                              <h6 class="card-title"><strong>Profile</strong></h6>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link " data-toggle="tab" href="#home" role="tab" style="padding: 0px 20px;">
                              <h6 class="card-title"><strong>Follow Up</strong></h6>
                           </a>
                        </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content">
                        <div class="tab-pane <?= ($is_follwuo_add==1)?'active':''; ?>" id="home" role="tabpanel">
                           <div class="row">
                              <div class="col-md-1"></div>
                              <div class="card-body" style="padding-bottom: 0px;">
                                 <div class="profiletimeline">
                                    <?php foreach ($follow_up_data as $value): ?>
                                    <div class="row ">
                                       <div class="col-md-10 sl-item">
                                          <div class="sl-left slleft"><strong>
                                             <?php
                                                $newDate = date("d F Y", strtotime($value['date']));
                                                echo $newDate;
                                                ?>
                                             </strong>
                                          </div>
                                          <div class="sl-right">
                                             <div >
                                                <span class="sl-date"><strong>
                                                <?php
                                                   $time = date("h:i A", strtotime($value['date']));
                                                   echo $time;?></strong>
                                                </span>
                                                <span class="sl-date" style="float:right;"> <a href="javascript:void(0);" 
                                                   title="Edit" 
                                                   class="btn btn-primary waves-effect waves-light btn-sm editModal" 
                                                   data-toggle="tooltip" 
                                                   style="font-size:13px;background:#48bc97 !important;border: 1px solid #48bc97 !important;transition: 0.2s ease-in;color: #fff !important;" 
                                                   onclick="lead_follow_up_modal(<?= $value['id'] ?>)" 
                                                   data-id="<?= $value['id'] ?>" >
                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a></span>
                                                <div class="row m-t-5">
                                                   <div class="col-md-10 m-t-5">
                                                      <div class="row m-t-5">
                                                         <div class="col-md-3 col-xs-6 m-t-5">
                                                            <h6 class=""><b>Title:</b></h6>
                                                         </div>
                                                         <div class="col-md-9 col-xs-6">
                                                            <span><?php echo $value['title']; ?></span>
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                            <h6 class=""><strong>Contact Person Name:</strong></h6>
                                                         </div>
                                                         <div class="col-md-3 col-xs-6"> 
                                                            <span><?php echo $value['contact_person_name']; ?></span>
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                            <span>
                                                               <h6 class=""><strong>Contact Person Mobile No:</strong></h6>
                                                            </span>
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                            <span><?php echo $value['contact_person_mobile_no']; ?></span>
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                         </div>
                                                         <div class="col-md-3 col-xs-6">
                                                         </div>
                                                         <?php if($value['lead_add_reminder'] == 1) {?>
                                                         <div class="col-md-3 col-xs-6">
                                                            <span>
                                                               <h6 class=""><strong>Follow Up On:</strong></h6>
                                                            </span>
                                                         </div>
                                                         <?php foreach ($reminder_data[$value['id']] as $reminder) {?>
                                                         <div class="col-md-3 col-xs-6"> 
                                                            <span><?php 
                                                               $timestamp = strtotime($reminder['start_date_time']);
                                                               
                                                               
                                                               $formattedDate = date("j F Y h:i A", $timestamp);
                                                               
                                                               
                                                               echo $formattedDate;?>
                                                            </span>
                                                         </div>
                                                         <?php }?>
                                                         <?php } else { ?>
                                                         <div class="col-md-3 col-xs-6"> 
                                                            <span></span>
                                                         </div>
                                                         <?php } ?>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-12">
                                                      <h6 class="card-title m-t-5"><strong>Description:</strong></h6>
                                                      <blockquote class="m-t-5">
                                                         <?php echo $value['description']; ?>
                                                      </blockquote>
                                                      <span></span>
                                                   </div>
                                                   <div class="col-md-12 col-md-3 col-xs-6">
                                                      <h6 class=""style="float:right;"><strong>Created By:</strong><?php foreach ($user_data as $user): ?>
                                                         <span style="font-size: 13px;"><?php echo $user['first_name']; ?>&nbsp;<?php echo $user['last_name']; ?></span>
                                                         <?php endforeach; ?>
                                                      </h6>
                                                   </div>
                                                   <div class="col-md-12 col-md-3 col-xs-6">
                                                      <h6 class=""style="float:right;"><strong>Created Date:</strong> <span style="font-size: 13px;"><?php $created_at = $value['created_at'];
                                                         $theDate = $value['created_at'];
                                                         $d1 = new DateTime($theDate);
                                                         $create_date = $d1->diff(new DateTime())->days;
                                                         echo $create_date+1;   ?> Days Ago 
                                                         </span>
                                                      </h6>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php endforeach; ?>
                                 </div>
                              </div>
                              <div class="col-md-1"></div>
                           </div>
                        </div>
                        <!--second tab-->
                        <div class="tab-pane <?= ($is_follwuo_add==0)?'active':''; ?>" id="profile" role="tabpanel">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-5">
                                    <h6 class="card-title pl-1"><strong>Lead Information</strong></h6>
                                 </div>
                                 <div class="col-md-7 align-self-center text-right d-none d-md-block">
                                    <!-- <button type="button" class="btn btn-info btn-theme " onclick="ConvertToCustomerData()" >
                                       Convert To Customer</button> -->
                                    <?php
                                       $showButton = true;
                                       foreach ($status as $item){
                                           if ($item['status'] == 'Complete') {
                                               $showButton = false;
                                               break;
                                           }
                                       }
                                       ?>
                                    <?php if ($showButton): ?>
                                    <button type="button" class="btn btn-info btn-theme" onclick="ConvertToCustomerData()">Convert To Customer</button>
                                    <?php endif; ?>
                                    <button class="btn btn-info btn-theme dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                                    <div class="dropdown-menu" >
                                       <a class="dropdown-item" href="javascript:void(0)" >Mark as lost</a>
                                       <a class="dropdown-item" href="javascript:void(0)">Mark as junk</a>
                                       <a class="dropdown-item" href="javascript:void(0)">Delete Lead</a>
                                    </div>
                                    <button type="button" href="<?= base_url('admin/sales/Lead');?>" class="btn btn-info btn-theme leadModal" data-toggle="leadModal" data-target="#leadModal" data-id="<?= $id ?>" >
                                    Edit&nbsp;<i class="fas fa-edit" aria-hidden="true"></i></button>
                                   
                                 </div>
                              </div>
                              <hr>
                              <div class="row ">
                                 <div class="col-md-12">
                                    <div class="row" style="margin-top:10px;">
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Name</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted" id="name" ><?= (isset($name))? $name : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Position</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted"><?= (isset($position))? $position : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Email</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted email" ><?= (isset($email))? $email : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Website</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted"><?= (isset($website))? $website : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Phone</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted phone"><?= (isset($phone))? $phone : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Company</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted company" ><?= (isset($company))? $company : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Address</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted address"> <?= (isset($address))? $address : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Country</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted country"> <?= $country_data[0]['name'] ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Zipcode</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted zipcode"><?= (isset($zipcode))? $zipcode : '' ?></p>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <strong>Description</strong>
                                       </div>
                                       <div class="col-md-2 col-xs-6 ">
                                          <p class="text-muted"><?= (isset($description))? $description : '' ?></p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <hr>
                              <div class="row">
                                 <h6 class="card-title pl-3"><strong>General Information</strong></h6>
                              </div>
                              <hr>
                              <div class="row" style="margin-top:10px;">
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Lead Status</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= $status[0]['status'] ?></p>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Source</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= $source[0]['name'] ?></p>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Assigned</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= $assigned[0]['first_name'] . ' ' . $assigned[0]['last_name'] ?></p>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Created</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= (isset($created_at))? $created_at : '' ?></p>
                                 </div>
                              </div>
                              <hr>
                              <div class="row">
                                 <h6 class="card-title pl-3"><strong>Custom Fields</strong></h6>
                              </div>
                              <hr>
                              <div class="row" style="margin-top:10px;">
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Requirments</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= (isset($requirement))? $requirement : '' ?></p>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <strong>Comments</strong>
                                 </div>
                                 <div class="col-md-2 col-xs-6 ">
                                    <p class="text-muted"><?= (isset($comment))? $comment : '' ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Column -->
            </div>
         </div>
      </div>
   </div>
</div>
<div id="leadModal" class="modal fade bd-example-modal-lg" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_banner"></div>
      </div>
   </div>
</div>
<div id="lead_follow_up_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_follow_up"></div>
      </div>
   </div>
</div>
<?php  init_footer(); ?>
<!-- Horizontal-timeline JavaScript -->
<script src="<?= base_url()?>/assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/sales/lead.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script><script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
<script>
   $(document).ready(function() {
       // Function to open lead modal for editing
       $('.leadModal').click(function() {
           var lead_id = $(this).data('id');
           // AJAX call to load lead data into the modal
           $.ajax({
               url:base_url +'admin/sales/Lead/leadModal',
               type: 'POST',
               data: {id: lead_id},
               dataType: 'json',
               success: function(response) {
                   if(response.result) {
                       // Load the modal content with the response HTML
                       $('#leadModal .modal-content').html(response.html);
                       $('#leadModal').modal('show'); // Show the modal
                   } else {
                       alert(response.reason); // Show error message if any
                   }
               },
               error: function(xhr, status, error) {
                   console.error(xhr.responseText);
               }
           });
       });
   });
</script>
<script>
   function ConvertToCustomerData($id='') {
       var id = $('#id').val();
       
       var company = $('.company').text();
        var address = $('.address').text();
        var phone = $('.phone').text();
        var email = $('.email').text();
        var country = $('.country').text();
        var zipcode = $('.zipcode').text();
         
       
      
       const swalWithBootstrapButtons = Swal.mixin({
           customClass: {
               confirmButton: 'btn btn-success',
               cancelButton: 'mr-2 btn btn-danger'
           },
           buttonsStyling: false,
       });
   
       swalWithBootstrapButtons.fire({
           title: 'Are you sure?',
           text: "Do you want to Convert To Customer!",
           type: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Yes!',
           cancelButtonText: 'cancel!',
           reverseButtons: true
       }).then((result) => {
           if (result.value) {
   
               $.ajax({
                
                   url:base_url +'admin/sales/Customer/add_customer_lead_convert',  
                   method: 'POST',
                  
                   data: {
                       'id': id,
                       'company_name': company,
                       'address': address,
                       'phone': phone,
                       'email': email,
                       'country': country,
                       'zipcode': zipcode,
                        'lead_cust_convert': 1
   
                   },
                   success: function(response) {
                       document.open();
                       document.write(response);
                       document.close();
                   },
                   error: function(xhr, status, error) {
                       swalWithBootstrapButtons.fire(
                           'Error!',
                           'Failed to convert customer. Please try again later.',
                           'error'
                       );
                   }
               });
           } else if (result.dismiss === Swal.DismissReason.cancel) {
               swalWithBootstrapButtons.fire(
                   'Cancelled',
                   'Your imaginary file is safe :)',
                   'error'
               );
           }
       });
   }
</script>