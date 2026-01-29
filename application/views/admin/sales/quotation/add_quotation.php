<?php init_header(); ?>
<link href="<?= base_url()?>assets/css/pages/stylish-tooltip.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css">
<link rel="stylesheet" href="<?= base_url()?>assets/node_modules/bootstrap-multiselect/css/custom_mutiselect.css" type="text/css">
<link href="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.css" rel="stylesheet">


<style>
   body {
   font-family: "Lato Regular", sans-serif;
   }
   .form-group {
   min-height: 28px;
   font-size: 14px;
   }
   .form-control {
   font-size: 0.8rem;
   }
   label{
   margin-bottom: 0.2rem;
   }
   textarea{
   height:-2px !important;
   }
   /*label.error{
   display: none !important;
   }*/
   .error{
   color:red;
   }
   .sd{
   display: none;
   }
   hr {
   margin-top: 0.5rem;
   }
  /*  .text_area{
   margin-top: -4px !important;
   line-height: 2 !important;
   } */
 
   .margin-bottom-7{
   margin-bottom:10px !important;
   }
   .select2-container{
   margin-bottom: 7px !important;
   }
   .upper_case
   {
   text-transform: uppercase;
   }
   .select2-selection{
   height: 28px !important;
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
             
                 <form action="<?= base_url();?>admin/sales/Customer/add_customer"  enctype="multipart/form-data" method="post" id="frm" autocomplete="off">
                 <!--  <input type="hidden" name="id" id="id" value="<?= isset($customer)? $customer['id'] : '' ?>"> -->
                   <input type="hidden" name="id" id="id" value="<?= (isset($customer_id))? $customer_id : '' ?>">
                  
                  <div class="row">
                   

                     <div class="col-md-12 mb-3">
                        <div class="row">
                           <div class="col-md-12">
                              <span class="text-color"><h6><b>Add Quotation</b></h6></span><hr> 
                           </div>
                         
                           <div class="form-group col-md-3 ">
                            <label class="control-label">Venders</label>
                            <select class="form-control custom-select" data-placeholder="Choose a Category" required name="rate_type" tabindex="1">
                            <option></option>
                            <option value="1">None</option>
                            </select>
                           </div>

                           <div class="form-group col-md-3 ">
                            <label class="control-label">Purchaes Order</label>
                            <select class="form-control custom-select" data-placeholder="Choose a Category" required name="rate_type" tabindex="1">
                            <option></option>
                            <option value="1">None</option>
                            </select>
                           </div>
                           <div class="form-group col-md-6 ">
                             <label class="control-label">Currencies</label>
                              <select class="form-control custom-select" data-placeholder="Choose a Category"  name="currency"  tabindex="1">
                              <option></option>
                              <option>INR</option>
                              </select>
                           </div>


                           <div class="form-group col-md-3 ">
                            
                                        <label for="exampleInputuname">Estimate Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="ti-user">Est-</i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="000032" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                   
                           </div>
                             <div class="form-group col-md-3 ">
                            <label class="control-label">Buyer</label>
                            <select class="form-control custom-select" data-placeholder="Choose a Category" required name="rate_type" tabindex="1">
                            <option></option>
                            <option value="1">Abscd</option>
                                             </select>
                           </div>
                       

                             <div class="form-group col-md-3 ">
                             <label class="control-label">Estimate Date</label>
                             <div class="input-group">
                                 <input type="text" class="form-control" name="issue_date" id="datepicker-autoclose" >
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                             </div>
                           </div>

                            <div class="form-group col-md-3 ">
                             <label class="control-label">Expiry Date</label>
                             <div class="input-group">
                                 <input type="text" class="form-control mydatepicker" name="issue_date" id="" >
                                 <div class="input-group-append">
                                     <span class="input-group-text"><i class="ti-calendar"></i></span>
                                 </div>
                             </div>
                           </div>



                        </div>
                        <hr>

                     </div>
 						<div class="form-group col-md-4 ">
                             <label class="control-label">Items</label>
                             <select class="form-control select2 did-floating-select items"  name="items"  >
                             	<option>Select Items</option>
                             </select>
                           </div>

                             </div>
                              <!-- <table class="tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="swipe">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="border">
                                                Item</th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                                                data-tablesaw-priority="3" class="border">Unit Price </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" class="border">Year
                                            </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" class="border">
                                                <abbr title="Rotten Tomato Rating">Rating</abbr>
                                            </th>
                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4" class="border">Gross
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Avatar</a></td>
                                            <td>1</td>
                                            <td>2009</td>
                                            <td>83%</td>
                                            <td>$2.7B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Titanic</a></td>
                                            <td>2</td>
                                            <td>1997</td>
                                            <td>88%</td>
                                            <td>$2.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">The Avengers</a>
                                            </td>
                                            <td>3</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.5B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Harry Potter and
                                                    the Deathly Hallows—Part 2</a></td>
                                            <td>4</td>
                                            <td>2011</td>
                                            <td>96%</td>
                                            <td>$1.3B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Frozen</a></td>
                                            <td>5</td>
                                            <td>2013</td>
                                            <td>89%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Iron Man 3</a>
                                            </td>
                                            <td>6</td>
                                            <td>2013</td>
                                            <td>78%</td>
                                            <td>$1.2B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Transformers:
                                                    Dark of the Moon</a></td>
                                            <td>7</td>
                                            <td>2011</td>
                                            <td>36%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">The Lord of the
                                                    Rings: The Return of the King</a></td>
                                            <td>8</td>
                                            <td>2003</td>
                                            <td>95%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Skyfall</a></td>
                                            <td>9</td>
                                            <td>2012</td>
                                            <td>92%</td>
                                            <td>$1.1B</td>
                                        </tr>
                                        <tr>
                                            <td class="title"><a class="link" href="javascript:void(0)">Transformers:
                                                    Age of Extinction</a></td>
                                            <td>10</td>
                                            <td>2014</td>
                                            <td>18%</td>
                                            <td>$1.0B</td>
                                        </tr>
                                    </tbody>
                                </table> -->
                  <table class="table table-bordered table-hover table no-wrap" style="background:#eff1f3">
                                        <thead >
                                            <tr>
                                                <th><b>Item</b></th>
                                                <th><b>Unit Price(INR)</b></th>
                                                <th><b>Quantity</b></th>
                                                <th><b>Subtotal(Befor Tax)(INR)</b></th>
                                                <th><b>Tax</b></th>
                                                <th><b>Tax Value(INR)</b></th>
                                                <th><b>Subtotal(After Tax)(INR)</b></th>
                                                <th><b>Discount(%)</b></th>
                                                <th><b>Discount(Money)(INR)</b></th>
                                                <th><b>Total(INR)</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> <textarea class="form-control" rows="3" placeholder="Item Name"></textarea></td>
                                                <td> <input type="text" class="form-control" ></td>
                                                <td> <input type="text" class="form-control" placeholder="Unit"></td>
                                                <td></td>
                                                <td> <input type="text" class="form-control" placeholder=""></td>
                                                <td><input type="text" class="form-control" placeholder=""> </td>
                                                <td></td>
                                                <td><input type="text" class="form-control" placeholder=""> </td>
                                                <td><input type="text" class="form-control" placeholder="">  </td>
                                                <td> </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                    <div class="row">
                                    <div class="col-md-4">
                                    	
                                    </div>
                                    <div class="col-md-8">
                                    	<hr>
                                    	<span style="float:right;">Subtotal:0.0000</span>	
                                    	<hr>
                                    </div>
                                    </div>
                   
                    
            
                  <input type="submit" id="btnsubmit" style="margin-left: 90%;" class="btn btn-info btn-theme" value="Submit">
               </form>
            </div>
         </div>
      </div>
   </div>
<!-- end row -->
<?php init_footer(); ?>
<script src="<?= base_url(); ?>assets/js/page-js/sales/customer.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<script>
   $(document).ready(function () {
   
    $('#frm').validate({ 
         
         submitHandler: function(form) {
             form.submit();
         }
     });
   });
</script>
<style>
   .error{
   color: red;
   }
</style>
<script>
   $('.daterange').daterangepicker();
   $('.mydatepicker').datepicker({
    defaultDate: "today"
   });
    $('.mydatepicker').datepicker({
    defaultDate: "today",
    
   });
   
   $('.myPreviousDatepicker').datepicker({
    defaultDate: "today",
    minDate: null  // Set the minimum date to today, preventing selection of previous dates
});

     jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true,
        dateFormat:"Y-m-d"
    });

   
   
   
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
   
</script>
<!-- 
   <script>
      $(document).ready(function() { 
      $(".numberonly").attr("maxlength", "6");
          $(".numberonly").keypress(function(e) {
             var kk = e.which;
              if(kk < 48 || kk > 57)
              e.preventDefault();
          });
       });
      
      
      
   </script> -->
