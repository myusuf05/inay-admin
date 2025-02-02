const pageState = {
  action: '',
  token: '',
  id: '',
  set setAction(d) {
    this.action = d;
  },
  set setToken(d) {
    this.token = d;
  },
  set setId(d) {
    this.id = d;
  }
};

const data = {
  _token: $('input[name="_token"]').val()
};

const responsive = {
  breakpoints: [
    { name: 'desktop', width: Infinity },
    { name: 'tablet', width: 1024 },
    { name: 'fablet', width: 768 },
    { name: 'phone', width: 480 }
  ]
};

const columnDefs = [
  {
    targets: 1,
    orderable: false,
  }
];

const pageLength = 5;

const dom = 'Bfrtip';

const pagingType = 'simple';

const baseUrl = '/pendataan/setting/address/';

// Load Datatable
$('#table_prov').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'prov',
    type: 'POST',
    data
  },
  columnDefs
});

$('#table_kab').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'kab',
    type: 'POST',
    data
  },
  columnDefs
});

$('#tabel_kec').dataTable({
  dom,
  pageLength,
  processing: true,
  serverSide: true,
  searching: true,
  responsive,
  pagingType,
  autoWidth: true,
  ajax: {
    url: baseUrl + 'kec',
    type: 'POST',
    data
  },
  columnDefs
});