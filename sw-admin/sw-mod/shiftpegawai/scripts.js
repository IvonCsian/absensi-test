$(document).ready(function() {
	
function get_data_tabel() {
	$.ajax({
		type: "POST",
		data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
		url: 'sw-mod/shiftpegawai/proses.php?action=viewdt',
		success: function (res) {
			$("#div_tabel_data").html(res);
		}
	});

}
get_data_tabel();



$(document).on('click', '.viewdt', function(){ 
    $.ajax({
		type: "POST",
		data: "tahun="+$('#tahun').val()+"&bulan="+$('#bulan').val(),
		url: 'sw-mod/shiftpegawai/proses.php?action=viewdt',
		success: function (res) {
			$("#div_tabel_data").html(res);
		}
	});
}); 

$('#swdatatable').dataTable({
    "iDisplayLength": 20,
    "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]
});

//Timepicker
$('.timepicker').timepicker({
    showInputs: false,
    showMeridian: false,
    use24hours: true,
    format :'HH:mm'
})

$('.datepicker').datepicker({
    format:'dd-mm-yyyy',
	autoclose:true
})

 jQuery(".select2").select2({
        width: '100%'
    });


function loading(){
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
}

/* ----------- Add ------------*/
$('.add-shift').submit(function (e) {
    if($('input[type=text]').val()==''){    
        swal({title:'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500,});
        return false;
        loading();
    }
    else{
        loading();
        e.preventDefault();
        $.ajax({
            url:"sw-mod/shiftpegawai/proses.php?action=add",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function () { 
              loading();
            },
            success: function (data) {
                if (data == 'success') {
                    swal({title: 'Berhasil!', text: 'Data Shift  berhasil disimpan.!', icon: 'success', timer: 1500,});
                   $('#modalAdd').modal('hide');
                   setTimeout(function(){ location.reload(); }, 1500);
                } else {
                    swal({title: 'Oops!', text: data, icon: 'error', timer: 1500,});
                }

            },
            complete: function () {
                $(".loading").hide();
            },
        });
    }
  });

/* -------------------- Edit ------------------- */
$('.update-shift').submit(function (e) {
    if($('#txtname').val()==''){    
         swal({title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.!', icon: 'error', timer: 1500,});
         loading();
        return false;
    }
    else{
        loading();
        e.preventDefault();
        $.ajax({
            url:"sw-mod/shiftpegawai/proses.php?action=update",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function () { 
                loading();
            },
            success: function (data) {
                if (data == 'success') {
                    swal({title: 'Berhasil!', text: 'Jabatan berhasil disimpan.!', icon: 'success', timer: 1500,});
                   $('#modalEdit').modal('hide');
                   setTimeout(function(){ location.reload(); }, 1500);

                } else {
                    swal({title: 'Oops!', text: data, icon: 'error', timer: 1500,});
                }

            },
            complete: function () {
                $(".loading").hide();
            },
        });
    }
  });


/*------------ Delete -------------*/
 $(document).on('click', '.delete', function(){ 
        var id = $(this).attr("data-id");
          swal({
            text: "Anda yakin menghapus data ini?",
            icon: "warning",
              buttons: {
                cancel: true,
                confirm: true,
              },
            value: "delete",
          })

          .then((value) => {
            if(value) {
                loading();
                $.ajax({  
                     url:"sw-mod/shiftpegawai/proses.php?action=delete",
                     type:'POST',    
                     data:{id:id},  
                    success:function(data){ 
                        if (data == 'success') {
                            swal({title: 'Berhasil!', text: 'Data berhasil dihapus.!', icon: 'success', timer: 1500,});
                            setTimeout(function(){ location.reload(); }, 1500);
                        } else {
                            swal({title: 'Gagal!', text: data, icon: 'error', timer: 1500,});
                            
                        }
                     }  
                });  
           } else{  
            return false;
        }  
    });
});

function exceltemplate(){
	window.open('sw-mod/shiftpegawai/proses.php?action=exceltemplate');
}

$(document).on('click', '.exceltemplate', function(){ 
   window.open('sw-mod/shiftpegawai/proses.php?action=exceltemplate');
}); 

$(document).ready(function(){
 var options = {
		beforeSend: function(){
		   if($('[name="filepegawai"]').val() == ''){
				alert("File Belum Dipilih");
			}
		},
		uploadProgress: function(){
			$("#loading").show();
			$("#loading2").show();
			
			$("#btnupload").hide();
			$("#btnclose").hide();
		},
		success: function(response){
			if(response == '1'){
			 $("#loading").hide();
			 alert("Data Berhasil Diupload");
			 $('#modalUpload').modal('hide');
			 get_data_tabel();
			 $("#loading2").hide();
			
			 $("#btnupload").show();
			 $("#btnclose").show();
			}
			else if(response == '2'){
			 $("#loading").hide();
			 alert("File Harus xlx / xlsx");
			}
			else{
				$("#loading").hide();
			}
		},
		complete: function(response){
			if(response == '1'){
			 $("#loading").hide();
			 alert("Data Berhasil Diupload");
			 $('#modalUpload').modal('hide');
			 get_data_tabel();
			 $("#loading2").hide();
			
			 $("#btnupload").show();
			 $("#btnclose").show();
			}
			else if(response == '2'){
			 $("#loading").hide();
			 alert("File Harus xls");
			}
		},
		error: function(response){
			if(response == '2'){
			 $("#loading").hide();
			 alert("File Harus xls");
			}
	 
		}
	};
	$("#formModalupload").ajaxForm(options);

}); 

});