<?php  init_header(); ?>
<!-- <link href="<?= base_url()?>assets/css/label_floating.css" rel="stylesheet"> -->
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
      <!-- Column -->
      <div class="col-lg-9 col-xlg-9 col-md-7">
         <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">
               <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="font-weight: bold;">Items Details</a> </li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="home" role="tabpanel">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-lg-6">
                           <table class="table">
                              <tbody>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Item Name</th>
                                    <td class="p-1"><?= isset($Items['item_name'])? $Items['item_name']:'';?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Short Name</th>
                                    <td class="p-1"><?= isset($Items['short_name'])? $Items['short_name']:'';?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width:51%;font-weight: bold;">Hsn Code</th>
                                    <td class="p-1"><?= isset($Items['hsn_code'])? $Items['hsn_code']:'';?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Item Group</th>
                                    <td class="p-1"><?= isset($Items['item_group_name'])? $Items['item_group_name']:'';?></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="col-lg-5">
                           <table class="table">
                              <tbody>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Stock Unit</th>
                                    <td class="p-1"><?= isset($Items['unit_name'])? $Items['unit_name']:'';?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Rate</th>
                                    <td class="p-1"><?= isset($Items['rate'])? $Items['rate']:'';?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Item Unit</th>
                                    <td class="p-1"> <?php
                                       $items_unit= array_column($units, 'id');
                                        foreach ($units as $key2 => $value2) {
                                            if(in_array($value2['id'],$items_unit)){
                                       
                                            $selected=",";
                                             }else{
                                             $selected="";
                                              }
                                            ?><?= $value2['unit_name']?><?= $selected; ?><?php }?></td>
                                 </tr>
                                 <tr>
                                    <th scope="row" class="p-1" style="width: 51%;font-weight: bold;">Created Date</th>
                                    <td class="p-1"><?= isset($Items['created_at'])? $Items['created_at']:'';?></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <hr>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Column -->
</div>
<br><br><br>
<?php  init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/master/items.js"></script>
