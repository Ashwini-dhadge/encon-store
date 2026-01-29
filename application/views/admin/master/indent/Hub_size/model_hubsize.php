<style>
   label.error{
      display: none !important;
   }

   .select2-selection__rendered{
      margin-top: 1px;
   }

    .margin-bottom-7{
            margin-bottom: 7px !important;
        }
        .margin-bottom-20{
            margin-bottom: 20px !important;
        }
      
      label {
          margin-bottom: 0.2rem;
      }
      #mapping{
        margin-left: 20px;
      }
      form label {
		  font-weight: 628;
		}
     
      .select2-selection--multiple{
            border: solid #ced4da 1px !important;
      }
 table {
    border-collapse: collapse;
  }

  td {
    border: 1px solid black;
    padding: 5px;
    white-space: pre-wrap; /* or word-wrap: break-word; */
  }
</style>

<form method="post" action="<?= base_url('admin/indent/master/Hub/Hub_size/addMaster')?>" id="form" enctype="multipart/form-data">
   <div class="modal-body">
      <h4>Add Hub Size</h4>

      <hr>
      <input type="hidden" name="id" id="id" value="<?= isset($hub['id']) ? $hub['id'] : '' ?>">
      
  
      <div class="form-group col-md-12">
      <label class="">Hub Size</label>
         <div>
            <input  type="text" class="form-control " required  name="name" value="<?= isset($hub)? $hub['name'] : ''; ?>">
         </div>
      </div>

   </div>
   <div class="modal-footer">
      <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button> 
      <button type="submit" class="btn   waves-effect waves-light" id="submit_btn" style="background-color: #48bc97;color:white;">Add</button>
   </div>
</form>

<script>

  $("#companynm").select2({

  ajax: {
    url: base_url +'admin/master/Site/listCompanyName',
    dataType: 'json',
    delay: 250,
    data: function (data) {
            return {
                  searchTerm: data.term,
               };
            },
        processResults: function (response) {
        return {
            results:response
          };
        },
        cache: true
      }
    });

</script>
