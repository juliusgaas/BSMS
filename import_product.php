    <form id="uploadForm">
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
        
    </form>

    <div id="message" style="margin-top: 2rem;">
        <a href="./download-template.php" target="_blank" rel="noopener noreferrer">Download Template CSV</a>
    </div>

    <script>
    $('#uploadForm').on('submit', function(e){
        e.preventDefault();
         var formData = new FormData(this);
         $('.pop_msg').remove()
        var _this = $(this)
        var _el = $('<div>')
            _el.addClass('pop_msg')
        $('#uni_modal button').attr('disabled',true)
        $('#uni_modal button[type="submit"]').text('submitting form...')

       

        $.ajax({
            url: 'upload.php', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
               
                    _el.addClass('alert alert-success')
                    $('#uni_modal').on('hide.bs.modal',function(){
                        location.reload()
                    })
                       
                  
                    _el.text(response)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
            },
            error: function(xhr){
                _el.addClass('alert alert-danger')
            }
        });
    });
    </script>