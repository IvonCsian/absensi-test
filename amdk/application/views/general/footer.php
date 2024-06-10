<!-- Internet Connection Status-->
<div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
    <?php if($this->session->userdata('level') == 'AGEN'){?> <!-- footer agen -->
    <div class="footer-nav-area" id="footerNav">
      <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
          <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li class="active"><a href="<?php echo base_url(); ?>index.php/welcome/sukses"><i class="lni lni-home"></i>Home</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/report/vreportpo"><i class="lni lni-notepad"></i>Report PO</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/terima/apporder"><i class="lni lni-shopping-basket"></i>Order Masuk</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/report/vreport"><i class="lni lni-book"></i>Report</a></li>
            <li><a href="settings.html"><i class="lni lni-cog"></i>Settings</a></li>
          </ul>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if($this->session->userdata('level') <> 'AGEN'){?>
    <div class="footer-nav-area" id="footerNav">
      <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
          <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li class="active"><a href="<?php echo base_url(); ?>index.php/welcome/sukses"><i class="lni lni-home"></i>Home</a></li>
            <li><a href="message.html"><i class="lni lni-life-ring"></i>Support</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/order/orderbarang"><i class="lni lni-shopping-basket"></i>Order</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/history/vhistory"><i class="lni lni-book"></i>Report</a></li>
            <li><a href="settings.html"><i class="lni lni-cog"></i>Settings</a></li>
          </ul>
        </div>
      </div>
    </div>
    <?php }?>
    <!-- All JavaScript Files-->
    <script src="<?php echo base_url().'libraries/dist/js/bootstrap.bundle.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/waypoints.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.easing.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/owl.carousel.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.counterup.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/jquery.countdown.min.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/jquery.passwordstrength.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/dark-mode-switch.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/no-internet.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/default/active.js'?>"></script>
    <script src="<?php echo base_url().'libraries/dist/js/pwa.js'?>"></script>
  </body>
</html>