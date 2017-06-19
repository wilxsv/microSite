function func(enlace)
 {
    //make the ajax call
    $.ajax({
        url: enlace,
        type: 'POST',
        data: {institucion : $( "#idinstitucionelaboro" ).val(),
			
			},
        success: function(result) {
            console.log("Data sent!");
            $('#resultado').html("Entro a mi ajax."+selectedValue+" - "+$( "#institucionpresenta" ).val()+result);
        }
    });
}
