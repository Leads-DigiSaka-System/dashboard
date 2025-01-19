"use strict";

// Make monochrome colors
const timing_colors = Highcharts.getOptions().colors.map((c, i) =>
  // Start out with a darkened base color (negative brighten), and end
  // up with a much brighter color
  Highcharts.color(Highcharts.getOptions().colors[0])
    .brighten((i - 3) / 7)
    .get()
);

// Make observation monochrome colors
const observation_colors = Highcharts.getOptions().colors.map((c, i) =>
  //console.log(Highcharts.getOptions().colors)
  // Start out with a darkened base color (negative brighten), and end
  // up with a much brighter color
  Highcharts.color(Highcharts.getOptions().colors[6])
    .brighten((i - 3) / 7)
    .get()
);

const timingChartScript = function (arr) {
  return {
    chart: {
      type: "pie",
    },
    title: {
      text: "Timing",
    },
    plotOptions: {
      pie: {
        colors: timing_colors,
      },
      series: {
        allowPointSelect: true,
        cursor: "pointer",
        dataLabels: [
          {
            enabled: true,
            distance: 20,
          },
          {
            enabled: true,
            distance: -40,
            format: "{point.y:.0f}",
          },
        ],
      },
    },
    credits: {
      enabled: false,
    },
    series: [
      {
        name: "Timing",
        colorByPoint: true,
        data: arr,
      },
    ],
  };
};

const observationChartScript = function (arr) {
  return {
    chart: {
      type: "pie",
    },
    title: {
      text: "Observation",
    },
    plotOptions: {
      pie: {
        colors: observation_colors,
      },
      series: {
        allowPointSelect: true,
        cursor: "pointer",
        dataLabels: [
          {
            enabled: true,
            distance: 20,
          },
          {
            enabled: true,
            distance: -40,
            format: "{point.y:.0f}",
          },
        ],
      },
    },
    credits: {
      enabled: false,
    },
    series: [
      {
        name: "Observation",
        colorByPoint: true,
        data: arr,
      },
    ],
  };
};

const generateDOMElement = function (array) {
  let html = "";

  if (array.length === 0) {
    html += `
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
					<h1 class="text-center">No data available</h1>
					</div>
				</div>
			</div>
		`;
  } else {
    for (const arr of array) {
      html += `
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<h3>${arr.title}</h3>
								</div>

								<div class="col-md-6">
									<figure class="highcharts-figure">
										<div id="${arr.div_id}_timing"></div>
									</figure>
								</div>
								
								<div class="col-md-6">
									<figure class="highcharts-figure">
										<div id="${arr.div_id}_observation"></div>
									</figure>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-12 text-center">
									<button class="btn btn-primary" onclick="viewDetails('${arr.title}', '${arr.product_used}', '${arr.quantity}', '${arr.date_of_activity}', '${arr.fertilizer_data}')">View</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			`;
    }
  }

  $("#append_analytics").html(html);
};

const generateAnalytics = function (array) {
  for (const arr of array) {
    if (arr.timing.length !== 0) {
      Highcharts.chart(`${arr.div_id}_timing`, timingChartScript(arr.timing));
    }

    if (arr.observation.length !== 0) {
      Highcharts.chart(
        `${arr.div_id}_observation`,
        observationChartScript(arr.observation)
      );
    }
  }
};

const getAnalytics = async function () {
  const activity = $("#activity").val();
  const area = $("#area").val();
  const product = $("#product").val();

  const _token = $('meta[name="csrf-token"]').attr("content");

  const response = await fetch("/analytics/getAnalytics", {
    headers: {
      "X-CSRF-Token": _token,
      "Content-Type": "application/json",
    },
    method: "POST",
    credentials: "same-origin",
    body: JSON.stringify({ activity: activity, area: area, product: product }),
  });

  const json = await response.json();

  generateDOMElement(json);
  generateAnalytics(json);
};


const viewDetails = async function (activityName) {
	try {
	  $('#modalActivityName').text(activityName || 'N/A');
	  const response = await fetch(`/getActivityDetails?activityName=${encodeURIComponent(activityName)}`);
	  const data = await response.json();
  
	  if (!response.ok) {
		alert(data.error || "Failed to fetch activity details.");
		return;
	  }
  
	  const baseURL = window.location.origin;
	  const tableBody = $("#detailsTable tbody");
	  tableBody.empty();
  
	  data.details.forEach((detail) => {
		const images = [
		  `${baseURL}/${detail.image1}`,
		  `${baseURL}/${detail.image2}`,
		  `${baseURL}/${detail.image3}`,
		  `${baseURL}/${detail.image4}`,
		].filter((url) => url); // Only keep non-empty URLs
  
		if (images.length > 0) {
		  const imagesJson = JSON.stringify(images);
		  tableBody.append(`
			<tr>
			  <td>${detail.full_name || "N/A"}</td>
			  <td>${detail.product_used || "N/A"}</td>
			  <td>${detail.disease || "N/A"}</td>
			  <td>${detail.date_of_activity || "N/A"}</td>
			  <td>${activityName || "N/A"}</td>
			  <td>
				<button class="btn btn-primary btn-sm view-images" data-images='${imagesJson}'>
				  View Images
				</button>
			  </td>
			</tr>
		  `);
		} else {
		  tableBody.append(`
			<tr>
			  <td>${detail.full_name || "N/A"}</td>
			  <td>${detail.product_used || "N/A"}</td>
			  <td>${detail.disease || "N/A"}</td>
			  <td>${detail.date_of_activity || "N/A"}</td>
			  <td>${activityName || "N/A"}</td>
			  <td>No Images Available</td>
			</tr>
		  `);
		}
	  });
  
	  // Image modal click handler
	  $(".view-images").on("click", function () {
		const imagesData = $(this).data("images");
		if (imagesData) {
		  const images = imagesData;
		  let imageGridContent = "";
  
		  images.forEach((url, index) => {
			if (url) {
			  imageGridContent += `
				<div class="col-3 mb-3">
				  <img src="${url}" class="img-fluid zoom-image" style="height: 200px; object-fit: cover;" alt="Image ${index + 1}">
				</div>
			  `;
			}
		  });
  
		  $("#imageGrid").html(imageGridContent);
		  $("#imageModal").modal("show");
  
		  // Apply zoom effect
		  $(".zoom-image").on("mouseenter", function () {
			$(this).css("transform", "scale(3)");
		  }).on("mouseleave", function () {
			$(this).css("transform", "scale(1)");
		  });
		}
	  });
  
	  // Show the activity details modal
	  $("#detailsModal").modal("show");
  
	} catch (error) {
	  console.error("Error fetching activity details:", error);
	  alert("An error occurred while loading details.");
	}
};



  
$("#activity").on("change", getAnalytics);
$("#area").on("change", getAnalytics);
$("#product").on("change", getAnalytics);

getAnalytics();
