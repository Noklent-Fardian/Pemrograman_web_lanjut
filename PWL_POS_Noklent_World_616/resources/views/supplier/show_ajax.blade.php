@empty($supplier)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Data Tidak Ditemukan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Data supplier tidak ditemukan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-info-circle mr-2"></i> Detail Supplier
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $supplier->name_supplier }}</h5>
                                <h6 class="card-subtitle mb-3 text-muted">{{ $supplier->supplier_kode }}</h6>
                                
                                <table class="table table-striped">
                                    <tr>
                                        <th width="30%">ID</th>
                                        <td>{{ $supplier->supplier_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kode</th>
                                        <td>{{ $supplier->supplier_kode }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $supplier->name_supplier }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>{{ $supplier->supplier_contact }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $supplier->supplier_email ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $supplier->supplier_alamat ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $supplier->supplier_keterangan ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($supplier->supplier_aktif)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>{{ $supplier->created_at ? $supplier->created_at->format('d M Y H:i:s') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diupdate Pada</th>
                                        <td>{{ $supplier->updated_at ? $supplier->updated_at->format('d M Y H:i:s') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button onclick="modalAction('{{ url('/supplier/' . $supplier->supplier_id . '/edit_ajax') }}')" class="btn btn-primary">
                    <i class="fas fa-edit mr-1"></i> Edit
                </button>
            </div>
            {{-- // punya Nokurento --}}
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.card').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function() {
                $('.card').css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.6s ease-out'
                });
            }, 300);
        });
    </script>
@endempty