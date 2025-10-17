@extends('admin.maindesign')

@section('orders')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Customer Info -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Customer</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong><br>{{ $order->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong><br>{{ $order->user->email ?? 'N/A' }}</p>
                    <p><strong>No. Telepon:</strong><br>{{ $order->user->phone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Order</h6>
                </div>
                <div class="card-body">
                    <p><strong>Order ID:</strong><br>#{{ $order->id }}</p>
                    <p><strong>Tanggal:</strong><br>{{ $order->created_at->format('d M Y H:i') }}</p>
                    <p><strong>Payment Method:</strong><br>
                        @if($order->payment_method == 'transfer_bank')
                            <span class="badge badge-info">Transfer Bank</span>
                        @elseif($order->payment_method == 'qris')
                            <span class="badge badge-primary">QRIS</span>
                        @elseif($order->payment_method == 'cod')
                            <span class="badge badge-warning">COD</span>
                        @endif
                    </p>
                    <p><strong>Shipping Method:</strong><br>{{ $order->shipping_method ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Status -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label><strong>Payment Status:</strong></label>
                            <select name="payment_status" class="form-control" required>
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="success" {{ $order->payment_status == 'success' ? 'selected' : '' }}>
                                    Success
                                </option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>
                                    Failed
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-save"></i> Update Status
                        </button>
                    </form>

                    @if($order->paid_at)
                        <p class="mt-3 mb-0"><strong>Paid At:</strong><br>{{ $order->paid_at->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Item Order</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->name }}</strong><br>
                                    <small class="text-muted">{{ $item->store_name }}</small>
                                </td>
                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->qty }}</td>
                                <td><strong>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge badge-secondary">Pending</span>
                                    @elseif($item->status == 'processed')
                                        <span class="badge badge-info">Processed</span>
                                    @elseif($item->status == 'shipped')
                                        <span class="badge badge-primary">Shipped</span>
                                    @elseif($item->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-danger">Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $item->address }}</small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            data-toggle="modal" data-target="#statusModal{{ $item->id }}">
                                        <i class="fa fa-edit"></i> Update
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Update Status Item -->
                            <div class="modal fade" id="statusModal{{ $item->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Status Item</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.orders.updateItemStatus', $item) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label><strong>Status:</strong></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>
                                                            Pending
                                                        </option>
                                                        <option value="processed" {{ $item->status == 'processed' ? 'selected' : '' }}>
                                                            Processed
                                                        </option>
                                                        <option value="shipped" {{ $item->status == 'shipped' ? 'selected' : '' }}>
                                                            Shipped
                                                        </option>
                                                        <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>
                                                        <option value="canceled" {{ $item->status == 'canceled' ? 'selected' : '' }}>
                                                            Canceled
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal Items:</strong></td>
                            <td colspan="4"><strong>Rp{{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Shipping Cost:</strong></td>
                            <td colspan="4"><strong>Rp{{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Service Fee:</strong></td>
                            <td colspan="4"><strong>Rp{{ number_format($order->service_fee ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr class="table-active">
                            <td colspan="3" class="text-right"><strong>TOTAL:</strong></td>
                            <td colspan="4"><strong class="text-primary">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
