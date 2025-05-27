console.log("Test")
function init(){

}
$(document).ready(function(){
    var usu_id = $('#user_idx').val();
    var rol_id = $('#rol_idx').val();

    if($('#rol_idx').val() ==1){
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
    }else{

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
    }/*else if($('#rol_idx').val() ==3){

    }*/

    $.post("../../controller/ticket.php?op=all_calendar", function (data){
        console.log(data);
    });
});

init();