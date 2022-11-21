// get font row
function getfontrow(font) {
  "use stricts";
  var fontRow = "";
  if (font) {
    const userfont = font.font_file ? font.font_file : "default.png";
    fontRow = `<tr>
            <style>
              @font-face {
                  font-family: "${font.family}";
                  src: url(`+base_url+`assets/uploads/${userfont}) format("truetype");
              }
              td.example-${font.id} { font-family: "${font.family}", ${font.full_name} }          
            </style>
          <td class="align-middle">${font.full_name}</td>
          <td class="align-middle example-${font.id}" font-family:"${font.family}";>Example Style</td>
          <td class="align-middle">
            <a href="#" class="text-danger deletefont" title="Delete" data-id="${font.id}">Delete</a>
          </td>
        </tr>`;
  }
  return fontRow;
}
function getfontgrouprow(font) {
  "use stricts";
  console.log(font);
  var fontRow = "";
  if (font) {
    fontRow = `<tr>
          <td class="align-middle">${font.group_name}</td>
          <td class="align-middle">${font.fonts}</td>
          <td class="align-middle"">${font.total}</td>
          <td class="align-middle">
            <a href="#" class="text-danger deletefontgroup" title="Delete" data-id="${font.id}">Delete</a>
          </td>
        </tr>`;
  }
  return fontRow;
}
function font_list(fonts){
  "use strict";
  var all_font = "";
  all_font = `<option value="${fonts.id}">${fonts.full_name}</option>`;
  return all_font;
}
// get fonts list
var base_url = $("#base_url").val();
function getfonts() {
  "use stricts";
  $.ajax({
    url: base_url+"ajax.php",
    type: "GET",
    dataType: "json",
    data: {action: "getfonts" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      if (rows.fonts) {
        var fontslist = "";
        var all_fonts = "";
        $.each(rows.fonts, function (index, font) {
          fontslist += getfontrow(font);
          all_fonts += font_list(font);
        });
        $("#fontstable tbody").html(fontslist);
        $("#font_list_1").html(all_fonts);
        $("#font_list_0").html(all_fonts);
        $("#overlay").fadeOut();
      }
    },
    error: function () {
      console.log("something went wrong");
    },
  });
}
function getfontgroups() {
  "use stricts";
  $.ajax({
    url: base_url+"ajax.php",
    type: "GET",
    dataType: "json",
    data: {action: "getfontgroups" },
    beforeSend: function () {
      $("#overlay").fadeIn();
    },
    success: function (rows) {
      console.log(rows);
      if (rows.fonts) {
        var fontslist = "";
        $.each(rows.fonts, function (index, font) {
          fontslist += getfontgrouprow(font);
        });
        $("#fontgroupstable tbody").html(fontslist);
        $("#overlay").fadeOut();
      }
    },
    error: function () {
      console.log("something went wrong");
    },
  });
}

$(document).ready(function () {
  // add/edit user
  $(document).on("submit", "#add_font_group", function (event) {
    event.preventDefault();
    var alertmsg =
      $("#font_group_id").val().length > 0
        ? "Font Group has been updated Successfully!"
        : "New Font Group has been added Successfully!";
        
    if($('select[name="font_list[]"]').length<2){
      alertmsg = "Minimum two font required";
      $(".message").html(alertmsg).fadeIn().delay(3000).fadeOut();
      return false;
    }
    $.ajax({
      url: base_url+"ajax.php",
      type: "POST",
      dataType: "json",
      data: new FormData(this),
      processData: false,
      contentType: false,
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function (response) {
        console.log(response);
        if (response) {
          $("#add_font_group")[0].reset();
          $(".message").html(alertmsg).fadeIn().delay(3000).fadeOut();
          getfontgroups();
          $(".font_group > div").not(':first').remove();
          $("#overlay").fadeOut();
        }
      },
      error: function () {
        console.log("Oops! Something went wrong!");
      },
    });
  });
  // delete font
  $(document).on("click", "a.deletefont", function (e) {
    e.preventDefault();
    var pid = $(this).data("id");
    if (confirm("Are you sure want to delete this?")) {
      $.ajax({
        url: base_url+"ajax.php",
        type: "GET",
        dataType: "json",
        data: { id: pid, action: "deletefont" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          if (res.deleted == 1) {
            $(".message")
              .html("Font has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
            getfonts();
            $("#overlay").fadeOut();
          }
        },
        error: function () {
          console.log("something went wrong");
        },
      });
    }
  });
  $(document).on("click", "a.deletefontgroup", function (e) {
    e.preventDefault();
    var gid = $(this).data("id");
    if (confirm("Are you sure want to delete this?")) {
      $.ajax({
        url: base_url+"ajax.php",
        type: "GET",
        dataType: "json",
        data: { id: gid, action: "deletefontgroup" },
        beforeSend: function () {
          $("#overlay").fadeIn();
        },
        success: function (res) {
          if (res.deleted == 1) {
            $(".message")
              .html("Font Group has been deleted successfully!")
              .fadeIn()
              .delay(3000)
              .fadeOut();
              getfontgroups();
            $("#overlay").fadeOut();
          }
        },
        error: function () {
          console.log("something went wrong");
        },
      });
    }
  });
  // load fonts
  getfonts();
  getfontgroups();
});
function fileValuesTwo(value) {
  'use strict';
  // value.preventDefault();
  var alertmsg = "New Font has been added Successfully!";
  var path = value.value;
  var extenstion = path.split('.').pop();
  if (extenstion == "ttf" || extenstion == "TTF" ) {
      var fd = new FormData();
      // console.log(fd);
      fd.append('font', $('#font_file')[0].files[0]);
      fd.append('action', $('#action').val());
      $.ajax({
          url: base_url+"ajax.php",
          type: "POST",
          dataType: "json",
          data: fd,
          processData: false,
          contentType: false,
          beforeSend: function () {
            $("#overlay").fadeIn();
          },
          success: function (response) {
            console.log(response);
            if (response) {
              $("#addfont")[0].reset();
              $(".message").html(alertmsg).fadeIn().delay(3000).fadeOut();
              getfonts();
              $("#overlay").fadeOut();
            }
          },
          error: function () {
            console.log("Oops! Something went wrong!");
          },
      });
  } else {
      alert("File not supported. Kindly Upload the File of below given extension");
  }
}
var n = 2;
function add_row(){
  "use strict";
  var all_font =$("#font_list_0").html();
  // console.log(all_font);
  var row = "";
  row += `<div class="row list_${n} mt-3">
            <div class="col">
                <input type="text" required class="form-control" name="font_name[]" id="font_name_${n}" placeholder="Font name">
            </div>
            <div class="col">
                <select required name="font_list[]" class="custom-select" id="font_list_${n}">
                    ${all_font}
                </select>
            </div>
            <button type="button" onclick="del_row(${n})" class="close" aria-label="Close">
                <span aria-hidden="true" class="text-danger">&times;</span>
            </button>
          </div>`;
  n++;
  $(".font_group").append(row);
}
function del_row(item){
"use strict";
// alert(item);
$(".list_"+item).remove();
}