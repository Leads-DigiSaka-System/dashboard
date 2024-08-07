$(document).ready(function () {
  console.log(site_url, "======site_url");
  $("#surveyTable").DataTable({
    ajax: site_url + "/survey/",
    columns: [
      {
        data: "DT_RowIndex",
        name: "DT_RowIndex",
        orderable: false,
        searchable: false,
      },
      { data: "full_name", name: "full_name" },
      { data: "farm_id", name: "farm_id" },
      { data: "date", name: "date" },
      { data: "status", name: "status" },
      { data: "action", name: "action", orderable: false, searchable: false },
    ],
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        className: "btn-sm btn-success",
        titleAttr: "Export in Excel",
        text: '<i class="fa fa-file-export"></i>',
        exportOptions: {
          columns: ":not(:last-child)",
        },
      },
    ],
    ...defaultDatatableSettings,
  });

  $("#registered_users").DataTable({
    ajax: site_url + "/registered_users/",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'full_name', name: 'full_name'},
        {data: 'phone_number', name: 'phone_number'},
        // {data: 'role', name: 'role'},
        {data: 'status', name: 'status'},
        {data: 'via_app', name: 'via_app'},
        // {data: 'registered_by', name: 'registered_by'},
        {data: 'registered_date', name: 'registered_date'},
        // {data: 'region', name:'region'},
        // {data: 'province', name: 'province'},
        // {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    // dom: "Bfrtip",
    // buttons: [
    //   {
    //     extend: "excel",
    //     className: "btn-sm btn-success",
    //     titleAttr: "Export in Excel",
    //     text: '<i class="fa fa-file-export"></i>',
    //     exportOptions: {
    //       columns: ":not(:last-child)",
    //     },
    //   },
    // ],
    ...defaultDatatableSettings,
  });
});

const DATA_COUNT = 7;
const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};
const ctx = document.getElementById('harvest_per_season');

const data = {
    labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ],
    datasets: [
      {
        label: 'Dry Season',
        data: [12, 19, 3, 5, 2, 3, 12, 19, 3, 5, 2, 3],
        borderColor: "red",
        backgroundColor: "red",
      },
      {
        label: 'Wet Season',
        data: [2, 3, 12, 19, 3, 5, 12, 19, 2, 3, 3, 5],
        borderColor: "blue",
        backgroundColor: "blue",
      }
    ]
  };

new Chart(ctx, {
  type: 'line',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
