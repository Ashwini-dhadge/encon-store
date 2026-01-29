<?php  init_header(); ?>

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
   b,strong, p.text-muted, span.text-muted{
    color:#455a64 !important;
   }

   .sl-date{
    font-size: 14px !important;
    color:#455a64 !important;
   }

   .size_text, strong{
    font-size: 13px !important;
   }

   hr{
    margin-top:5px;
    margin-bottom:5px;
   }

   .slleft{
      margin-left: -85px !important;
      height: 20px;
/*      background: #48bc97;*/
   }
   .dot {
      height: 25px;
      width: 25px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
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
                  <h4 class="card-title"><strong>Opportunity Tracker Information</strong></h4>
                  

               </div>
               <div class="col-md-7 text-right m-b-10">
                  <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn-sm"data-toggle="tooltip" style="font-size:13px;background:#F0F0F0;color: gray;" onclick="opp_tracker_modal(<?= $opportunity_data['id'];?>,<?= OPPORTUNITY_TYPE_ONE ?>)" data-id="<?= $opportunity_data['id'];?>" ><i class="fa fa-plus-circle"></i> Add </a>
               </div>  
                <div class="col-lg-12 col-xlg-12 col-md-12">
                    <div class="card" style="font-size:13px">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs profile-tab" role="tablist">
                          <?php if($redirect_type == OPPORTUNITY_TYPE_FOUR){?>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" style="padding: 0px 20px;"><h6 class="card-title"><strong>Tracker Information</strong></h6></a> </li>
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="padding: 0px 20px;"><h6 class="card-title"><strong>Timeline</strong></h6></a> </li>
                            <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a> </li> -->
                          <?php }else{ ?>
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" style="padding: 0px 20px;"><h6 class="card-title"><strong>Tracker Information</strong></h6></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#home" role="tab" style="padding: 0px 20px;"><h6 class="card-title"><strong>Timeline</strong></h6></a> </li>
                          <?php } ?>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                          <?php if($redirect_type == OPPORTUNITY_TYPE_FOUR){?>
                              <div class="tab-pane active" id="home" role="tabpanel">
                          <?php }else{?>
                               <div class="tab-pane" id="home" role="tabpanel">
                          <?php } ?>
                            
                              
                                <div class="row card">
                                  <div class="card-body" style="padding-bottom: 0px;">
                                      <div class="profiletimeline">
                                      
                                      <?php if(isset($opportunity_data['dates'])) { ?>
                                        <?php  foreach ($opportunity_data['dates'] as $key => $value) { ?>     
                                          <div class="row card-body" style="padding: 0px;background: whitesmoke;margin-bottom: 10px;border-radius: 15px;">
                                            <div class="col-9 sl-item b-r">
                                              <div class="sl-left slleft"><strong>

                                                <span><i class=" far fa-dot-circle" style="font-size: 18px;color: #48bc97;margin-left: 35px;"></i></span>
                                                <!-- <//?php
                                                  $newDate = date("d F Y", strtotime($value['date']));
                                                  echo $newDate;?> -->
                                                </strong>
                                              </div>
                                              <div class="sl-right">
                                                  <div >
                                                    <span class="sl-date"><strong>
                                                      <!-- <//?php
                                                        $time = date("h:i A", strtotime($value['date']));
                                                        echo $time;
                                                      ?> -->
                                                        
                                                    </strong>
                                                    </span>
                                                    <?php  foreach ($value['date_wise_data'] as $key1 => $val1) { ?>
                                                      <!-- <div class="col-12" style="text-align: right;">
                                                        <input type="hidden" value="<?= $val1['id']?>">
                                                        <input type="hidden" value="<?= $val1['opp_tracker_id']?>">
                                                        <span id="refresh_flag_<?= $val1['id'];?>">
                                                          <?php if($val1['is_favourite'] == 1){?>
                                                            <a class="btn-theme" onclick="changeFavouriteFlag(<?= $val1['id'] ?>,0)"   title="Remove techinal flag"><i class=" fas fa-bookmark"></i></a>
                                                          <?php }else{?>
                                                            <a class="btn-theme" onclick="changeFavouriteFlag(<?= $val1['id'] ?>,1)"  title="Add techinal flag" ><i class=" far fa-bookmark"></i></a> 
                                                          <?php } ?>
                                                        </span>
                                                        <a href="javascript:void(0);" class="btn-theme" data-toggle="tooltip" onclick="opp_tracker_modal(<?= $val1['id'];?>,<?= OPPORTUNITY_TYPE_THREE ?>)" data-id="<?= $val1['id'];?>" ><i class="fas fa-edit"></i></a>
                                                      </div> -->


                                                      <div class="row ">
                                                        <div class="col-md-10">
                                                          <div class="row">
                                                            <div class="col-md-3 col-xs-6 m-t-5">
                                                                <h6 class=""><b>Title</b></h6>
                                                            </div>
                                                            <div class="col-md-8 col-xs-6">
                                                                <h6 class="card-title m-t-5"><strong><?= isset($val1['title'])?$val1['title']:'';?></strong></h6>
                                                            </div>
                                                            <div class="col-md-3 col-xs-6">
                                                                <h6 class=""><strong>Contact Person Name</strong></h6>
                                                            </div>
                                                            <div class="col-md-3 col-xs-6"> 
                                                                <span><?= isset($val1['contact_person_name'])?$val1['contact_person_name']:'';?></span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-6">
                                                                <span><h6 class=""><strong>Contact Person Mobile No</strong></h6></span>
                                                            </div>
                                                            <div class="col-md-3 col-xs-6"> 
                                                                <span><?= isset($val1['contact_person_mobile_no'])?$val1['contact_person_mobile_no']:'';?></span>
                                                            </div>

                                                          <?php
                                                            if(! empty($val1['start_date_time'])){ ?>
                                                              <div class="col-md-3 col-xs-6">
                                                                  <span><h6 class=""><strong>Follow Up On</strong></h6></span>
                                                              </div>
                                                              <div class="col-md-3 col-xs-6"> 
                                                                <?php
                                                                  if(! empty($val1['start_date_time'])){

                                                                   $start_date = date("j M Y", strtotime($val1['start_date_time']));
                                                                  
                                                                   $start_time = date("h:i A", strtotime($val1['start_date_time']));

                                                                   echo  '<span class="text-muted">'."$start_date".'</span>'; 
                                                                   // echo  '<span class="text-muted">'."$start_date".' '."$start_time".'</span>'; 
                                                                  }
                                                                ?>
                                                                <?php  
                                                                  if(! empty($val1['end_date_time'])){
                                                                   $end_date = date("j M Y", strtotime($val1['end_date_time']));
                                                                  
                                                                   $end_time = date("h:i A", strtotime($val1['end_date_time']));
                                                                  
                                                                     echo  ' to <span class="text-muted">'."$end_date".'</span>'; 
                                                                   // echo  'to <span class="text-muted">'."$end_date".' '."$end_time".'</span>'; 
                                                                  }
                                                                ?>
                                                                
                                                              </div>
                                                          <?php } ?>

                                                          <?php
                                                            if(! empty($val1['plant_narration'])){ ?>
                                                              <div class="col-md-3 col-xs-6">
                                                                  <span><h6 class=""><strong>Plant Name</strong></h6></span>
                                                              </div>
                                                              <div class="col-md-3 col-xs-6"> 
                                                                <?php
                                                                  if(! empty($val1['plant_narration'])){?>
                                                                    <span><?= isset($val1['plant_narration'])?$val1['plant_narration']:'';?></span>
                                                                <?php  } ?>
                                                              </div>
                                                          <?php } ?>
                                                            




                                                          </div>
                                                        </div>


                                                        <div class="col-2" style="text-align: right;">
                                                          <input type="hidden" value="<?= $val1['id']?>">
                                                          <input type="hidden" value="<?= $val1['opp_tracker_id']?>">
                                                          <span id="refresh_flag_<?= $val1['id'];?>">
                                                            <?php if($val1['is_favourite'] == 1){?>
                                                              <a class="btn-theme" onclick="changeFavouriteFlag(<?= $val1['id'] ?>,0)"   title="Remove techinal flag"><i class=" fas fa-bookmark"></i></a>
                                                            <?php }else{?>
                                                              <a class="btn-theme" onclick="changeFavouriteFlag(<?= $val1['id'] ?>,1)"  title="Add techinal flag" ><i class=" far fa-bookmark"></i></a> 
                                                            <?php } ?>
                                                          </span>
                                                          <a href="javascript:void(0);" class="btn-theme" data-toggle="tooltip" onclick="opp_tracker_modal(<?= $val1['id'];?>,<?= OPPORTUNITY_TYPE_THREE ?>)" data-id="<?= $val1['id'];?>" ><i class="fas fa-edit"></i></a>
                                                        </div>

                                                        
                                                        <div class="col-md-12">
                                                          <h6 class="card-title m-t-5"><strong>Description</strong></h6>
                                                            <blockquote class="m-t-5">
                                                              <?= isset($val1['description'])?$val1['description']:''; ?>
                                                            </blockquote>
                                                        </div>
                                                      </div>
                                                    <?php } ?>

                                                    <div class="col-12" style="text-align: right;">
                                                      <span><h6 style="margin-bottom: 2px;"><strong>Created by :- <?= $val1['created_by_name'].'.';?></strong></h6></span>
                                                      <span><h6 style="margin-bottom: 10px;">
                                                        <strong>Created at :- 
                                                          <?php 
                                                              echo  '&nbsp;&nbsp;'.time_elapsed_string(($val1['date']));

                                                          // $created_at = date("d F Y, h:i A ", strtotime($val1['date']));
                                                          //     echo $created_at.'.';

                                                            ?>
                                                        </strong></h6>
                                                      </span>
                                                    </div>
                                                  </div>
                                              </div>
                                            </div>
                                           
                                            <?php if(! empty($val1['opp_sub_attachment_file'])){?>    
                                              <div class="col-3" style="padding-top: 15px;">
                                                  <h6 class="card-title m-t-10"><strong>Attchements</strong></h6>
                                                  <div class="m-t-10">
                                                    <div class="">
                                                        <div class="" style="margin-top:;">
                                                          <?php foreach($val1['opp_sub_attachment_file'] as $key5=>$val5){?>
                                                            <div class="col-md-12 col-xs-12" style="padding:0px">
                                                                <p class="text-muted"><?= $key5+1;?>. <a href="<?= base_url(OPPORTUNITY_TRACKER_IMAGE);?><?= $val5['file_name'];?>" target="_blank"><?= isset($val5['file_name'])?$val5['file_name']:'';?></a></p>
                                                            </div>
                                                          <?php } ?>
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>
                                            <?php } ?>
                                             
                                          </div> 
                                        <?php } ?>
                                      <?php } ?>




                                      <div class="row card-body" style="padding: 0px;background: whitesmoke;margin-bottom: 10px;border-radius: 15px;">
                                        
                                        <div class="col-9 sl-item b-r">
                                          <div class="sl-left slleft"><strong>
                                              <!-- <//?php
                                                $newDate = date("d F Y", strtotime($opportunity_data['date']));
                                                echo $newDate;?> -->
                                                  <span><i class=" far fa-dot-circle" style="font-size: 18px;color: #48bc97;margin-left: 35px;"></i></span>  
                                                </strong>
                                          </div>
                                          <div class="sl-right">
                                            <div>
                                              <span class="sl-date"><strong>
                                                <!-- <//?php
                                                  $time = date("h:i A", strtotime($opportunity_data['date']));
                                                  echo $time;?> -->
                                                    
                                                  </strong>
                                              </span>
                                              <div class="row ">
                                                <div class="col-md-10">
                                                  <div class="row">
                                                    <div class="col-md-3 col-xs-6 m-t-5">
                                                        <h6 class=""><b>Title</b></h6>
                                                    </div>
                                                    <div class="col-md-9 col-xs-6">
                                                        <h6 class="card-title m-t-5"><strong><?= isset($opportunity_data['title'])?$opportunity_data['title']:'';?></strong></h6>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6">
                                                        <h6 class=""><strong>Contact Person Name</strong></h6>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6"> 
                                                        <span><?= isset($opportunity_data['contact_person_name'])?$opportunity_data['contact_person_name']:'';?></span>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6">
                                                        <span><h6 class=""><strong>Contact Person Mobile No</strong></h6></span>
                                                    </div>
                                                    <div class="col-md-3 col-xs-6"> 
                                                        <span><?= isset($opportunity_data['contact_person_mobile_no'])?$opportunity_data['contact_person_mobile_no']:'';?></span>
                                                    </div>
                                                    <?php if($reminder_dt){?>   
                                                      <div class="col-md-3 col-xs-6">
                                                          <span><h6 class=""><strong>Follow Up On</strong></h6></span>
                                                      </div>
                                                      <div class="col-md-3 col-xs-6"> 
                                                          <?php
                                                            if(! empty($reminder_dt[0]['start_date_time'])){
                                                             $start_date = date("j M Y", strtotime($reminder_dt[0]['start_date_time']));
                                                            
                                                             $start_time = date("h:i A", strtotime($reminder_dt[0]['start_date_time']));

                                                             echo  '<span class="text-muted">'."$start_date".'</span>'; 
                                                             // echo  '<span class="text-muted">'."$start_date".' '."$start_time".'</span>'; 
                                                            }
                                                          ?>
                                                          <?php  
                                                            if(! empty($reminder_dt[0]['end_date_time'])){
                                                              $end_date = date("j M Y", strtotime($reminder_dt[0]['end_date_time']));
                                                            
                                                              $end_time = date("h:i A", strtotime($reminder_dt[0]['end_date_time']));
                                                            
                                                              echo  ' to <span class="text-muted">'."$end_date".'</span>'; 
                                                             // echo  'to <span class="text-muted">'."$end_date".' '."$end_time".'</span>'; 
                                                            }
                                                             
        
                                                           ?>
                                                        
                                                      </div>
                                                    <?php } ?>

                                                    <?php if($plant_dt){?>   
                                                      <div class="col-md-3 col-xs-6">
                                                          <span><h6 class=""><strong>Plant Name</strong></h6></span>
                                                      </div>
                                                      <div class="col-md-3 col-xs-6"> 
                                                          <?php
                                                            if(! empty($plant_dt[0]['plant_narration'])){?>
                                                              <span><?= isset($plant_dt[0]['plant_narration'])?$plant_dt[0]['plant_narration']:'';?></span>
                                                          <?php  } ?>
                                                      </div>                                                      
                                                    <?php } ?>

                                                  </div>
                                                </div>


                                                <div class="col-2" style="text-align: right;">
                                                  <input type="hidden" value="<?= $opportunity_data['id']?>">
                                                  
                                                  <span id="refresh_flag_<?= $opportunity_data['id'];?>">
                                                    <?php if($opportunity_data['is_favourite'] == 1){?>
                                                      <a class="btn-theme" onclick="changeFavouriteFlag(<?= $opportunity_data['id'] ?>,0)"   title="Remove techinal flag"><i class=" fas fa-bookmark"></i></a>
                                                    <?php }else{?>
                                                      <a class="btn-theme" onclick="changeFavouriteFlag(<?= $opportunity_data['id'] ?>,1)"  title="Add techinal flag" ><i class=" far fa-bookmark"></i></a> 
                                                    <?php } ?>
                                                  </span>

                                                  <a href="javascript:void(0);" data-toggle="tooltip" class="btn-theme" onclick="opp_tracker_modal(<?= $opportunity_data['id'];?>,2)" data-id="<?= $opportunity_data['id'];?>" ><i class="fas fa-edit"></i></a>
                                                </div>

                                              </div>

                                              <div class="row">
                                                <div class="col-md-12">
                                                  <h6 class="card-title m-t-5"><strong>Description</strong></h6>
                                                    <blockquote class="m-t-2">
                                                      <?= isset($opportunity_data['description'])?$opportunity_data['description']:''; ?>
                                                    </blockquote>
                                                </div>
                                                <div class="col-12" style="text-align: right;">
                                                  
                                                  <span><h6 style="margin-bottom: 2px;"><strong>Created by :- <?= $opportunity_data['created_by_name'].'.';?></strong></h6></span>
                                                  <span><h6 style="margin-bottom: 2px;">
                                                    <strong>Created at :- 
                                                      <?php echo  '&nbsp;&nbsp;'.time_elapsed_string(($opportunity_data['date']));

                                                      // $created_at = date("d F Y , h:i A", strtotime($opportunity_data['date']));
                                                      //     echo $created_at.'.';
                                                      ?>
                                                    </strong></h6>
                                                  </span>


                                                </div>



                                              </div>


                                            </div>
                                          </div>
                                          
                                        </div>

                                        <?php if(isset($opp_main_attachment_file)){?>    
                                          <div class="col-3" style="padding-top: 15px;">
                                            <h6 class="card-title m-t-15"><strong>Attchements</strong></h6>
                                            <div class="m-t-10">
                                              <div class="">
                                                  <div class="" style="margin-top:;">
                                                    <?php foreach($opp_main_attachment_file as $key4=>$val4){?>
                                                      <div class="col-md-12 col-xs-12" style="padding:0px">
                                                          <span class="text-muted"><?= $key4+1;?>. <a href="<?= base_url(OPPORTUNITY_TRACKER_IMAGE);?><?= $val4['file_name'];?>" target="_blank"><?= isset($val4['file_name'])?$val4['file_name']:'';?></a></span>
                                                      </div>
                                                    <?php } ?>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        <?php }?>
                                         
                                      </div> 
                                    </div>

                                  </div>
                                

                                </div>
                               
                              
                            </div>



                            <!--second tab-->
                            <?php if($redirect_type == OPPORTUNITY_TYPE_FOUR){?>
                                <div class="tab-pane" id="profile" role="tabpanel">
                            <?php }else{?>
                                <div class="tab-pane active" id="profile" role="tabpanel">
                            <?php } ?>

                            
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="row">
                                        <h6 class="card-title"><strong><i style="margin-right: 5px;" class="fas fa-arrow-alt-circle-right"></i>Opportunity Tracker Information</strong></h6>
                                      </div><hr>

                                      <div class="row" style="margin-top:10px;">
                                        <div class="col-md-2 col-xs-6 ">
                                          <strong>Title</strong>
                                        </div>
                                        <div class="col-md-2 col-xs-6 "> 
                                            <p class="text-muted"><?= isset($opportunity_data['title'])?$opportunity_data['title']:'';?></p>
                                        </div>

                                        <div class="col-md-2 col-xs-6 ">
                                            <strong>Customer Name</strong>
                                        </div>
                                        <div class="col-md-2 col-xs-6 "> 
                                            <p class="text-muted"><?= isset($opportunity_data['customer_name'])?$opportunity_data['customer_name']:'';?></p>
                                        </div>


                                        <div class="col-md-2 col-xs-6 ">
                                            <strong>Contact Person Name</strong>
                                        </div>
                                        <div class="col-md-2 col-xs-6 "> 
                                            <p class="text-muted"><?= isset($opportunity_data['contact_person_name'])?$opportunity_data['contact_person_name']:'';?></p>
                                        </div>

                                        <div class="col-md-2 col-xs-6 ">
                                            <strong>Contact Person Mobile No</strong>
                                        </div>
                                        <div class="col-md-2 col-xs-6 "> 
                                            <p class="text-muted"><?= isset($opportunity_data['contact_person_mobile_no'])?$opportunity_data['contact_person_mobile_no']:'';?></p>
                                        </div>

                                        <?php if($reminder_dt){?>   
                                          <div class="col-md-2 col-xs-6">
                                              <span><strong>Follow Up On</strong></span>
                                          </div>
                                          <div class="col-md-2 col-xs-6"> 
                                            <?php
                                              if(! empty($reminder_dt[0]['start_date_time'])){
                                               $start_date = date("j M Y", strtotime($reminder_dt[0]['start_date_time']));
                                              
                                               $start_time = date("h:i A", strtotime($reminder_dt[0]['start_date_time']));

                                               echo  '<span class="text-muted">'."$start_date".'</span>'; 
                                               // echo  '<span class="text-muted">'."$start_date".' '."$start_time".'</span>'; 
                                              }
                                            ?>
                                        
                                            <?php  
                                              if(! empty($reminder_dt[0]['end_date_time'])){
                                               $end_date = date("j M Y", strtotime($reminder_dt[0]['end_date_time']));
                                              
                                               $end_time = date("h:i A", strtotime($reminder_dt[0]['end_date_time']));
                                              
                                                 echo  ' to <span class="text-muted">'."$end_date".'</span>'; 
                                               // echo  'to <span class="text-muted">'."$end_date".' '."$end_time".'</span>'; 

                                              }
                                            ?>
                                          </div>
                                        <?php } ?>
                                      </div>
                                    </div>

                                  </div>



                                  <div class="row"> 
                                    <?php
                                      if(! empty($opp_main_attachment_file)){?>
                                        <div class="col-md-12">
                                          <div class="row">
                                              <i style="margin-right: 5px;" class="fas fa-arrow-alt-circle-right"></i><h6 class="card-title"><strong>Attchement Details</strong></h6>
                                          </div><hr>
                                          <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                            <?php foreach($opp_main_attachment_file as $key2=>$val2){?>
                                              <div class="col-md-3 col-xs-1 ">
                                                <div class="col-md-12 col-xs-6" style="padding:0px"> 
                                                  <a href="<?= base_url(OPPORTUNITY_TRACKER_IMAGE);?><?= $val2['file_name'];?>" target="_blank"><?= isset($val2['file_name'])?$val2['file_name']:'';?></a>
                                                </div>
                                              </div>
                                            <?php } ?>
                                          </div>
                                        </div>
                                      <?php } ?>
                                  </div>

                                  
                                    <div class="row">
                                        <h6 class="card-title"><strong><i style="margin-right: 5px;" class="fas fa-arrow-alt-circle-right"></i>Customer Details</strong></h6>
                                    </div><hr>
                                    <div class="row" style="margin-top:10px;">
                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Customer Name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['company_name'])?$customer_data['company_name']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Company Name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['customer_company_name'])?$customer_data['customer_company_name']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Site Name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['site_name'])?$customer_data['site_name']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Mobile No</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['phone'])?$customer_data['phone']:'';?></p>
                                      </div>


                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Currency</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['currency'])?$customer_data['currency']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Post Code</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['post_code'])?$customer_data['post_code']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Email</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['email'])?$customer_data['email']:'';?></p>
                                      </div>
                                      
                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Rate Type</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['rate_type'])?$customer_data['rate_type']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Vat</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['vat'])?$customer_data['vat']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Address</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['address'])?$customer_data['address']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>Country Name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['country_name'])?$customer_data['country_name']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>State name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['state_name'])?$customer_data['state_name']:'';?></p>
                                      </div>

                                      <div class="col-md-2 col-xs-6 ">
                                          <strong>City Name</strong>
                                      </div>
                                      <div class="col-md-2 col-xs-6 "> 
                                          <p class="text-muted"><?= isset($customer_data['city_name'])?$customer_data['city_name']:'';?></p>
                                      </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                      <h6 class="card-title"><strong><i style="margin-right: 5px;" class="fas fa-arrow-alt-circle-right"></i>Customer Billing Shipping Details</strong></h6>
                                    </div><hr>
                                    
                                    <div class="row">
                                      <div class="col-md-6">
                                          <div class="row">
                                            <i style="margin-right: 5px;visibility: hidden;" class="fas fa-arrow-alt-circle-right"></i><h6 class="card-title"><strong> Billing Details</strong></h6>
                                          </div><hr>

                                          <div class="row" style="margin-top:10px;">
                                            <!-- shipping -->
                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>Company Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['billing_company'])?$customer_data['billing_company']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>Address</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['b_street'])?$customer_data['b_street']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>Post Code</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['b_post_code'])?$customer_data['b_post_code']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>Country Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['b_country_name'])?$customer_data['b_country_name']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>State Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['b_state_name'])?$customer_data['b_state_name']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>City Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['b_city_name'])?$customer_data['b_city_name']:'';?></p>
                                            </div>

                                          </div>
                                      </div>

                                        <div class="col-md-6">
                                          <div class="row">
                                            <h6 class="card-title"><strong><i style="margin-right: 5px;visibility: hidden;" class="fas fa-arrow-alt-circle-right"></i> Shipping Details</strong></h6>
                                          </div><hr>
                                          <div class="row" style="margin-top:10px;">
                                            <!-- shipping -->
                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>Company Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['customer_company_name'])?$customer_data['customer_company_name']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>Address</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['s_street'])?$customer_data['s_street']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>Post Code</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['s_post_code'])?$customer_data['s_post_code']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>Country Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['s_country_name'])?$customer_data['s_country_name']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-1 ">
                                                <strong>State Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['s_state_name'])?$customer_data['s_state_name']:'';?></p>
                                            </div>

                                            <div class="col-md-3 col-xs-6 ">
                                                <strong>City Name</strong>
                                            </div>
                                            <div class="col-md-3 col-xs-6 "> 
                                                <p class="text-muted"><?= isset($customer_data['s_city_name'])?$customer_data['s_city_name']:'';?></p>
                                            </div>

                                          </div>
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

<div id="opp_tracker_modal" class="modal fade" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div id="_opp_tracker"></div>
      </div>
   </div>
</div>




<?php  init_footer(); ?>
 <!-- Horizontal-timeline JavaScript -->
<script src="<?= base_url()?>/assets/node_modules/horizontal-timeline/js/horizontal-timeline.js"></script>
<script src="<?= base_url(); ?>assets/js/page-js/sales/opportunity_tracker.js"></script>
