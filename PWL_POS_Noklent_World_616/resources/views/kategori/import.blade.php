<form action="{{ url('/kategori/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('excel/template_kategori.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Format Excel harus sesuai template dengan kolom:
                    <ul class="mb-0 pl-4 mt-1">
                        <li><strong>Kolom A:</strong> Kode Kategori</li>
                        <li><strong>Kolom B:</strong> Nama Kategori</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_kategori" id="file_kategori" class="form-control" required>
                    <small id="error-file_kategori" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_kategori: {
                    required: true,
                    extension: "xlsx"
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                
                var $submitBtn = $(form).find('button[type="submit"]');
                var originalText = $submitBtn.html();
                
                // Disable button and show loading state
                $submitBtn.prop('disabled', true);
                $submitBtn.html('<i class="fas fa-circle-notch fa-spin"></i> Processing...');

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Reset button state on error
                            $submitBtn.prop('disabled', false);
                            $submitBtn.html(originalText);
                            
                            $('.error-text').text('');
                            
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            
                            // Show specific validation errors if available
                            if (response.errors && response.errors.length > 0) {
                                let errorList = '';
                                response.errors.forEach(function(error) {
                                    errorList += '<li>' + error + '</li>';
                                });
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    html: response.message + '<ul class="text-left mt-2">' + errorList + '</ul>'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Reset button state on AJAX error
                        $submitBtn.prop('disabled', false);
                        $submitBtn.html(originalText);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>