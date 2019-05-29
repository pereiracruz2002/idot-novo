$(document).ready(function () {

  $('body').on('submit','#send_agendamento',function(e){
            e.preventDefault();
            var url =$('#send_agendamento').attr('action');

            console.log(url);

            var aluno_id = $('#aluno').val();
            var agenda_id = $('#agenda_id').val();
            var tipo_aula = $('#tipo_aula').val();
            var periodo = $('#turma').val();
            var linha = $('#linha').val();
            //var periodo = $('select[name=turma]').val();

            $.ajax({
                     url :url,
                     type : 'post',
                     
                      data : {
                            aluno_id: aluno_id,
                            agenda_id: agenda_id,
                            tipo_aula:tipo_aula,
                            linha:linha,
                            periodo:periodo

                      },
                      
                })
                 .done(function(msg){
                    //alert(msg)
                    $('#myModalAgendamento2').modal('hide');
                    if(msg.status ==1){
                      if(tipo_aula == 1){
                        window.location.href="/admin/agendamento/ver_minha_agenda/"+agenda_id;
                      }else{
                        window.location.href="/admin/agendamento/ver_minha_agenda/"+agenda_id+"/true";
                      }
                    }else{
                      alert(msg.msg);
                    }
                    
                    
                     //location.reload();
                   
                 })
                 .fail(function(jqXHR, textStatus, msg){
                      alert(msg);
                 }); 
    });


    $('body').on('click','.add_presenca',function(e){
        var tipo_aula = $(this).attr('data-presenca');
        var linha = $(this).attr('data-id');
        $("#turma option").hide();
        $("#turma option[data-periodo=dia_"+linha+"]").show();
        $('#linha').val(linha);
        $('#tipo_aula').val(tipo_aula);
        
    });



  $('body').on('submit','#form_nota',function(e){
      e.preventDefault();
      var url =$('#form_nota').attr('action');

      var nota = $('#nota').val();
      var presenca_id = $('#presenca_id').val();
      

      $.ajax({
               url :url,
               type : 'post',
               
                data : {
                      nota: nota,
                      presenca_id: presenca_id,
                      
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


  $('body').on('click','.add_nota_aluno',function(e){
      var presenca_id = $(this).attr('data-presenca');
      $('#presenca_id').val(presenca_id);
  });

});
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

    var init2 = function (reservedSeat) {
        console.log(settings.rows)
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
        
        $('#place').html(str.join(''));
    };

    var init = function (reservedSeat) {
        var str = [], seatNo, className;
        var contador = 1;
        for (i = 0; i < settings_2.rows; i++) {
            for (j = 0; j < settings_2.cols; j++) {
                seatNo = contador;
                className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
                    className += ' ' + settings.selectedSeatCss+'_'+settings.colCssPrefix + j.toString();
                }
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
                contador++;
            }
        }
        $('#place2').html(str.join(''));
    };

    //case I: Show from starting
    //init();

    //Case II: If already booked

    //var bookedSeats = [1,2,3,4,5,6,7,8,9];
    console.log('hey')
    init(bookedSeats);
    init2(bookedSeats);


    

    $('#btnShow').click(function () {
        var str = [];
        $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
            str.push($(this).attr('title'));
        });
        alert(str.join(','));
    })

    $('#btnShowNew').click(function () {
        var str = [], item;
        $.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
            item = $(this).attr('title');                   
            str.push(item);                   
        });
        alert(str.join(','));
    })

    $('.data_dia').on('click',function(){
        var data_dia = $(this).val();
        

        $.post(base_url+"/agendamento/returnDadosDia",
          {
            data_dia: data_dia

          },
          function(data, status){
             $('.dias_semana').each(function( index ) {
                if($( this ).attr('data-dias') != data){
                    $( this ).attr("disabled", true);
                }else{
                    $( this ).removeAttr("disabled", true);
                } 
            });
        });   
    })

    $('.dias_semana').on('click',function(){
        var dias_semana = $(this).val();
        var data_dia = $('.data_dia:checked').val();
        var agenda_id = $('#minha_agenda_id').val();
        $.post(base_url+"/agendamento/returnVagas",
          {
            data_dia: data_dia,
            dias_semana: dias_semana,
            agenda_id:agenda_id
          },
          function(data, status){
           console.log(Object.keys(data).length)
           if(Object.keys(data).length > 0){
            var bookedSeats = [];
            for (i = 0; i < Object.keys(data).length; i++) { 
               bookedSeats.push(parseInt(data[i].mesa));
            }
              
                console.log(bookedSeats)
               
           }else{
                var bookedSeats = [0]; 
           }
            init(bookedSeats);
             teste();
          
        });
           
    })

    function teste(){
        $('.' + settings.seatCss).on('click',function () {

        
        if ($(this).hasClass('selectedSeat_col-0') || $(this).hasClass('selectedSeat_col-1') || $(this).hasClass('selectedSeat_col-2') || $(this).hasClass('selectedSeat_col-3')){
            alert('Esse acento esta reservado');
        }else{
            
            $( "#place li" ).each(function( index ) {
                if($(this).hasClass('selectingSeat_impar') || $(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_impar');
                    
                }

                if($(this).hasClass('selectingSeat_par')){
                   $(this).removeClass('selectingSeat_par');   
                }
                   
            });


            
            $('input[name=mesa]').val($(this).find('a').attr('title'))
            if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
                settings.selectingSeatCss =" selectingSeat_par";
            }else{
                 settings.selectingSeatCss =" selectingSeat_impar";
            }

            $(this).toggleClass(settings.selectingSeatCss);

            var dias_semana = $('.dias_semana:checked').val();
            var data_dia = $('.data_dia:checked').val();
            var agenda_id = $('#minha_agenda_id').val();
            var aluno_id = $('#aluno_id').val();

            $.post(base_url+"/agendamento/trocarData",
              {
                data_dia: data_dia,
                dias_semana: dias_semana,
                agenda_id:agenda_id,
                aluno_id: aluno_id
              },
              function(data, status){
               
               //if(data.status > 0){
                
                   $('.confirmar_presenca').removeClass('hide');
               
               //}  
            });
        }
        
        
    });
    }

    $('.' + settings.seatCss).on('click',function () {
        


        
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


            
          $('input[name=mesa]').val($(this).find('a').attr('title'))
            if ($(this).hasClass('col-0') || $(this).hasClass('col-2')){
                settings.selectingSeatCss =" selectingSeat_par blue_par";
            }else{
                 settings.selectingSeatCss =" selectingSeat_impar blue_impar";
            }

            $(this).toggleClass(settings.selectingSeatCss);

            $.post(base_url+"/agendamento/trocarData",
              {
                data_dia: data_dia,
                dias_semana: dias_semana,
                agenda_id:agenda_id,
                aluno_id: aluno_id
              },
              function(data, status){
               
               //if(data.status > 0){
                
                   $('.confirmar_presenca').removeClass('hide');
               
               //}  
            });
        }
        
        
    });
});