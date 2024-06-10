$(document).ready(function() {

$('.datepicker').datepicker({
    format:'dd-mm-yyyy',
	autoclose:true
})

 jQuery(".select2").select2({
        width: '100%'
    });

$('#swdatatable').dataTable({
    "iDisplayLength":31,
    "aLengthMenu": [[31, 50, 100, -1], [31, 50, 100, "All"]],
});

function loading(){
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
}

$('.btn-clear').click(function (e) {
    loadData();
    $('.month').val('');
    $('.year').val('');
});

$('.btn-sortir').click(function (e) {
        var month_d = new Array();
        month_d[0] = "January";
        month_d[1] = "February";
        month_d[2] = "March";
        month_d[3] = "April";
        month_d[4] = "May";
        month_d[5] = "June";
        month_d[6] = "July";
        month_d[7] = "August";
        month_d[8] = "September";
        month_d[9] = "October";
        month_d[10] = "November";
        month_d[11] = "December";

        var id    = $('.id').val();
        var month = $('.month').val();
        var year  = $('.year').val();

        var d     = new Date(month);
        var n     = month_d[d.getMonth()];
        //document.getElementById("demo").innerHTML = n;
        $('.result-month').html(n);

       $.ajax({
          url: 'sw-mod/absensi/proses.php?action=absensi&id='+id+'',
          method:"POST",
          data:{month:month,year:year},
          dataType:"text",
          cache: false,
          async: false,
            beforeSend: function () { 
             //loading();
            },
            success: function (data) {
               $('.loaddata').html(data);
            },
        complete: function () {
            //$(".loading").hide();
        },
    });
});

(function() {
    var $gallery = new SimpleLightbox(".picture a", {});
})();


    $('.btn-print').click(function (e) {
            var id    = $('.id').val();
            var month = $('.month').val();
            var year  = $('.year').val();
            var type  = $(this).attr("data-id");
        
            if(type =='pdf'){
                // cek berdasarkan bulan
                if(month==''){    
                    var url = "./absensi/print?action=pdfid="+id+"";
                }else{
                    var url = "./absensi/print?action=pdf&id="+id+"&from="+month+"&to="+year+"";
                }
            }

            if(type=='excel'){
                if(month==''){    
                    var url = "./absensi/print?action=excel&id="+id+"";
                }else{
                    var url = "./absensi/print?action=excel&id="+id+"&from="+month+"&to="+year+"";
                }
            }

            if(type=='print'){
                var url = "./absensi/print?action=excel&id="+id+"&from="+month+"&to="+year+"&print=print";
            }
            window.open(url, '_blank');
    });

    $('.btn-print-all').click(function (e) {
            var month = $('.month').val();
            var year  = $('.year').val();
            var type  = $('.type').val();
            if(type =='pdf'){
                // cek berdasarkan bulan
                var url = "./absensi/print?action=allpdf&from="+month+"&to="+year+"";
            }
            if(type=='excel'){
                var url = "./absensi/print?action=allexcel&from="+month+"&to="+year+""; 
            }
            if(type=='print'){
                var url = "./absensi/print?action=allexcel&from="+month+"&to="+year+"&print=print"; 
            }

            window.open(url, '_blank');
    });

});


$(document).on('click', '.btn-modal', function(){
    $('#modal-location').modal();
    var latitude  = $(this).attr("data-latitude");
    var longitude = $(this).attr("data-longitude");
    var name = $('.employees_name').html();
    $(".modal-title-name").html(name);
    document.getElementById("iframe-map").innerHTML ='<iframe src="sw-mod/absensi/map.php?latitude='+latitude+'&longitude='+longitude+'&name='+name+'" frameborder="0" width="100%" height="400px" marginwidth="0" marginheight="0" scrolling="no">';
});
 

function viewdt() {
	var kd_bidang = $('#kd_bidang').val();
	var tanggal = $('#tanggal').val();	
	var status_peg = $('#status_peg').val();	
	$.ajax({
        url: 'sw-mod/job/proses.php?action=reporttgl&kd_bidang='+kd_bidang+'&tanggal='+tanggal+'&status_peg='+status_peg+'',
        type: 'POST',
		beforeSend: function () {
			$('#loading1').show();	
		},
        success: function(data) {
          $('.loaddata').html(data);
		  $('#loading1').hide();	
        }
    });
}

function exceldt(){
	var kd_bidang = $('#kd_bidang').val();
	var tanggal = $('#tanggal').val();
	var status_peg = $('#status_peg').val();	
	window.open('sw-mod/job/proses.php?action=excelreporttgl&kd_bidang='+kd_bidang+'&tanggal='+tanggal+'&status_peg='+status_peg+'');
}


function viewdtbln() {
	var kd_bidang = $('#kdbidang').val();
	var tgl_awal = $('#tgl_awal').val();	
	var tgl_akhir = $('#tgl_akhir').val();	
	var status_peg = $('#statuspeg').val();	
	$.ajax({
        url: 'sw-mod/job/proses.php?action=reportbln&kd_bidang='+kd_bidang+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir+'&status_peg='+status_peg+'',
        type: 'POST',
		beforeSend: function () {
			$('#loading2').show();	
		},
        success: function(data) {
          $('.loaddatabln').html(data);
		   $('#loading2').hide();
        }
    });
}

function exceldtbln(){
	var kd_bidang = $('#kdbidang').val();
	var tgl_awal = $('#tgl_awal').val();	
	var tgl_akhir = $('#tgl_akhir').val();	
	var status_peg = $('#statuspeg').val();	
	window.open('sw-mod/job/proses.php?action=excelreportbln&kd_bidang='+kd_bidang+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir+'&status_peg='+status_peg+'');
}


