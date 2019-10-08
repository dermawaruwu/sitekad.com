document.addEventListener("DOMContentLoaded", function() {
  urlRoot = "https://sitekad.com/frontend/web/index.php?r=";

  $(document).ready(function() {
    let params = new URL(document.location).searchParams;
    let bulan = params.get("bulan");
    let tahun = params.get("tahun");
    grafikPerOrang(tahun, bulan);
    grafikPerSeksi(tahun, bulan);
  });
});

function grafikPerOrang(tahun, bulan) {
  jenisGrafik = "column";
  $.ajax({
    url: urlRoot + "analisis/jumlahoh-per-orang",
    type: "get",
    dataType: "json",
    data: {
      jenisGrafik: jenisGrafik,
      bulan: bulan,
      tahun: tahun
    },
    success: function(data) {
      Highcharts.chart("perOrang", {
        chart: {
          renderTo: "perOrang"
        },
        exporting: {
          chartOptions: {
            // specific options for the exported image
            plotOptions: {
              series: {
                dataLabels: {
                  enabled: true
                }
              }
            }
          },
          fallbackToExportServer: false
        },
        buttons: {
          contextButton: {
            menuItems: [
              "printChart",
              "separator",
              //"downloadPNG",
              "downloadJPEG",
              "downloadPDF",
              //"downloadSVG",
              "separator",
              //"downloadCSV",
              "downloadXLS",
              "viewData"
            ]
          }
        },
        title: {
          text: "OH Per Pegawai"
        },
        xAxis: {
          categories: data[0]["xaxis"]
        },
        yAxis: {
          plotLines: [
            {
              color: "#bf55ec",
              value: data[0]["rerata"],
              width: 3,
              zIndex: 90 // To not get stuck below the regular plot lines
            }
          ]
        },
        tooltip: {
          formatter: function() {
            var s;
            if (this.point.name) {
              // the pie chart
              s = "" + this.point.name + ": " + this.y + " fruits";
            } else {
              s = "OH " + this.x + ": " + this.y;
            }
            return s;
          }
        },
        labels: {
          items: [
            {
              html: "Total OH",
              style: {
                left: "40px",
                color: "black"
              }
            }
          ]
        },
        series: [data[0]]
      });
    },
    error: function(err) {
      alert(err);
    }
  });
}

function grafikPerSeksi(tahun, bulan) {
  jenisGrafikPerSeksi = "pie";
  $.ajax({
    url: urlRoot + "analisis/jumlahoh-per-seksi",
    type: "get",
    dataType: "json",
    data: {
      jenisGrafik: jenisGrafikPerSeksi,
      bulan: bulan,
      tahun: tahun
    },
    success: function(data) {
      Highcharts.chart("perSeksi", {
        chart: {
          renderTo: "perSeksi",
          type: jenisGrafikPerSeksi
        },
        title: {
          text: "OH Per Seksi"
        },
        tooltip: {
          formatter: function() {
            var s;
            if (this.point.name) {
              // the pie chart
              s = "" + this.point.name + ": " + this.y + " OH";
            } else {
              s = "OH " + this.x + ": " + this.y;
            }
            return s;
          }
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              format: "<b>{point.name}</b>: {point.percentage:.1f} %",
              style: {
                color:
                  (Highcharts.theme && Highcharts.theme.contrastTextColor) ||
                  "black"
              }
            }
          }
        },

        series: [
          {
            data: data["content"],
            slicedOffset: 0
          }
        ]
      });
    },
    error: function(err) {
      alert(err);
    }
  });
}
