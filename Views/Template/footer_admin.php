<footer id="footer" class="footer">

  <div class="copyright">
    &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</footer><!-- End Footer -->

  <script>const base_url = "<?= base_url() ?>";</script>

  <!-- Jquery -->
  <script src="<?= media()?>/vendor/jquery/jquery.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="<?= media()?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= media()?>/vendor/quill/quill.min.js"></script>
  <script src="<?= media()?>/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= media()?>/vendor/tinymce/tinymce.min.js"></script>

  <!-- Charts -->
  <script src="<?= media()?>/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= media()?>/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= media()?>/vendor/echarts/echarts.min.js"></script>

  <!-- Sweet alerts -->
  <script src="<?=media()?>/vendor/sweetAlert2/sweetalert2.all.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= media()?>/js/main.js"></script>

  <!-- Script seteado de cada Controller -->
  <script src="<?= media(); ?>/js/<?= $data['page_functions_js'] ?>"></script>

</body>

</html>