 <style>
    
.sidebar-nav ul li a {
   /* color: gray !important;*/
   font-weight: 900;
   background: #48bc97 !important;  /*add 07-12*/ 
   color: white !important;  /*add 07-12*/
   font-size: 13px;
}
.mini-sidebar .sidebar-nav > ul > li ul li a {
  padding: 5px 10px;
}
.sidebar-nav > ul > li ul li a:hover{
    color:#ccc !important;
}
.collapse{
    background: #48bc97 !important; 
}
.sidebar-nav i{
    color:#FFF !important;
}
 #sidebarnav > li > a{
    padding: 0px 15px !important;
 }
.mini-sidebar .sidebar-nav {   
    min-height: 36px !important;
}
.mini-sidebar .sidebar-nav #sidebarnav > li > ul {
    top: 36px !important;
}
.topbar .top-navbar {
  min-height: 50px;
  }
</style>


        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
   
          <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li>
                            <a class="text-color" href="<?= base_url('admin/dashboard'); ?>" aria-expanded="false"><i class="icon-Car-Wheel"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <?php  if(getUserAccessForModule('Purchase order','is_menu')): ?>
                         <li> <a class="text-color" href="#" aria-expanded="false"><i class="icon-Suitcase "></i><span class="hide-menu">PO</span></a>
                            <ul aria-expanded="false" class="collapse">                              
                                <?php  if(getUserAccessForModule('Purchase order','create')): ?>
                                <li><a href="<?= base_url('admin/PO/add') ?>">Add PO</a></li>
                                <li><a href="<?= base_url('admin/PO') ?>">List PO</a></li>
                                 <?php endif; ?>
                                <!-- <//?php  if(getUserAccessForModule('DRS Shipment','is_menu')): ?>
                                <li><a href="<//?= base_url('admin/Shipment/drs_shipment') ?>">DRS Shipment</a></li> 
                                <//?php endif; ?>-->
                            </ul>
                        </li>
                            <?php
                                if(userId('role_id')==MANAGER_ROLE || userId('role_id')==SUPERADMIN_ROLE ):
                             ?>
                                        <li><a href="<?= base_url('admin/master/ItemApprovedRate') ?>">Approved Item Rate</a></li>
                             <?php
                                      endif;
                             ?>

                         <?php endif; ?>
                         
                          <?php  if(getUserAccessForModule('Store','is_menu')): ?>
                         <li> <a class="text-color" href="#" aria-expanded="false"><i class="icon-Suitcase "></i><span class="hide-menu">Store</span></a>
                            <ul aria-expanded="false" class="collapse">                              
                               
                                <li><a href="<?= base_url('admin/store/GoodsReceiptNote/poListAginstGRN') ?>">GRN Aginst PO</a></li>
                                <li><a href="<?= base_url('admin/store/GoodsReceiptNote') ?>">GRN List</a></li>
                                <li><a href="<?= base_url('admin/store/GoodsReceiptNote/add_Goods_Receipt_Note') ?>">Direct GRN</a></li>
                                <li><a href="<?= base_url('admin/store/MaterialIssue') ?>">Material Issue</a></li>
                                <li><a href="<?= base_url('admin/Inventory') ?>">Inventory</a></li>
                                <li><a href="<?= base_url('admin/store/GoodsItemOpening') ?>">Goods Item Opening</a></li>
                                 <li><a href="<?= base_url('admin/store/MaterialIssueReturn') ?>">Material Issue Return</a></li>
                                <li><a href="<?= base_url('admin/store/ReceiveMaterials') ?>"> Material Recevied</a></li>
                                <li><a href="<?= base_url('admin/store/ReceiveMaterials/receiveMaterial') ?>">  Transfered Material List</a></li>
                                 <li><a href="<?= base_url('admin/store/StockReport') ?>">Stock Report</a></li>
                                <!-- <//?php  if(getUserAccessForModule('DRS Shipment','is_menu')): ?>
                                <li><a href="<//?= base_url('admin/Shipment/drs_shipment') ?>">DRS Shipment</a></li> 
                                <//?php endif; ?>-->
                            </ul>
                        </li>
                         <?php endif; ?>
                          <?php  if(getUserAccessForModule('Indent','is_menu') || userId('role_id')==SUPERADMIN_ROLE ): ?>
                        <li>
                            <a class="text-color" href="<?= base_url('admin/indent/Indent') ?>" aria-expanded="false"><i class="icon-Indent-RightMargin"></i><span class="hide-menu">Indent</span></a>
                        </li>
                        <li>
                            <a class="text-color" href="<?= base_url('admin/indent/Indent') ?>" aria-expanded="false"><i class="icon-Indent-RightMargin"></i><span class="hide-menu">Master Indent</span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?= base_url('admin/indent/master/Blade/Mould_size') ?>">Blade Mould Size</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Blade/A_tip') ?>">Blade A.Tip(mm)</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Blade/Set') ?>">Blade Set</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Blade/Color') ?>">Colour</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Hub/Hub_size') ?>">Hub Size</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Hub/Plate_Od') ?>">Plate OD</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Hub/Material') ?>">Material</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Hub/Thickness') ?>">Thickness</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Hub/Hardware') ?>">Hardware</a></li>
                                         <li><a href="<?= base_url('admin/indent/master/Fan_Stack/Dimension') ?>">Fan Stack Dimension</a>
                                     
                                         <li><a href="<?= base_url('admin/indent/master/Fan_Stack/Height') ?>">Fan Stack Height</a>
                                         </li>  
                            </ul>
                        </li>
                        <?php endif; ?>
                        
                        <?php
                            if(getUserAccessForModule('Masters','is_menu') || getUserAccessForModule('User Mangement','is_menu')):
                        ?>

                        <li class="one-column"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="icon-Management"></i><span class="hide-menu">Master Module</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php
                              
                                    if(getUserAccessForModule('User Mangement','is_menu')):
                                ?>
                                 <li><a href="<?= base_url('admin/UserAccess') ?>">User</a></li>
                                <?php
                                    else :
                                ?>
                                <li><a href="<?= base_url('admin/UserAccess') ?>">User</a></li>
                                 <?php
                                    endif;
                                ?>
                                <?php
                              
                                    if(getUserAccessForModule('Masters','is_menu')):
                                ?>
                                 <li><a href="<?= base_url('admin/Vendor'); ?>" >Vendor</a><li>  
                                 <li><a href="<?= base_url('admin/master/Site') ?>">Site</a></li>
                                 <li><a href="<?= base_url('admin/master/ItemGroup') ?>">Item Group</a></li>
                                 <li><a href="<?= base_url('admin/master/Items') ?>">Items Master</a></li>
                                 <li><a href="<?= base_url('admin/master/TermCondition') ?>">Term/Condition Master</a></li>
                                 <li><a href="<?= base_url('admin/master/EmailTemplate') ?>">Email Template Master</a></li>
                               
                               <?php
                                    endif;
                                ?>
                                
                                <?php
                                    if(getUserAccessForModule('Vendor','is_menu')):
                                ?>
                                 <li><a href="<?= base_url('admin/Vendor'); ?>" >Vendor</a></li>
                                <?php
                                    else :
                                ?>
                               <li><a href="<?= base_url('admin/Vendor'); ?>" >Vendor</a></li>
                                 <?php
                                    endif;
                                ?>
                                
                                <?php
                                    if(getUserAccessForModule('Cost Project','is_menu')):
                                ?>
                                  <li><a href="<?= base_url('admin/master/CostProject') ?>">Cost Project Master</a></li>
                                <?php
                                    else :
                                ?>
                               <li><a href="<?= base_url('admin/master/CostProject') ?>">Cost Project Master</a></li>
                                 <?php
                                    endif;
                                ?>
                                
                                
                            </ul>
                        </li>    
                       
                        
                        <?php
                            endif;
                        ?>
                          
                          <?php     if(userId('role_id')==SUPERADMIN_ROLE  || getUserAccessForModule('Sales','is_menu')): ?>
                         <li class="one-column"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="icon-Administrator"></i><span class="hide-menu">Sales</span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?= base_url('admin/sales/Customer') ?>">Customer</a></li>
                                 <li><a href="<?= base_url('admin/sales/OpportunityTracker') ?>">Opportunity Tracker</a></li>
                                 <!--<li><a href="<?= base_url('admin/sales/add_quotation') ?>"> Add Quotation</a></li>-->
                                     <li><a href="<?= base_url('admin/sales/Lead') ?>">Lead</a></li>
                                
                            </ul>
                        </li>  
                          <?php
                            endif;
                        ?>
                        <?php  if(userId('role_id')==SUPERADMIN_ROLE): ?>
                        <!-- <li>-->
                        <!--    <a class="text-color" href="<?= base_url('admin/changeFinancialYear'); ?>" aria-expanded="false"><i class="icon-Car-Wheel"></i><span class="hide-menu">Change The Financial Year<span></a>-->
                        <!--</li>-->
                        <?php
                            endif;
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
     <script >var base_url = '<?= base_url(); ?>';var _admin = '<?= ADMIN ?>';var  superadmin_role_id = '<?= SUPERADMIN_ROLE; ?>'; var company_id='<?= userId('company_id') ?>'; var site_id='<?= userId('site_id') ?>';var login_role = '<?= userId('role_id') ?>'; var login_parent_role = '<?= userId('parent_staff_role') ?>';</script>