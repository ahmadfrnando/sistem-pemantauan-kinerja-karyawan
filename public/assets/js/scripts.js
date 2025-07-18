function initializeDataTable(tableSelector, ajaxRoute, columnsConfig) {
  var table = $(tableSelector).DataTable({
    destroy: true,
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: route(ajaxRoute),
    columns: columnsConfig,
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json', // CDN Bahasa Indonesia
    }
  });

  // Custom pagination icons
  table.on('draw', function() {
    $('#DataTables_Table_0_previous a').html('<i class="ni ni-bold-left"></i>');
    $('#DataTables_Table_0_next a').html('<i class="ni ni-bold-right"></i>');
  });
}