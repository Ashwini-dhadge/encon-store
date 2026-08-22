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


    .ck.ck-content.ck-editor__editable {
    height: 200px;
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
        <form action="<?= base_url();?>admin/sales/quotation/add_oc" enctype="multipart/form-data" method="post" id="frm" autocomplete="off">

                <div class="card float-left col-lg-12 mb-5">
                    <div class="card-body">
                        <div class="col-md-12 float-left">
                            <div class="col-md-12">
                                <span class="text-color"><h6><b><?= $title ?></b></h6></span><hr> 
                            </div>
                            
                            <!-- quotationData -->
                            
                            <!-- quotation_id -->
                            <input type="hidden" name="customer_id" value="<?= $quotationData[0]['customer_id']; ?>">
                            <input type="hidden" name="quotation_id" value="<?= $quotationData[0]['id']; ?>">
                            <input type="hidden" name="main_quotation_id" value="<?= isset($quotationData[0]['amendment_main_quotation_id']) ? $quotationData[0]['amendment_main_quotation_id'] : $quotationData[0]['id']; ?>">

                            <div class="col-md-6 float-left border-right">
                            
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Subject</label>
                                    <input type="text" class="form-control" value="" name="subject" id="" required>
                                </div>

                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">PO Description</label>
                                    <input type="text" value="" class="form-control" name="po_descriptions" id="">
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Purchase Order No</label>
                                    <input type="text" class="form-control" value="" name="purchase_order_no" id="" required>
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Purchase Order Date</label>
                                    <div class="input-group">
                                        <input type="date" value="" class="form-control" name="purchase_order_date">
                                        <!-- <div class="input-group-prepend">
                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-calendar" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div> 
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Proforma Invoice No</label>
                                    <input type="text" class="form-control" value="" name="proforma_order_no" id="" required>
                                </div>

                                <div class="form-group col-md-6 float-left">
                                    <label class="control-label">Proforma Invoice Date</label>
                                    <div class="input-group">
                                        <input type="date" value="" class="form-control" name="proforma_invoice_date">
                                        <!-- <div class="input-group-prepend">
                                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm" style="font-size:12px;background:#F0F0F0;color: gray;"><i class="fas fa-calendar" aria-hidden="true"></i></a>
                                        </div> -->
                                    </div> 
                                </div>

                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">GA Drawing No</label>
                                    <input type="text" class="form-control" value="" name="ga_drawing_no" id="" required>
                                </div>
                            </div>

                            <div class="col-md-6 float-left repeater1">
                                <div class="form-group col-md-12 float-left">
                                    <div class="col-lg-12 p-0 mb-1 float-left">
                                        <label class="control-label">Referance</label>
                                        <div class="input-group">
                                            <div class="editor-container col-md-12 p-0">
                                                <textarea name="oc_referance" class="refEditor" required>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 float-left">
                                <hr>
                            </div>
                            

                            <div class="col-md-6 float-left">
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Message Header</label>
                                    <div class="col-md-2 float-right mb-2 p-0">
                                        <a href="javascript:;" title="view" class="btn btn-primary waves-effect waves-light btn-sm headerMsgModel float-right" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="input-group">
                                        <div class="editor-container col-md-12 p-0">
                                            <textarea name="header_body_message" class="editor" required>
                                                <div id="header_body_message">

                                                </div>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 float-left">
                                <div class="form-group col-md-12 float-left">
                                    <label class="control-label">Message Footer</label>
                                    <div class="col-md-2 float-right mb-2 p-0">
                                        <a href="javascript:;" title="view" class="btn btn-primary waves-effect waves-light btn-sm footerMsgModel float-right" data-toggle="tooltip" data-bs-placement="top" style="font-size:13px;background:#F0F0F0;color: gray;"><i class="fas fa-plus" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="input-group">
                                        <div class="editor-container col-md-12 p-0">
                                            <textarea name="footer_body_message" class="roiDescriptionEditor" required>
                                                <div id="footer_body_message">

                                                </div>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" id="submitFrm" class="btn btn-info btn-theme float-right" value="Submit">
                    </div>
                </div>
                
        </form>
    </div>
</div>

<!-- /// Header Message Model -->
<div id="headerMsgModel" class="modal fade bd-example-modal-xl" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Header Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $data['type']=1; $this->load->view(ADMIN.'sales/quotation/tbl_ocMessage',$data); ?>   
            </div>
            <div class="modal-footer">
                <button type="button" id="getCheckedOCMessage" class="btn btn-info btn-theme">Add Message</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<div id="footerMsgModel" class="modal fade bd-example-modal-xl" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Footer Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php $data['type']=2; $this->load->view(ADMIN.'sales/quotation/tbl_ocMessage',$data); ?>   
            </div>
            <div class="modal-footer">
                <button type="button" id="getCheckedOCFooterMessage" class="btn btn-info btn-theme">Add Message</button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<!-- /// end Header Message Model -->




<style>
    .invoiceTable
    {

    }
    .invoiceTable th
    {
        background-color:#48bc97 !important;
        padding:10px;
        color:#fff;
        text-align:center;
    }
    .invoiceTable td
    {
        vertical-align: center;
        padding:10px;
    }
    .invoiceTable .incoice_bb  {
        border-bottom: solid 1px #CAD1DC !important;
    }
    

</style>

<!-- end row -->
<?php init_footer(); ?>


<script src="<?= base_url(); ?>assets/js/page-js/sales/quotation.js"></script>
<script src="<?= base_url(); ?>assets/js/custom_common.js"></script>
<script src="<?= base_url() ?>assets/node_modules/jquery-validation/jquery.validate.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url(); ?>/assets/node_modules/daterangepicker/daterangepicker.js"></script>
<!-- https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js -->


 
<script>
        ClassicEditor.create(document.querySelector('.refEditor'), {
            toolbar: {
                items: [
                    'bold',    
                    'numberedList' ,
                    'Paragraph', 
                ]
            },
            removePlugins: [
                'Heading',  // Remove unnecessary plugins to keep the editor minimal
                'Italic',
                'Link',
                'BlockQuote',
                'ImageUpload',
                'MediaEmbed',
                'Table',
                'Image',
                'TableToolbar',
                'TableProperties',
                'ImageToolbar',
                'ImageCaption',
                'ImageStyle',
                'ImageResize',
                'ImageInsert',
                
                'Alignment',
                'Autoformat',
                'Autosave',
                'Base64UploadAdapter',
                'CloudServices',
                'EasyImage',
                'Essentials',
                'FindAndReplace',
                'FontBackgroundColor',
                'FontColor',
                'FontFamily',
                'FontSize',
                'HorizontalLine',
                'HtmlEmbed',
                'Indent',
                'IndentBlock',
                'LinkImage',
                'ListStyle',
                'Markdown',
                'MediaEmbed',
                'PageBreak',
                'PasteFromOffice',
                'RemoveFormat',
                'SpecialCharacters',
                'Strikethrough',
                'Subscript',
                'Superscript',
                'TableProperties',
                'TableToolbar',
                'TodoList',
                'Underline',
                'WordCount'
            ]
        }).catch(error => {
            console.error(error);
        });
    </script>

<script>

    
    $(document).ready(function () {
        "use strict";

        
        function countRepeaters() {
            var repeaterCount = $('.repeater .repeater-group').length;
            return repeaterCount;
        }

        ClassicEditor.create(document.querySelector('.item_description_editor')).catch((error) => {
            console.error(error);
        });
        
        // ClassicEditor.create(document.querySelector('.refEditor')).catch((error) => {
        //     console.error(error);
        // });

        

        $(".repeater").repeater({
            show: function () {
                $(this).slideDown();

                $(this).find('.item_description_editor11').attr('class', 'item_description_editor'+ countRepeaters());
                
                $(this).find('.item_description_editor').attr('class', 'item_description_editor'+ countRepeaters());
                
                var editorContainer = document.querySelector('.item_description_editor' + countRepeaters());
                editorContainer.style.width = '200px';

                // Create CKEditor instance
                ClassicEditor.create(editorContainer).catch((error) => {
                    console.error(error);
                });
                
                countRepeaters();


            },
            hide: function (deleteElement) {
                if (
                    confirm(
                        "Are you sure you want to delete this element?"
                    )
                ) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function (setIndexes) {},
            isFirstItemUndeletable: true
        });


            var deletedROI = [];

            $(".repeater1").repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    var $item = $(this);
                    if (confirm("Are you sure you want to delete this element?")) {
                        var roiId = $item.find('[name^="group-b["][name$="][roi_id]"]').val();
                        if (roiId) {
                            deletedROI.push(roiId);
                        }
                        $item.slideUp(deleteElement);
                        //console.log(deletedROI);
                    }
                },
                ready: function (setIndexes) {},
                isFirstItemUndeletable: false
            });

        

            $('#submitFrm').on('click', function() {
                // alert("s");
                if(deletedROI.length > 0) {
                    var deletedROIIds = deletedROI.join(',');
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "deletedROIIds")
                        .attr('value', deletedROIIds)
                        .appendTo('#frm');
                }

                // deletedTechnicalSpecifications

                if(deletedTechnicalSpecifications.length > 0) {
                    var deletedTechSpecIds = deletedTechnicalSpecifications.join(',');
                    $('<input />').attr('type', 'hidden')
                        .attr('name', "deletedTechSpecIds")
                        .attr('value', deletedTechSpecIds)
                        .appendTo('#frm');
                }
                //alert(deletedTechnicalSpecifications);

                
            });


            
    });
</script>

<script>
$(document).ready(function () {

    ClassicEditor
        .create(document.querySelector('.roiDescriptionEditor'))
        .then(editor => {
            
            window.roiDescriptionEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });


 
    for (let i = 0; i <= editorId1; i++) {
        // alert(editorId1);
        // console.log(i);
        ClassicEditor.create(document.querySelector('.editor1'+ i)).catch((error) => {
            console.error(error);
        });
    }

    // editorQId1
    for (let i = 0; i <= editorQId1; i++) {
        // alert(editorId1);
        // console.log(i);
        ClassicEditor.create(document.querySelector('.item_description_editor1'+ i)).catch((error) => {
            console.error(error);
        });
    }


    
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
