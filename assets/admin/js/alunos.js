
$(function () {
    var settings = {
        rows: 7,
        cols: 6,
        rowCssPrefix: 'row-',
        colCssPrefix: 'col-',
        seatWidth: 35,
        seatHeight: 35,
        seatCss: 'seat',
        selectedSeatCss: 'selectedSeat',
		selectingSeatCss: 'selectingSeat'
    };

    var settings_2 = {
        rows: 5,
        cols: 6,
        rowCssPrefix: 'row-',
        colCssPrefix: 'col-',
        seatWidth: 35,
        seatHeight: 35,
        seatCss: 'seat',
        selectedSeatCss: 'selectedSeat',
        selectingSeatCss: 'selectingSeat'
    };

    var init = function (reservedSeat) {

        var str = [], seatNo, className;
        var contador = 1;
        var assento  = 1;
        for (i = 0; i < settings.rows; i++) {
            for (j = 0; j < settings.cols; j++) {

                seatNo = assento;
                className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
                    className += ' ' + settings.selectedSeatCss+'_'+settings.colCssPrefix + j.toString();
                }
                if(contador != 31 && contador != 37 && contador != 32 && contador != 38){
                        
                    if($('#mesa2').val()==seatNo){
                    str.push('<li class="' + className + ' blue_'+j.toString()+'"' +
                              'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                              '<a title="' + seatNo + '">' + seatNo + '</a>' +
                              '</li>');
                    }else{
                        str.push('<li class="' + className + '"' +
                              'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                              '<a title="' + seatNo + '">' + seatNo + '</a>' +
                              '</li>');
                    }


                    assento++;
                }
                
                contador++;
            }
        }
        $('#place').html(str.join(''));
    };

    var init2 = function (reservedSeat) {

        console.log('init2 carreaga a primeira sala')

        var str = [], seatNo, className;
        var contador = 1;
        var assento  = 1;
        for (i = 0; i < settings_2.rows; i++) {
            for (j = 0; j < settings_2.cols; j++) {

                seatNo = assento;
                className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
                    className += ' ' + settings.selectedSeatCss+'_'+settings.colCssPrefix + j.toString();
                }
                if(contador != 31 && contador != 37 && contador != 32 && contador != 38){
                    
                    if($('#mesa').val()==seatNo){
                        str.push('<li class="' + className + ' blue_'+j.toString()+'"' +
                          'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                          '<a title="' + seatNo + '">' + seatNo + '</a>' +
                          '</li>');
                    }else{
                        str.push('<li class="' + className + '"' +
                          'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                          '<a title="' + seatNo + '">' + seatNo + '</a>' +
                          '</li>');
                    }
                    
                    assento++;
                }
                
                contador++;
            }
        }
        
        $('#place2').html(str.join(''));
    };

    //case I: Show from starting
    //init();

    //Case II: If already booked

    //var bookedSeats = [1,2,3,4,5,6,7,8,9];
    console.log(bookedSeats)
    init(bookedSeats2);
    init2(bookedSeats);


    

    function teste(){
        $('#sala1 .' + settings.seatCss).on('click',function () {
        
            if ($(this).hasClass('selectedSeat_col-0') || $(this).hasClass('selectedSeat_col-1') || $(this).hasClass('selectedSeat_col-2') || $(this).hasClass('selectedSeat_col-3')){
                alert('Esse acento esta reservado');
            }else{
                
                $( "#place2 li" ).each(function( index ) {
                    if($(this).hasClass('selectingSeat_impar') || $(this).hasClass('selectingSeat_par')){
                       $(this).removeClass('selectingSeat_impar');
                        
                        
                    }

                    if($(this).hasClass('selectingSeat_par')){
                       $(this).removeClass('selectingSeat_par');
                        
                    }

                    if($(this).hasClass('blue_par')){
                        $(this).removeClass('blue_par');
                    }

                    if($(this).hasClass('blue_impar')){
                        $(this).removeClass('blue_impar');
                    }
                       
                });


                
                $('input[name=mesa]').val($(this).find('a').attr('title'))
                if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
                    settings.selectingSeatCss =" selectingSeat_par blue_par";
                }else{
                     settings.selectingSeatCss =" selectingSeat_impar blue_impar";
                }

                $(this).toggleClass(settings.selectingSeatCss);

                var dias_semana = $('.dias_semana:checked').val();
                var data_dia = $('.data_dia:checked').val();
                var agenda_id = $('#minha_agenda_id').val();
                var aluno_id = $('#aluno_id').val();

                // $.post(base_url+"/agendamento/trocarData",
                //   {
                //     data_dia: data_dia,
                //     dias_semana: dias_semana,
                //     agenda_id:agenda_id,
                //     aluno_id: aluno_id
                //   },
                //   function(data, status){
                   
                //    //if(data.status > 0){
                    
                //        $('.confirmar_presenca').removeClass('hide');
                   
                //    //}  
                // });
            }
        
        
        });
        
         $('#sala2 .' + settings.seatCss).on('click',function () {

       console.log('aki')

        
        if ($(this).hasClass('selectedSeat_col-0') || $(this).hasClass('selectedSeat_col-1') || $(this).hasClass('selectedSeat_col-2') || $(this).hasClass('selectedSeat_col-3')){
            alert('Esse acento esta reservado');
        }else{

            var dias_semana = $('.dias_semana:checked').val();
            var data_dia = $('.data_dia:checked').val();
            var agenda_id = $('#minha_agenda_id').val();
            var aluno_id = $('#aluno_id').val();

            
        
            $( "#place li" ).each(function( index ) {
                if($(this).hasClass('selectingSeat_impar') || $(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_impar');
                   
                    
                }

                if($(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_par'); 
                     
                }

                if($(this).hasClass('blue_par')){
                    $(this).removeClass('blue_par');
                }

                 if($(this).hasClass('blue_impar')){
                    $(this).removeClass('blue_impar');
                }
                   
            });


            console.log($(this).find('a').attr('title'));
        $('input[name=mesa2]').val($(this).find('a').attr('title'))
            if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
                settings.selectingSeatCss =" selectingSeat_par blue_par";
            }else{
                 settings.selectingSeatCss =" selectingSeat_impar blue_impar";
            }

            $(this).toggleClass(settings.selectingSeatCss);

            
        }
        
        
    });
    }

    $('#sala1 .' + settings.seatCss).on('click',function () {

        console.log('aki na 153')

        
        if ($(this).hasClass('selectedSeat_col-0') || $(this).hasClass('selectedSeat_col-1') || $(this).hasClass('selectedSeat_col-2') || $(this).hasClass('selectedSeat_col-3')){
            alert('Esse acento esta reservado');
        }else{

            var dias_semana = $('.dias_semana:checked').val();
            var data_dia = $('.data_dia:checked').val();
            var agenda_id = $('#minha_agenda_id').val();
            var aluno_id = $('#aluno_id').val();

            
        
            $( "#place2 li" ).each(function( index ) {
                
                if($(this).hasClass('selectingSeat_impar') || $(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_impar');
                
                    
                }

                if($(this).hasClass('blue_par')){
                    $(this).removeClass('blue_par');
                }

                if($(this).hasClass('blue_impar')){
                    $(this).removeClass('blue_impar');
                }

                if($(this).hasClass('selectingSeat_par')){
                    
                   $(this).removeClass('selectingSeat_par'); 
                    
                }
                   
            });


            
        $('input[name=mesa]').val($(this).find('a').attr('title'))
        if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
            settings.selectingSeatCss =" selectingSeat_par blue_par";
        }else{
             settings.selectingSeatCss =" selectingSeat_impar blue_impar";
        }

        $(this).toggleClass(settings.selectingSeatCss);

            
        }
        
        
    });


    $('#sala2 .' + settings.seatCss).on('click',function () {

       console.log('aki')

        
        if ($(this).hasClass('selectedSeat_col-0') || $(this).hasClass('selectedSeat_col-1') || $(this).hasClass('selectedSeat_col-2') || $(this).hasClass('selectedSeat_col-3')){
            alert('Esse acento esta reservado');
        }else{

            var dias_semana = $('.dias_semana:checked').val();
            var data_dia = $('.data_dia:checked').val();
            var agenda_id = $('#minha_agenda_id').val();
            var aluno_id = $('#aluno_id').val();

            
        
            $( "#place li" ).each(function( index ) {
                if($(this).hasClass('selectingSeat_impar') || $(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_impar');
                    
                    
                }

                if($(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_par');
                    
                }

                if($(this).hasClass('blue_par')){
                    $(this).removeClass('blue_par');
                }

                if($(this).hasClass('blue_impar')){
                    $(this).removeClass('blue_impar');
                }
                   
            });


            console.log($(this).find('a').attr('title'));
        $('input[name=mesa2]').val($(this).find('a').attr('title'))
            if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
                settings.selectingSeatCss =" selectingSeat_par blue_par";
            }else{
                 settings.selectingSeatCss =" selectingSeat_impar blue_impar";
            }

            $(this).toggleClass(settings.selectingSeatCss);

            
        }
        
        
    });

    $('select[name=turmas_id]').change(function(){
        var elm = $(this);

        var turma = $(this).val();

        $.post(base_url+"/agendamento/returnVagas",
          {
            turma:turma
          },
          function(data, status){
            
           console.log(Object.keys(data).length)
           if(Object.keys(data.mesas).length > 0){
            var bookedSeats = [];

                if(Object.keys(data.mesas).length == 1){
                    var limite = 1; 
                }else{
                   var limite = Object.keys(data.mesas).length; 
                }
            

                for (i = 0; i < limite; i++) { 
                    console.log(i)
                   bookedSeats.push(parseInt(data.mesas[i].mesa));
                }
              
                console.log(bookedSeats)
               
           }else{
                var bookedSeats = [0]; 
           }



           if(Object.keys(data.mesas).length > 0){
            var bookedSeats2 = [];

                if(Object.keys(data.mesas).length == 1){
                    var limite = 1; 
                }else{
                   var limite = Object.keys(data.mesas).length; 
                }
            

                for (i = 0; i < limite; i++) { 
                    console.log(i)
                   bookedSeats2.push(parseInt(data.mesas[i].mesa2));
                }
              
                
               
           }else{
                var bookedSeats2 = [0]; 
           }

            console.log(bookedSeats)
            init2(bookedSeats);
            init(bookedSeats2);

           // if(data.sala_id==1){
           //      $('#sala1').show();
           //      $('#sala2').hide();
           //      init2(bookedSeats);
           // }else{
           //      $('#sala1').hide();
           //      $('#sala2').show();
           //      init(bookedSeats);
           // }
            
            teste();
        }); 
       
       
    });

    $('body').on('click','#send_agendamento',function(e){
        e.preventDefault();
       
       
        var url =$('#form_agendamento').attr('action');

        var aluno_id = $('#aluno').val();
        var agenda_id = $('#agenda_id').val();

        $.ajax({
                 url :url,
                 type : 'post',
                 
                  data : {
                        aluno_id: aluno_id,
                        agenda_id: agenda_id,

                  },
                  
            })
             .done(function(msg){
                alert(msg)
                 location.reload();
               
             })
             .fail(function(jqXHR, textStatus, msg){
                  alert(msg);
             }); 
    });
});