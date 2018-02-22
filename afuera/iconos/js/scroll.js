$('#inicio').on('click', function(){
    $('html, body').animate( {scrollTop: 0}, 10);
    //Inicio
    $('#inicio2').css("background","#c7babe");
    $('#inicio2').css("color","white");
    //Acerca de
    $('#acercade2').css("background","none");
    $('#acercade2').css("color","#878787");
    //Servicios
    $('#servicios2').css("background","none");
    $('#servicios2').css("color","#878787");
    //Trabajos
    $('#trabajos2').css("background","none");
    $('#trabajos2').css("color","#878787");
})

$('#acercade').on('click', function(){
    $('html, body').animate( {scrollTop: 1400}, 10);
    //Inicio
    $('#inicio2').css("background","none");
    $('#inicio2').css("color","#878787");
    //Acerca de
    $('#acercade2').css("background","#c7babe");
    $('#acercade2').css("color","white");
    //Servicios
    $('#servicios2').css("background","none");
    $('#servicios2').css("color","#878787");
    //Trabajos
    $('#trabajos2').css("background","none");
    $('#trabajos2').css("color","#878787");
})

$('#servicios').on('click', function(){
    $('html, body').animate( {scrollTop: 2700}, 10);
    //Inicio
    $('#inicio2').css("background","none");
    $('#inicio2').css("color","#878787");
    //Acerca de
    $('#acercade2').css("background","none");
    $('#acercade2').css("color","#878787");
    //Servicios
    $('#servicios2').css("background","#c7babe");
    $('#servicios2').css("color","white");
    //Trabajos
    $('#trabajos2').css("background","none");
    $('#trabajos2').css("color","#878787");
    
})

$('#soporte').on('click', function(){
    $('html, body').animate( {scrollTop: 3500}, 10);
    //Inicio
    $('#inicio2').css("background","none");
    $('#inicio2').css("color","#878787");
    //Acerca de
    $('#acercade2').css("background","none");
    $('#acercade2').css("color","#878787");
    //Servicios
    $('#servicios2').css("background","none");
    $('#servicios2').css("color","#878787");
    //Trabajos
    $('#trabajos2').css("background","#c7babe");
    $('#trabajos2').css("color","white");
})