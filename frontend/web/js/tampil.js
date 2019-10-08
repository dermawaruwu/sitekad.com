$(document).ready(function() {
  //url = "https://sitekad.com/frontend/web/index.php?r";
  url = "sitekad/frontend/web/index.php?r";
  var table = $("#tampil").DataTable({
    scrollY: "400px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: {
      leftColumns: 1,
      rightColumns: 1
    },
    deferRender: true,
    dom: "Bfrtip",
    //buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"]
    buttons: [
      {
        extend: "excelHtml5",
        text: "Download Excel"
      }
    ]
  });

  $(".tanggalOH").click(function() {
    //Get the id of this clicked item

    cellId = $(this).attr("id");
    console.log(cellId);

    var modalTampil = $("#modalTampil");

    if (cellId.indexOf("μ") > -1) {
      modalTampil.modal("show");
      modalTampil
        .find("#modalContent")
        .load("index.php?r=jadwaloh/update&id=" + cellId);
    } else {
      nama = cellId.split("_")[1];
      tanggal = cellId.substr(0, 10);
      user = cellId.substring(
        cellId.lastIndexOf("£") + 1,
        cellId.lastIndexOf("_")
      );
      $.ajax({
        url: "index.php?r=jadwaloh/cek-jadwaloh",
        type: "get",
        dataType: "json",
        data: {
          tanggal: tanggal,
          user: user
        },
        success: function(data) {
          console.log(user);
          console.log(tanggal);
          console.log(nama);
          if (data["status"] == "kosong") {
            modalTampil.modal("show");
            modalTampil
              .find("#modalContent")
              .load("index.php?r=jadwaloh/create&dt=" + cellId);
          } else {
            idJadwaloh = data["idJadwaloh"];
            console.log(idJadwaloh);
            cellIdUpdate = tanggal + "μ" + idJadwaloh + "_" + nama;
            modalTampil.modal("show");
            modalTampil
              .find("#modalContent")
              .load("index.php?r=jadwaloh/update&id=" + cellIdUpdate);
          }
        },
        error: function(err) {
          alert(err);
        }
      });
    }

    //determine whether create or update
    // if (cellId.indexOf("£") > -1) {
    //   modalTampil.modal("show");
    //   modalTampil
    //     .find("#modalContent")
    //     .load("index.php?r=jadwaloh/create&dt=" + cellId);
    // } else {
    //   modalTampil.modal("show");
    //   modalTampil
    //     .find("#modalContent")
    //     .load("index.php?r=jadwaloh/update&id=" + cellId);
    // }
  });
});
