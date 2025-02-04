$(document).ready(function () {
  var table = $('#ghgProfilesTable').DataTable({
    ajax: {
      url: site_url + "/api/v1/ghg/getProfiles",
      data: function (d) {
        d.filter_column1 = $('input[name=filter_first_name]').val(); // First Name
        d.filter_column2 = $('input[name=filter_last_name]').val(); // Last Name
        d.technician = $('input[name=filter_technician]').val(); // Technician
      }
    },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'first_name', name: 'first_name' },
      { data: 'last_name', name: 'last_name' },
      { data: 'phone', name: 'phone' },
      { data: 'year', name: 'year' },
      { data: 'technician_name', name: 'users.full_name' },
      { data: 'area', name: 'area' },
      {
        data: 'created_at',
        name: 'created_at',
        render: function (data, type, row) {
          if (type === 'display') {
            return data && moment(data).isValid()
              ? moment(data).format('MMM D, YYYY h:mm A')
              : '-';
          }
          return data; // Use raw data for sorting and filtering
        }
      },
      {
        data: 'modified_at',
        name: 'modified_at',
        render: function (data, type, row) {
          if (type === 'display') {
            return data && moment(data).isValid()
              ? moment(data).format('MMM D, YYYY h:mm A')
              : '-';
          }
          return data; // Use raw data for sorting and filtering
        }
      },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ],
    buttons: [{
      exportOptions: {
        modifier: {
          page: 'all'
        },
        columns: ':not(:last-child)',
      },
    }],
    autoWidth: true,
    ...defaultDatatableSettings
  });


  $(".buttons-excel").hover(function () {
    $(this).attr('title', 'Export all records');
  });

  // Apply the filter
  $('.filter').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" name="filter_' + title.toLowerCase().replace(/\s/g, '_') + '" />');
  });

  // Apply the filter
  $('input[name^="filter_"]').on('keyup change', function () {
    var index = $(this).attr('name').split('_')[1];
    $('#jasProfilesTable').DataTable().column(index).search(this.value).draw();
  });

  $(document).on('click', '.viewImageBtn', async function () {
    const id = $(this).data('id');
    const token = $('meta[name="csrf-token"]').attr('content')

    $('#appendCarousel').html("");
    const response = await fetch('jasProfiles/images', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": token
      },
      body: JSON.stringify({ id: id })
    })

    const content = await response.json();

    populateModal(content);

  })

  const populateModal = function (contents) {
    const base_url = window.location.origin; //"https://digisaka.info"  // 
    let html = "";

    let carousel_content = "";
    let carousel_indicator = "";
    let carousel_inner = "";

    let image_counter = 0;
    for (let x = 0; x < contents.length; x++) {
      const content = contents[x]
      const images = content.images

      if (images.length !== 0) {
        for (const image of images) {
          carousel_indicator += `
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${image_counter}" class="${image_counter == 0 ? 'active' : ''}" aria-current="true" aria-label="Slide ${image_counter + 1}"></button>
                    `
          carousel_inner += `
                        <div class="carousel-item ${image_counter == 0 ? 'active' : ''}">
                          <img src="${base_url}/${image}" class="d-block w-100" height="600" width="400" title="${content.activity}" alt="...">
                          <div class="carousel-caption d-none d-md-block" style="bottom:0 !important; top: 0rem">
                            <h2 class="fw-bolder text-white">${content.activity}</h2>
                          </div>
                        </div>
                    `
          image_counter++;
        }
      } else {
        carousel_indicator += `
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${image_counter}" class="${image_counter == 0 ? 'active' : ''}" aria-current="true" aria-label="Slide ${image_counter + 1}"></button>
                    `

        carousel_inner += `
                    <div class="carousel-item ${image_counter == 0 ? 'active' : ''}">
                      <img src="https://dummyimage.com/600x400/000/fff&text=No+image+available" class="d-block w-100" height="600" width="400" title="${content.activity}" alt="...">
                      <div class="carousel-caption d-none d-md-block" style="bottom:0 !important; top: 0rem">
                        <h2 class="fw-bolder text-white">${content.activity}</h2>
                      </div>
                    </div>
                `
      }
    }

  }
});