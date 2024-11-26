$(document).ready(function () {
    $('#jasProfilesTable').DataTable({
        ajax: {
            url: site_url + "/jasProfiles/",
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
            { data: 'created_at', name: 'created_at' },
            { data: 'modified_at', name: 'modified_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        // dom: 'Bfrtip',
        buttons: [{
            // extend: "excel",
            // className: "btn-sm btn-success",
            // titleAttr: 'Export in Excel',
            // text: '<i class="fa fa-file-export"></i>',
            // action: function ( e, dt, button, config ) {
            //     window.location = site_url + "/jasProfiles/export";
            // },
            exportOptions: {
                modifier: {
                    page: 'all'
                },
                columns: ':not(:last-child)',
            },
        }],
        // responsive: true,
        autoWidth: true,
        // scrollX: true,
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

        const response = await fetch('jasProfiles/images', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-Requested-With" : "XMLHttpRequest",
                "X-CSRF-TOKEN" : token
            },
            body: JSON.stringify({id : id})
        })

        const content = await response.json();

        populateModal(content);
        
    })

    const populateModal = function (content) {
        const base_url = window.location.origin;
        let html = "";

        let carousel_content = "";
        let carousel_indicator = "";
        let carousel_inner = "";
        if(content.images.length > 1) {
            for(let i = 0; i < content.images.length; i++) {
                const images = content.images[i]

                carousel_indicator += `
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="${i}" class="active" aria-current="true" aria-label="Slide ${i + 1}"></button>
                `

                carousel_inner += `
                    <div class="carousel-item ${i == 0 ? 'active' : ''}">
                      <img src="${base_url}/${images}" class="d-block w-100" height="600" width="400" title="${content.activity}" alt="...">
                    </div>
                `
            }

            carousel_content += `
                <div class="carousel-indicators">
                    ${carousel_indicator}
                </div>
                <div class="carousel-inner">
                    ${carousel_inner}
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            `

        } else {

            const image = content.images[0]
            const url =  image === undefined ? 'https://dummyimage.com/600x400/000/fff&text=No+image+available' : `${base_url}/${image}`
            carousel_content += `
            <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="${url}" class="d-block w-100" height="600" width="400" title="${content.activity}" alt="...">
                </div>
            </div>
            `
        }

        html += `
            <div id="carouselExampleIndicators" class="carousel slide">

              ${carousel_content}

            </div>
        `

        $('#appendCarousel').html(html);
        /*html = `
        <div id="carouselExampleIndicators" class="carousel slide">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://dummyimage.com/600x400/000000/fff" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="https://dummyimage.com/600x400/a13aa1/fff" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="..." class="d-block w-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>`*/
    }
});