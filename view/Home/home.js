function init(){

}
var usu_id = $('#user_idx').val();
var rol_id = $('#rol_idx').val();
var suc_id = $('#suc_idx').val();
var area_id = $('#area_idx').val();
$(document).ready(function(){
    
    if($('#rol_idx').val() == 1){
        $.post("../../controller/usuario.php?op=total", {usu_id: usu_id}, function (data){
            data=JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalabierto", {usu_id: usu_id}, function (data){
            data=JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id: usu_id}, function (data){
            data=JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=grafico", {usu_id:usu_id},function (data) {
            data = JSON.parse(data);
            console.log(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value'],
                barColors: ["#1AB244"], 
            });
        }); 

        $('#idcalendar').fullCalendar({
            lang:'es',
            header:{
                left: 'prev, next today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            defaultView: 'month',
            events:{
                url: '../../controller/ticket.php?op=usu_calendar',
                method:'POST',
                data: {usu_id: usu_id}
            }
        });
    }else if($('#rol_idx').val() == 2){

        $.post("../../controller/ticket.php?op=total_x_sup",{area_id: area_id, suc_id: suc_id}, function (data){
            data=JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalabierto_sup", {area_id: area_id, suc_id: suc_id},function (data){
            data=JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalcerrado_sup",{area_id: area_id, suc_id: suc_id}, function (data){
            data=JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=grafico_sup",{area_id: area_id, suc_id: suc_id},function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value']
            });
        }); 

        $('#idcalendar').fullCalendar({
            lang:'es',
            header:{
                left: 'prev, next today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            defaultView: 'month',
            events:{
                url: '../../controller/ticket.php?op=sup_calendar',
                method:'POST',
                data: {area_id: area_id, suc_id: suc_id}
            }
        });
    }else if($('#rol_idx').val() == 3){
        $.post("../../controller/ticket.php?op=total", function (data){
            data=JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalabierto", function (data){
            data=JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalcerrado", function (data){
            data=JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=grafico",function (data) {
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value']
            });
        }); 

        $('#idcalendar').fullCalendar({
            lang:'es',
            header:{
                left: 'prev, next today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            defaultView: 'month',
            events:{
                url: '../../controller/ticket.php?op=all_calendar'
            }
        });
    }

    $.post("../../controller/ticket.php?op=all_calendar", function (data){
        //console.log(data);
    });
});

init();