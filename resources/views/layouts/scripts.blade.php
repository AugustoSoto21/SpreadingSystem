<!-- jQuery -->
<script src="{!! asset('vendor/jquery/jquery.min.js') !!}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{!! asset('vendor/jquery-ui/jquery-ui.min.js') !!}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{!! asset('vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- Summernote -->
<script src="{!! asset('vendor/summernote/summernote-bs4.min.js') !!}"></script>
<!-- overlayScrollbars -->
<script src="{!! asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! asset('js/adminlte.js') !!}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! asset('js/demo.js') !!}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{!! asset('js/pages/dashboard.js') !!}"></script>
<!-- DataTables -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ asset('js/sweetalert2.min.js') }}"></script> -->
<!-- bs-custom-file-input -->
<script src="{!! asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') !!}"></script>
<!-- Parsley -->
<script src="{{ asset('vendor/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('vendor/parsleyjs/i18n/es.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
$(function () {
	$('.select2').select2()
	$('.select2bs4').select2({
      theme: 'bootstrap4'
    })
});
</script>
@yield('scripts')